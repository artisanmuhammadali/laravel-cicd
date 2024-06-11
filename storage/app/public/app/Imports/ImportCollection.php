<?php

namespace App\Imports;

use App\Models\MTG\MtgCard;
use App\Models\MTG\MtgCardLanguage;
use App\Models\MTG\MtgSet;
use App\Models\MTG\MtgUserCollection;
use App\Models\MTG\MtgUserCollectionCsv;
use App\Traits\MTG\ImportUserCollectionCsvTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\AfterSheet;

class ImportCollection implements ToCollection, WithHeadingRow, WithEvents, WithStartRow
{

    use ImportUserCollectionCsvTrait;
    private $id;
    public function __construct($id) {
        $this->id = $id;
    }
    public function headingRow(): int
    {
        return 1;
    }

    public function startRow(): int
    {
        return 1;
    }

    public function collection(Collection $rows)
    {
        $csv = MtgUserCollectionCsv::find($this->id);
        $header = $rows[0];
        unset($rows[0]);
        $this->arrangeData($rows , $csv , $header);
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // dd($event);
                $sheet = $event->sheet->getDelegate();
                $sheet->insertNewRowBefore(1, 3);
            },
        ];

    }
}
