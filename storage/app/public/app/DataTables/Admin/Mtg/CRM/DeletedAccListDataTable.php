<?php

namespace App\DataTables\Admin\Mtg\CRM;

use App\Models\User;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Database\Eloquent\Builder;

class DeletedAccListDataTable extends DataTable
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
        ->addColumn('name', function ($query) {
            return $query->full_name ?? "";
        })
        ->filterColumn('name', function($query, $keyword) {
            $query->WhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$keyword%"]);
        })
         ->addColumn('referal_type', function ($query) {
            return  '<span class="badge bg-primary text-capitalize">'.$query->referal_type .'</span>';
        })
        ->filterColumn('referal_type', function($query, $keyword) {
            $query->whereHas('store',function($q)use($keyword){
                    $q->WhereRaw("referal_type LIKE ?", ["%$keyword%"]);
            });
        })
        
        ->addColumn('action',function ($query){
            $item = $query;
            return view('admin.user.components.action',get_defined_vars());
        })
        ->editColumn('role',function ($query){
            $item = $query->role;
           return view('admin.user.components.badges',get_defined_vars());
        })
        ->editColumn('status',function ($query){
            $item = $query->status;
           return view('admin.user.components.badges',get_defined_vars());
        })
        ->editColumn('type',function ($query){
            $item = $query->type;
           return view('admin.user.components.badges',get_defined_vars());
        })
        ->filterColumn('type', function($query, $keyword) {
            $query->WhereRaw("type LIKE ?", ["%$keyword%"]);
        })
        ->editColumn('deleted_at', function ($query) {
            return $query->deleted_at->format('Y-m-d');
        })
        ->rawColumns(['action','image','referal_type']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = User::onlyTrashed()->latest('deleted_at');
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
            ['data' => 'name', 'name' => 'name', 'title' => 'Name', 'orderable' => true,'searchable' => true,'width'=>30],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email', 'orderable' => true,'searchable' => true,'width'=>30],
            ['data' => 'role', 'name' => 'role', 'title' => 'Role', 'orderable' => true,'searchable' => true,'width'=>30],
            ['data' => 'type', 'name' => 'type', 'title' => 'Type', 'orderable' => true,'searchable' => true,'width'=>30],
            ['data' => 'referal_type', 'name' => 'referal_type', 'title' => 'Referral Type', 'orderable' => true,'searchable' => true,'width'=>30],
            ['data' => 'deleted_at', 'name' => 'deleted_at', 'title' => 'Deleted at', 'orderable' => true,'searchable' => true,'width'=>30,],
         
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
