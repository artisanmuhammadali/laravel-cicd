<?php

namespace App\DataTables\Admin\User;

use App\Models\Conversation;
use App\Models\User;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserConversationDataTable extends DataTable
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
            ->addColumn('sender', function ($query) {
                return $query->sender->user_name ?: '';
            })
            ->filterColumn('sender', function($query, $keyword) {
                $query->whereHas('sender',function($q)use($keyword){
                        $q->WhereRaw("user_name LIKE ?", ["%$keyword%"]);
                });
            })
            ->addColumn('receiver', function ($query) {
                return $query->receiver->user_name ?: '';
            })
            ->filterColumn('receiver', function($query, $keyword) {
                $query->whereHas('receiver',function($q)use($keyword){
                        $q->WhereRaw("user_name LIKE ?", ["%$keyword%"]);
                });
            })
            ->addColumn('chat', function ($query) {
                return '<a href="'.route('admin.mtg.chat').'?id='.$query->id.'" class=" text-center btn btn-warning">
                Chat
                </a>';
            })
            ->rawColumns(['receiver' ,'sender','chat']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = Conversation::query()

                        ->where('sender_id',$this->id)
                        ->orWhere('receiver_id',$this->id);
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
            ['data' => 'sender', 'name' => 'sender', 'title' => 'Sender', 'orderable' =>false ,'width'=>20,'searchable' => true],
            ['data' => 'receiver', 'name' => 'receiver', 'title' => 'Receiver', 'orderable' =>false ,'width'=>20],
            ['data' => 'chat', 'name' => 'chat', 'title' => 'Chat', 'orderable' =>true ,'width'=>20],
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
