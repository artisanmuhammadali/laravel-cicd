<?php

namespace App\DataTables\Admin\User;

use App\Models\MTG\MtgUserCollection;
use App\Models\Order;
use App\Models\User;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserOrderDataTable extends DataTable
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
                return '<div class="d-flex text-center">
                    <a target="_blank" href="'.route('admin.user.detail',[$query->seller, 'info']).'">'. $query->seller->user_name ?? "".'</a>
                </div>';
            })
            ->filterColumn('seller', function($query, $keyword) {
                $query->whereHas('seller',function($q)use($keyword){
                        $q->WhereRaw("user_name LIKE ?", ["%$keyword%"]);
                });
            })
             ->addColumn('buyer', function ($query) {
                return '<div class="d-flex text-center">
                    <a target="_blank" href="'.route('admin.user.detail',[$query->buyer, 'info']).'">'. $query->buyer->user_name ?? "".'</a>
                </div>';
            })
            ->filterColumn('buyer', function($query, $keyword) {
                $query->whereHas('buyer',function($q)use($keyword){
                        $q->WhereRaw("user_name LIKE ?", ["%$keyword%"]);
                });
            })
            ->addColumn('type',function ($query){
                $type = $query->buyer_id == $this->id ? 'Purchase' : 'Sale';
                return '<span class="bagde bg-primary text-white p-25 rounded" >'.$type.'</span>';
            })
            ->filterColumn('type',function($query , $keyword){
                if(stripos('Purchase', $keyword) !== false)
                {
                    $query->where('buyer_id',$this->id);
                }
                else
                {
                    $query->where('seller_id',$this->id);
                }
            })
            ->editColumn('status',function ($query){
                $statuses = [
                    'pending'=>'bg-primary',
                    'cancelled'=>'bg-danger',
                    'dispatched'=>'bg-info',
                    'dispute'=>'bg-secondary',
                    'refunded'=>'bg-warning',
                    'refund'=>'bg-warning',
                    'completed'=>'bg-success',
                ];
                $bg = $statuses[$query->status];
                return '<span class="bagde '.$bg. ' text-white p-25 rounded text-capitalize" >'.$query->status.'</span>';
            })
            ->addColumn('action',function($query){
                $item = $query;
                return view('admin.orders.action',get_defined_vars());
            })
            ->rawColumns(['type','status','action','buyer','seller']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = Order::query()
                        ->where('seller_id',$this->id , function($q){
                            $q->orWhere('buyer_id',$this->id);
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
        return [
            ['data' => 'id', 'name' => 'id', 'title' => 'Id', 'orderable' =>true,'searchable' => true],
            ['data' => 'seller', 'name' => 'seller', 'title' => 'Seller Id', 'orderable' =>false,'searchable' => true],
            ['data' => 'buyer', 'name' => 'buyer', 'title' => 'Buyer Id', 'orderable' =>false,'searchable' => true],
            ['data' => 'type', 'name' => 'type', 'title' => 'Type', 'orderable' =>true,'searchable' => true],
            ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => true,'searchable' => true],
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->orderable(false)
                ->width(20)
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
