<?php

namespace App\DataTables\Admin;

use App\Models\UserEmail;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserEmailDataTable extends DataTable
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
            ->editColumn('user_id', function ($query) {
                return '<div class="d-flex text-center">
                    <a target="_blank" href="'.route('admin.user.detail',[$query->user_id, 'info']).'">'. $query->emailTo->user_name ?? "".'</a>
                </div>';
            })
            ->filterColumn('user_id', function($query, $keyword) {
                $query->whereHas('emailTo',function($q)use($keyword){
                        $q->WhereRaw("user_name LIKE ?", ["%$keyword%"]);
                });
            })
            ->addColumn('user_email', function ($query) {
                return $query->emailTo->email;
            })
            ->filterColumn('user_email', function($query, $keyword) {
                $query->whereHas('emailTo',function($q)use($keyword){
                        $q->WhereRaw("email LIKE ?", ["%$keyword%"]);
                });
            })
            ->editColumn('created_at', function ($query) {
                return $query->created_at->format('Y-m-d');
            })
            ->rawColumns(['user_id']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = UserEmail::query()->where('email_id',$this->id);
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
            ['data' => 'user_id', 'name' => 'user_id', 'title' => 'User Name', 'orderable' => true],
            ['data' => 'user_email', 'name' => 'user_email', 'title' => 'Email', 'orderable' => true],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created at', 'orderable' => true,'searchable' => true],
            
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
