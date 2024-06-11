<?php

namespace App\DataTables\Admin\Sw;

use App\Models\SW\SwCard;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
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
            ->addColumn('image', function ($query) {
                $img = $query->png_image;
                $name = $query->name;
                return view('admin.components.datatable.hover-img',get_defined_vars());
            })
            ->addColumn('set_code',function($query){
                return $query->set ? $query->set->code : '-';
            })
            ->filterColumn('set_code',function($query , $keyword){
                return $query->whereHas('set',function($q)use($keyword){
                            $q->Where('code',$keyword);
                        });
            })
            ->editColumn('name',function($query){
                return '<a target="_blank" href="'.route('sw.expansion.detail',[$query->set->slug, $query->url_type ,$query->slug]).'">'.$query->name.'</a>';
            })
            ->addColumn('action',function($query){
                return view('admin.sw.products.action',get_defined_vars());

            })
            
            ->rawColumns(['action','image','name']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = SwCard::query()->where('card_type',$this->type)->whereNull('parent_id')
        ->when($this->exp ,function($quer){
            $quer->where('sw_set_id',$this->exp);
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
                    // 'excel',
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
            Column::computed('image')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->width(100)
                ->addClass('text-center hide-search'),
            ['data' => 'name', 'name' => 'name', 'title' => 'Name', 'orderable' => true],
            ['data' => 'set_code', 'name' => 'set_code', 'title' => 'Set Code', 'orderable' => true],
            // ['data' => 'hp', 'name' => 'hp', 'title' => 'HP', 'orderable' => false],
            // ['data' => 'power', 'name' => 'power', 'title' => 'Power', 'orderable' => false],
            // ['data' => 'cost', 'name' => 'cost', 'title' => 'Cost', 'orderable' => true],
            ['data' => 'rarity', 'name' => 'rarity', 'title' => 'Rarity', 'orderable' => true],
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
