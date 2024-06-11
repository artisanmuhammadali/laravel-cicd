<?php

namespace App\Services\Admin\MTG;

use App\Models\MTG\MtgUserCollectionCsv;
use GuzzleHttp\Client;
use App\Imports\ImportCollection;
use App\Models\MTG\MtgCard;
use App\Models\MTG\MtgSet;
use App\Models\MTG\MtgUserCollection;
use App\Traits\MTG\ImportUserCollectionCsvTrait;
use Exception;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;


class importCsvCollection {

    use ImportUserCollectionCsvTrait;
   public function import()
   {
        $already = MtgUserCollectionCsv::where('imported',0)->where('status','processing')->orderBy('id','asc')->first();
        $csv = MtgUserCollectionCsv::where('imported',0)->where('status','pending')->orderBy('id','asc')->first();
        if($csv && !$already)
        {
            ini_set('memory_limit', '1024M');
            $csv->status = 'processing';
            $csv->save();
            Log::info('Csv file execution start :'.$csv->name);
            try{
                $extension = pathinfo($csv->name, PATHINFO_EXTENSION);
                // dd($extension);
                $client = new Client();
                $response = $client->get($csv->file);
                $response = $response->getBody()->getContents();

                $filepath = 'app/public/'.$csv->id.$csv->name;
                $tempFilePath = storage_path($filepath);
                file_put_contents($tempFilePath, $response);
                if($extension == "csv")
                {
                    $this->importCsv($csv , $tempFilePath);
                }
                else{
                    Excel::import(new ImportCollection($csv->id), $tempFilePath);
                }
                    
                unlink($tempFilePath);
                $csv->imported = true;
                $csv->status = 'Import Successfully';
                $csv->save();
                $csv->refresh();
                Log::info('Csv file execution ended :'.$csv->name);
            }
            catch(Exception $e)
            {
                Log::info('Error In CSV Import');
                Log::info($e);
                $csv->total = session('total_collection') ?? 0;
                $csv->success = session('success_collection') ?? 0;
                $csv->imported = true;
                $csv->status = "Failed";
                $csv->save();
            }
            sendMail([
                'view' => 'email.csv-upload-alert',
                'to' => $csv->user->email,
                'subject' => 'CSV Uploaded Successfully',
                'data' => [
                    'user_name'=>$csv->user->user_name,
                    'csv'=>$csv,
                ]
            ]);
        }
        return true; 
   }
}
