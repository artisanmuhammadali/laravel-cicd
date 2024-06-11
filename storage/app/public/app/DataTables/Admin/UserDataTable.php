<?php

namespace App\DataTables\Admin;

use App\Models\User;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
             ->addColumn('referal_type', function ($query) {
                return  '<span class="badge bg-primary text-capitalize">'.$query->referal_type .'</span>';
            })
            ->filterColumn('referal_type', function($query, $keyword) {
                $query->whereHas('store',function($q)use($keyword){
                        $q->WhereRaw("referal_type LIKE ?", ["%$keyword%"]);
                });
            })
            ->addColumn('hear_about_us', function ($query) {
                return  $query->store ? $query->store->hear_about_us : "";
            })
            ->filterColumn('hear_about_us', function($query, $keyword) {
                $query->whereHas('store',function($q)use($keyword){
                        $q->WhereRaw("hear_about_us LIKE ?", ["%$keyword%"]);
                });
            })
            ->addColumn('newsletter', function ($query) {
                return  $query->store->newsletter == null ? "No" : "Yes" ;
            })
            ->addColumn('survey', function ($query) {
                return  $query->sellerProgram ? "Yes" : "No";
            })
            ->filterColumn('survey', function($query, $keyword) {
                if(stripos('Yes', $keyword) !== false)
                {
                    $query->whereHas('sellerProgram');
                }
                else
                {
                    $query->whereDoesntHave('sellerProgram');
                }
            })
            ->filterColumn('newsletter', function($query, $keyword) {
                if(stripos('Yes', $keyword) !== false)
                {
                    $query->whereHas('store',function($q)use($keyword){
                        $q->where('newsletter','!=',null);
                    });
                }
                else
                {
                    $query->whereHas('store',function($q)use($keyword){
                        $q->where('newsletter',null);
                    });
                }
            })
            ->addColumn('action',function ($query){
                $item = $query;
                return view('admin.user.components.action',get_defined_vars());
            })
            ->editColumn('role',function ($query){
                $item = $query->role;
               return view('admin.user.components.badges',get_defined_vars());
            })
            ->editColumn('email_verified_at',function ($query){
               return $query->email_verified_at ? 'Verified' : "Not Verified";
            })
            ->filterColumn('email_verified_at', function($query, $keyword) {
                if(stripos('verified', $keyword) !== false)
                {
                    $query->where('email_verified_at','!=',null);
                }
                else
                {
                    $query->where('email_verified_at',null);
                }
            })
            ->editColumn('verified',function ($query){
                return $query->verified == 1 ? 'Yes' : "No";
            })
            ->filterColumn('verified', function($query, $keyword) {
                if(stripos('yes', $keyword) !== false)
                {
                    $query->where('verified',1);
                }
                else
                {
                    $query->where('verified',0);
                }
            })
            ->editColumn('status',function ($query){
                $item = $query->status;
               return view('admin.user.components.badges',get_defined_vars());
            })
            ->editColumn('referr_by', function ($query) {
                $ful_name = $query->referr ? $query->referr->full_name : '';
                $ref = $query->referr_by ? '<div class="d-flex text-center">
                <a target="_blank" href="'.route('admin.user.detail',[$query->referr_by, 'info']).'">'. $ful_name.'</a>
            </div>' : 'N/A';
                return $ref;
            })
            ->filterColumn('referr_by', function($query, $keyword) {
                $query->whereHas('referr',function($q)use($keyword){
                    $q->WhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$keyword%"]);
                });
            })
            ->editColumn('created_at', function ($query) {
                return $query->created_at->format('Y-m-d');
            })
            ->rawColumns(['action','image','referal_type','referr_by']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    
     public function query()
    {
        $model = User::query()->where('deleted_at',null)->where('role', '!=', 'admin')
            ->when($this->type != null, function ($q) {
                $q->whereHas('store', function ($qu) {
                    $qu->when($this->type == "marketing-users" ,function($que){
                        $que->where('hear_about_us','!=',null);
                    })
                    ->when($this->type != "marketing-users" ,function($que){
                        $que->where('referal_type', $this->type);
                    });
                });
            })
            ->when($this->status != null, function ($q) {
                $q->where('status', $this->status);
            })
            ->when($this->status == null, function ($q) {
                $q->whereNotIn('status', ['banned','locked']);
            });

        // Remove conflicting order statement to let Yajra DataTables handle it
        return $this->applyScopes($model);
    }


    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('dataTable')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('<"row align-items-center"<"col-md-2" l><"col-md-6" B><"col-md-4"f>><"table-responsive my-3" rt><"row align-items-center" <"col-md-6" i><"col-md-6" p>><"clear">')
            ->parameters([
                "buttons" => [
                    'excel',
                ],
                "processing" => true,
                "autoWidth" => false,
                'initComplete' => "function () {
                            $('.dt-buttons').addClass('btn-group btn-group-sm')
                            this.api().columns().every(function (colIndex) {
                                var column = this;
                                var input = document.createElement(\"input\");
                                input.className = \"form-control form-control-sm h-3\";
                                $(input).appendTo($(column.footer()).empty())
                                .on('keyup change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                    column.search(val ? val : '', false, false, true).draw();
                                });

                                $('#dataTable thead').append($('#dataTable tfoot tr'));
                            });


                        }",
                'drawCallback' => "function () {
                        }"
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            ['data' => 'user_name', 'name' => 'user_name', 'title' => 'Name', 'orderable' => true,'searchable' => true,'width'=>30],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email', 'orderable' => true,'searchable' => true,'width'=>30],
            ['data' => 'role', 'name' => 'role', 'title' => 'Role', 'orderable' => true,'searchable' => true,'width'=>30],
            ['data' => 'referal_type', 'name' => 'referal_type', 'title' => 'Referral Type', 'orderable' => false,'searchable' => true,'width'=>30],
            ['data' => 'referr_by', 'name' => 'referr_by', 'title' => 'Referred by', 'orderable' => false,'searchable' => true,'width'=>30],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created at', 'orderable' => true,'searchable' => true,'width'=>30,],
            ['data' => 'hear_about_us', 'name' => 'hear_about_us', 'title' => 'Hear About Us', 'orderable' => true,'searchable' => true ,'width'=>40],
            ['data' => 'newsletter', 'name' => 'newsletter', 'title' => 'Newsletter', 'orderable' => true,'searchable' => true ,'width'=>20],
            ['data' => 'survey', 'name' => 'survey', 'title' => 'Survey', 'orderable' => true,'searchable' => true ,'width'=>20],
            ['data' => 'email_verified_at', 'name' => 'email_verified_at', 'title' => 'Verified Email', 'orderable' => true,'searchable' => true ,'width'=>20],
            ['data' => 'verified', 'name' => 'verified', 'title' => 'Verified Kyc', 'orderable' => true,'searchable' => true ,'width'=>20],
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->orderable(false)
                ->width(10)
                ->addClass('text-center hide-search'),
            
        ];
    }

      /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Export_' . date('YmdHis');
    }

   /**
    * Get filename for export.
    *
    * @return string
    */
    protected function sheetName() : string
    {
        return "Yearly Report";
    }

    // public function excel()
    // {
    //     // TODO: Implement excel() method.
    // }

    // public function csv()
    // {
    //     // TODO: Implement csv() method.
    // }

    // public function pdf()
    // {
    //     // TODO: Implement pdf() method.
    // }
}
