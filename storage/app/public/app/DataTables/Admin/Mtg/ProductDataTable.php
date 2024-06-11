<?php

namespace App\DataTables\Admin\Mtg;

use App\Models\MTG\MtgCard;
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
            ->addColumn('heading',function($query){
                return $query->seo->heading ?? $query->name;
            })
            ->filterColumn('heading',function($query , $keyword){
                return $query->whereHas('seo',function($q)use($keyword){
                            $q->WhereRaw("heading LIKE ?", ["%$keyword%"]);
                        });
            })
            ->editColumn('name',function($query){
                return '<a target="_blank" href="'.route('mtg.expansion.detail',[$query->url_slug, $query->url_type ,$query->slug]).'">'.$query->name.'</a>';
            })
            ->addColumn('action',function ($item){
                $type = $this->type;
                return view('admin.mtg.products.action',get_defined_vars());
            })
            ->rawColumns(['action','image' ,'name']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = MtgCard::query()->whereHas('set')
        ->when($this->type == 'new_arrival',function($quer){
            $quer->where('card_type','single')->where('is_active',0);
        })->when($this->type!= 'new_arrival',function($quer){
            $active = $this->type2 == 'new_arrival' ? 0 : 1;
            $quer->where('card_type',$this->type)->where('is_active',$active);
        })
        ->when($this->set != null,function($quer){
            $quer->where('set_code',$this->set);
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
            ['data' => 'heading', 'name' => 'heading', 'title' => 'Heading', 'orderable' => false],
            ['data' => 'set_code', 'name' => 'set_code', 'title' => 'Set Code', 'orderable' => true],
            ['data' => 'weight', 'name' => 'weight', 'title' => 'Weight', 'orderable' => true],
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->orderable(false)
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
