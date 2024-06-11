<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;


class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        City::where('id','!=',0)->delete();
        $path = public_path('cities.txt');
        $list = file_get_contents($path);
        $list = explode(',',$list);
        foreach($list as $item){
            City::insert(['name'=>$item]);
        }
    }
}
