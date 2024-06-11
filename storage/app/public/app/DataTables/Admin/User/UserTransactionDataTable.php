<?php

namespace App\DataTables\Admin\User;

use App\Models\MTG\MtgUserCollection;
use App\Models\Transaction;
use App\Models\User;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserTransactionDataTable extends DataTable
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
            ->addColumn('credit', function ($query) {
                return $query->creditUser->full_name  ?? "";
            })
            ->filterColumn('credit', function($query, $keyword) {
                $query->whereHas('creditUser',function($q)use($keyword){
                        $q->WhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$keyword%"]);
                });
            })
            ->filterColumn('type', function($query, $keyword) {
                $query->WhereRaw("type LIKE ?", ["%$keyword%"]);
            })
             ->addColumn('debit', function ($query) {
                return $query->debitUser->full_name  ?? "";
            })
            ->filterColumn('debit', function($query, $keyword) {
                $query->whereHas('debitUser',function($q)use($keyword){
                        $q->WhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$keyword%"]);
                });
            })
            ->addColumn('type', function ($query) {
                $type = $query->type;
               return view('admin.transaction.badges',get_defined_vars());
            })

            ->editColumn('amount', function ($query) {
                return '£'.$query->amount;
            })
            ->editColumn('created_at', function ($query) {
                return $query->created_at->format('Y-m-d');
            })
            ->addColumn('action',function ($query){
                $item = $query;
                return view('admin.transaction.action',get_defined_vars());
            })
            ->rawColumns(['action' ]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = Transaction::query()->where('credit_user',$this->id)->orWhere('debit_user',$this->id);
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
            ['data' => 'credit', 'name' => 'credit', 'title' => 'Credit', 'orderable' =>false],
            ['data' => 'debit', 'name' => 'debit', 'title' => 'Debit', 'orderable' =>false],
            ['data' => 'type', 'name' => 'type', 'title' => 'Type', 'orderable' =>false],
            ['data' => 'amount', 'name' => 'amount', 'title' => 'Amount', 'orderable' =>true],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created At', 'orderable' =>true],
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->orderable(false)
                ->width(10)
                ->addClass('text-center hide-search')

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
