<?php

namespace App\DataTables\Admin;

use App\Models\EmailMarketing;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MarketingEmailDataTable extends DataTable
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
            ->editColumn('sent_by', function ($query) {
                return  $query->sender->user_name;
            })->filterColumn('sent_by', function($query, $keyword) {
                $query->whereHas('sender',function($q)use($keyword){
                        $q->WhereRaw("user_name LIKE ?", ["%$keyword%"]);
                });
            })->editColumn('status', function ($query) {
                return  '<span class="badge bg-primary text-capitalize">'.$query->status .'</span>';
            })->editColumn('newsletter', function ($query) {
                return  '<span class="badge bg-primary text-capitalize">'. $query->newsletter .'</span>';
            })->editColumn('referal_type', function ($query) {
                return  '<span class="badge bg-primary text-capitalize">'. $query->referal_type .'</span>';
            })->editColumn('role', function ($query) {
                return  '<span class="badge bg-primary text-capitalize">'. $query->role .'</span>';
            })->editColumn('unverified', function ($query) {
                return '<span class="badge bg-primary text-capitalize">'. $query->unverified .'</span>';
            }) ->addColumn('action',function ($query){
                return view('admin.marketing.action',get_defined_vars());
            })
            ->editColumn('created_at', function ($query) {
                return $query->created_at->format('Y-m-d');
            })
            ->rawColumns(['action','sent_by','status','newsletter','referal_type','role','unverified']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = EmailMarketing::query();
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
                'order' => [
                    7, // here is the column number
                    'desc'
                ],
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
            ['data' => 'sent_by', 'name' => 'sent_by', 'title' => 'Sender', 'orderable' => true],
            ['data' => 'subject', 'name' => 'subject', 'title' => 'Subject', 'orderable' => true],
            ['data' => 'newsletter', 'name' => 'newsletter', 'title' => 'Users', 'orderable' => true],
            ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => true],
            ['data' => 'referal_type', 'name' => 'referal_type', 'title' => 'Referral type', 'orderable' => true],
            ['data' => 'role', 'name' => 'role', 'title' => 'Role', 'orderable' => true],
            ['data' => 'unverified', 'name' => 'unverified', 'title' => 'KYC/KYB', 'orderable' => true],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created at', 'orderable' => true,'searchable' => true],
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
