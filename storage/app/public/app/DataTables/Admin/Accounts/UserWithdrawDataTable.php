<?php

namespace App\DataTables\Admin\Accounts;

use App\Models\MTG\MtgUserCollection;
use App\Models\Order;
use App\Models\PayoutRequest;
use App\Models\User;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserWithdrawDataTable extends DataTable
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
            
            ->addColumn('user', function ($query) {
                return '<div class="d-flex text-center">
                    <a target="_blank" href="'.route('admin.user.detail',[$query->user, 'info']).'">'. $query->user->user_name ?? "".'</a>
                </div>';
            })
            ->filterColumn('user', function($query, $keyword) {
                $query->whereHas('user',function($q)use($keyword){
                        $q->WhereRaw("user_name LIKE ?", ["%$keyword%"]);
                });
            })
            ->addColumn('updated_by', function ($query) {
                return $query->updated_by ? $query->admin->user_name : 'N/A';
            })
            ->filterColumn('updated_by', function($query, $keyword) {
                $query->whereHas('admin',function($q)use($keyword){
                        $q->WhereRaw("user_name LIKE ?", ["%$keyword%"]);
                });
            })
            ->editColumn('created_at', function ($query) {
                return $query->created_at->format('Y-m-d');
            })
            ->editColumn('status',function ($query){
                $statuses = withdrawStatus();
                $bg = $statuses[$query->status];
                return '<span class="bagde '.$bg. ' text-white p-25 rounded text-capitalize" >'.$query->status.'</span>';
            })
            ->addColumn('action',function($query){
                $item = $query;
                return view('admin.accounts.withdraw.action',get_defined_vars());
            })
            ->rawColumns(['user','status','action','updated_by']);
            
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = PayoutRequest::query();
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
                    4, // here is the column number
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
            ['data' => 'user', 'name' => 'user', 'title' => 'User', 'orderable' =>true,'searchable' => true],
            ['data' => 'updated_by', 'name' => 'updated_by', 'title' => 'Updated By', 'orderable' =>true,'searchable' => true],
            ['data' => 'amount', 'name' => 'amount', 'title' => 'Amount', 'orderable' =>false,'searchable' => true],
            ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' =>false,'searchable' => true],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created at', 'orderable' =>true,'searchable' => true],
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
