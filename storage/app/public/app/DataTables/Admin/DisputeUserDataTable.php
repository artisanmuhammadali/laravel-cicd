<?php

namespace App\DataTables\Admin;

use App\Models\Order;
use App\Models\User;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DisputeUserDataTable extends DataTable
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
            ->editColumn('status', function ($query) {
                if($query->status == "dispute"){
                   return '<span class="badge bg-danger">Open</span>';
                }
                else{
                   return '<span class="badge bg-primary">Closed</span>';
                }
            })
            ->editColumn('buyer', function ($query) {
                return $query->buyer ?  '<div class="d-flex">
                <img src="'.$query->buyer->main_image.'" class="me-75"
                    height="20" width="20" alt="Angular">
                    <span class="fw-bold"><a href="'.route('admin.user.detail',[$query->buyer->id , 'info']).'" target="_blank">'.$query->buyer->user_name.'</a></span>
                </div>' : '';
            })
            ->filterColumn('buyer', function($query, $keyword) {
                $query->whereHas('buyer',function($q)use($keyword){
                        $q->WhereRaw("user_name LIKE ?", ["%$keyword%"]);
                });
            })
            ->editColumn('seller', function ($query) {
                return $query->seller ?  '<div class="d-flex">
                <img src="'.$query->seller->main_image.'" class="me-75"
                    height="20" width="20" alt="Angular">
                    <span class="fw-bold"><a href="'.route('admin.user.detail',[$query->seller->id , 'info']).'" target="_blank">'.$query->seller->user_name.'</a></span>
                </div>' : '';
            })
            ->filterColumn('seller', function($query, $keyword) {
                $query->whereHas('seller',function($q)use($keyword){
                        $q->WhereRaw("user_name LIKE ?", ["%$keyword%"]);
                });
            })
            ->filterColumn('status',function($query , $keyword){
                if(stripos('Open', $keyword) !== false)
                {
                    $query->where('status','dispute');
                }
                else
                {
                    $query->where('status','!=','dispute');
                }
            })
            ->addColumn('actions', function ($query) {
                $query;
                return view('admin.disputeUsers.action',get_defined_vars());
            })
            ->rawColumns(['seller','buyer' ,'actions' , 'status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $ids = User::where('deleted_at',null)->pluck('id')->toArray();
        $model = Order::query()
                        ->whereHas('buyer')
                        ->whereHas('seller')
                        ->where('reason','!=',null);
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
            ['data' => 'id', 'name' => 'id', 'title' => 'Order Id', 'orderable' => true,'searchable' => true,'width'=>30],
            ['data' => 'buyer', 'name' => 'buyer', 'title' => 'Buyer', 'orderable' => true,'searchable' => true,'width'=>30],
            ['data' => 'seller', 'name' => 'seller', 'title' => 'Seller', 'orderable' => true,'searchable' => true,'width'=>30],
            ['data' => 'reason', 'name' => 'reason', 'title' => 'Reason', 'orderable' => true,'searchable' => true,'width'=>30],
            ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => true,'searchable' => true,'width'=>30,],
            ['data' => 'actions', 'name' => 'actions', 'title' => 'Actions', 'orderable' => true,'searchable' => true,'width'=>30,],

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
