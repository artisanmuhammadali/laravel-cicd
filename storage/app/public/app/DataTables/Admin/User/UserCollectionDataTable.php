<?php

namespace App\DataTables\Admin\User;

use App\Models\MTG\MtgUserCollection;
use App\Models\User;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserCollectionDataTable extends DataTable
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
            ->editColumn('publish', function ($query) {
                $status = $query->publish ? 'active' : 'inactive';
                $color = $query->publish ? 'success' : 'danger';
                return '<span class="badge bg-'.$color.'">'.$status.'</span>';
            })
            ->addColumn('name', function ($query) {
                return '<div class="d-flex text-center">
                    <a target="_blank" href="'.route('mtg.expansion.detail',[$query->card->url_slug, $query->card->url_type ,$query->card->slug]).'">'.$query->card->name.'</a>
                </div>';
            })
            ->filterColumn('name', function($query, $keyword) {
                $query->whereHas('card',function($q)use($keyword){
                        $q->WhereRaw("name LIKE ?", ["%$keyword%"]);
                });
            })
            ->addColumn('set', function ($query) {
                return '<div class="d-flex text-center">
                <img title="'.$query->card->set->name.'" src="'.$query->card->set->icon .'" class="m-auto"
                    height="40" width="40" alt="Angular">
                </div>';
            })
             ->addColumn('characteristics', function ($query) {
                $item = $query;
                return view('admin.user.components.collection.charecteristics',get_defined_vars());
            })
            ->rawColumns(['characteristics' ,'set','name','publish']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = MtgUserCollection::query()
                        ->where('user_id',$this->id);
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
            ['data' => 'name', 'name' => 'name', 'title' => 'Name', 'orderable' =>false ,'width'=>20,'searchable' => true],
            ['data' => 'set', 'name' => 'set', 'title' => 'Set', 'orderable' =>false ,'width'=>20],
            ['data' => 'publish', 'name' => 'publish', 'title' => 'Status', 'orderable' =>true ,'width'=>20],
            ['data' => 'price', 'name' => 'price', 'title' => 'Price', 'orderable' =>true ,'width'=>20],
            ['data' => 'quantity', 'name' => 'quantity', 'title' => 'Quantity', 'orderable' => true,'width'=>20],
            Column::computed('characteristics')
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
