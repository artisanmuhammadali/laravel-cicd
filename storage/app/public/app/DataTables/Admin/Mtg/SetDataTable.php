<?php

namespace App\DataTables\Admin\Mtg;

use App\Models\User;
use App\Models\MTG\MtgSet;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SetDataTable extends DataTable
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
            ->editColumn('icon', function ($query) {
                $img = $query->icon;
                $name = $query->name;
                return view('admin.components.datatable.hover-img',get_defined_vars());
            })
            ->editColumn('name',function($query){
                $url = $query == "child" ? route('mtg.expansion.type', [$query->parent->slug , $query->url_type]) : route('mtg.expansion.set', $query->slug);
                return '<a target="_blank" href="'.$url.'">'.$query->heading ?? $query->name.'</a>';
            })
            ->editColumn('released_at', function ($query) {
                return date('Y/m/d', strtotime($query->released_at));
            })
            ->addColumn('parent', function ($query) {
                return $query->parent ? $query->parent->code : 'None';
            })
            ->filterColumn('parent', function($query, $keyword) {
                $query->when($keyword == 'none',function($que){
                       $que->whereDoesntHave('parent');
                })->when($keyword != 'none', function($que) use($keyword){
                    $que->whereHas('parent', function($q) use($keyword){
                        $q->where('code', 'like', '%' . $keyword . '%');
                    });
                });
            })
            ->addColumn('single_count', function ($query) {
                return $query->single_count ?? '0';
            })
            ->filterColumn('single_count',function($query ,$keyword){
                $query->whereHas('cards', function ($q) use ($keyword) {
                    $q->havingRaw('COUNT(*) = ?', [$keyword]);
                });
            })
            ->addColumn('inactive_count', function ($query) {
                return '<a target="_blank" href="'.route('admin.mtg.products.index','new_arrival').'?set='.$query->code.'">'.$query->inactive_count.'<i class="fa fa icon-long-arrow-right"></i></a>'?? '0';
            })
            ->filterColumn('inactive_count',function($query ,$keyword){
                $query->whereHas('cards', function ($q) use ($keyword) {
                    $q->where('card_type', 'single')
                    ->havingRaw('COUNT(*) = ?', [$keyword]);
                });
            })
            ->addColumn('action',function ($query){
                $item = $query;
                return view('admin.mtg.sets.action',get_defined_vars());
            })
            ->rawColumns(['action','icon','parent','name','inactive_count']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = MtgSet::query()->when($this->type && $this->type == 'new_arrival',function($quer){
            $quer->where('is_active',0);
        })->when($this->type && $this->type != 'new_arrival',function($quer){
            $quer->where('type',$this->type)->where('is_active',1);
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
            ['data' => 'icon', 'name' => 'icon', 'title' => 'Icon','width'=>50,'searchable' => false, 'orderable' => false],
            ['data' => 'name', 'name' => 'name', 'title' => 'Name', 'orderable' => true],
            ['data' => 'code', 'name' => 'code', 'title' => 'Code', 'orderable' => true],
            ['data' => 'set_type', 'name' => 'set_type', 'title' => 'Set Type', 'orderable' => true],
            ['data' => 'released_at', 'name' => 'released_at', 'title' => 'Released At', 'orderable' => true],
            ['data' => 'parent', 'name' => 'parent', 'title' => 'Parent', 'searchable' => true, 'orderable' => false],
            ['data' => 'single_count', 'name' => 'single_count', 'title' => 'Card Count', 'searchable' => true, 'orderable' => false],
            ['data' => 'inactive_count', 'name' => 'inactive_count', 'title' => 'Inactive Cards', 'searchable' => true, 'orderable' => false],
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->width(60)
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
