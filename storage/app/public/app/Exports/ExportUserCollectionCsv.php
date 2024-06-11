<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportUserCollectionCsv implements FromCollection, WithHeadings
{
    protected $collection;
    protected $header;

    public function __construct(Collection $collection , $header)
    {
        $this->collection = $collection;
        $this->header = $header;
    }

    public function collection()
    {
        return $this->collection;
    }

    public function headings(): array
    {
        return $this->header;
    }
}
