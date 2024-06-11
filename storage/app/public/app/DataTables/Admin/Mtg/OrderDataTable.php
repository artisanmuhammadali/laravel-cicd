<?php

namespace App\DataTables\Admin\Mtg;

use App\Models\Order;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class OrderDataTable extends DataTable
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
            ->addColumn('seller', function ($query) {
                
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
            ->addColumn('buyer', function ($query) {
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
            ->addColumn('action',function ($query){
                $item = $query;
                return view('admin.orders.action',get_defined_vars());
            })
            ->editColumn('created_at', function ($query) {
                return $query->created_at->format('Y-m-d');
            })
            ->editColumn('refund',function($query){
                return $query->refund_amount;
            })
            
            ->rawColumns(['action','seller','buyer']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = Order::when($this->type != "dispute-orders" ,function($q){
            $q->where('status',$this->type);
        })
        ->when($this->type == "dispute-orders" ,function($q){
            $q->where('status','dispute');
        });
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
        $cols= [
            ['data' => 'id', 'name' => 'id', 'title' => 'Order #', 'orderable' => true],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Placed On', 'orderable' => true],
            ['data' => 'seller', 'name' => 'seller', 'title' => 'Seller', 'orderable' => false],
            ['data' => 'buyer', 'name' => 'buyer', 'title' => 'Buyer', 'orderable' => false],
            ['data' => 'transaction_id', 'name' => 'transaction_id', 'title' => 'Transaction Id', 'orderable' => true],
            ['data' => 'total', 'name' => 'total', 'title' => 'Total ( £ )', 'orderable' => true],            
        ];
        $refund_cols =array_merge($cols ,[['data' => 'refund', 'name' => 'refund', 'title' => 'Refund Amount ( £ )', 'orderable' => true],['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false]]);
        $cols = array_merge($cols ,[['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false]]);
        return $this->type == "refunded" ? $refund_cols : $cols;
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
