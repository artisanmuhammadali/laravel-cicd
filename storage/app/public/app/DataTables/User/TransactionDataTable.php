<?php

namespace App\DataTables\User;

use App\Models\Transaction;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use \MangoPay\MangoPayApi as MangoPay;
use Illuminate\Support\Facades\Config;

class TransactionDataTable extends DataTable
{

    private $mangoPayApi;

    public function __construct()
    {   
        $data = Config::get('helpers.mango_pay');
        $this->mangoPayApi = new MangoPay();
        $this->mangoPayApi->Config->ClientId = $data['client_id'];
        $this->mangoPayApi->Config->ClientPassword = $data['client_password'];
        $this->mangoPayApi->Config->TemporaryFolder = '../../';
        $this->mangoPayApi->Config->BaseUrl = $data['base_url'];
        // $this->mangoPayApi->Config->BasGBPl = 'https://api.sandbox.mangopay.com';
    }
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
                return $query->creditUser->full_name ?? "";
            })
            ->addColumn('debit', function ($query) {
                return $query->debitUser->full_name ?? "";
            })
            
            ->addColumn('type', function ($query) {
                $type = $query->type;
               return view('user.transaction.badges',get_defined_vars());
            })
            ->filterColumn('type', function($query, $keyword) {
                $query->WhereRaw("type LIKE ?", ["%$keyword%"]);
            })
            ->editColumn('created_at', function ($query) {
                return $query->created_at->format('Y-m-d');
            })
            ->editColumn('amount', function ($query) {
                return '£'.$query->amount;
            })
            ->addColumn('action',function ($query){
                $item = $query;
                return view('user.transaction.action',get_defined_vars());
            })
            ->rawColumns(['credit','debit']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $walletId = $this->id;
        $transactions = $this->mangoPayApi->Wallets->GetTransactions($walletId);
        $model = collect($transactions);
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
            Column::computed('credit')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->width(25)
                ->addClass('text-center hide-search'),
            Column::computed('debit')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->orderable(false)
                ->width(25)
                ->addClass('text-center hide-search'),
            ['data' => 'amount', 'name' => 'amount', 'title' => 'Amount', 'orderable' => false,'width'=>10,'searchable' => true],
            Column::computed('type')
                ->exportable(false)
                ->printable(false)
                ->searchable(true)
                ->orderable(false)
                ->width(20)
                ->addClass('text-center hide-search'),
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'created at', 'orderable' => false,'searchable' => true,'width'=>10],
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
