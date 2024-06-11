<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentCard;

class PaymentCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name'=>'Mastercard',
                'provider'=>'MASTERCARD',                
                'type'=>'CB_VISA_MASTERCARD',
                'percentage_fee'=>1.4,
                'fixed_fee'=>0.25,
            ],
            [
                'name'=>'Visa',
                'provider'=>'VISA',                
                'type'=>'CB_VISA_MASTERCARD',
                'percentage_fee'=>1.4,
                'fixed_fee'=>0.25,
            ],
            [
                'name'=>'American Express (AMEX)',
                'provider'=>'AMEX',                
                'type'=>'AMEX',
                'percentage_fee'=>2.95,
                'fixed_fee'=>0.25,
            ],
            [
                'name'=>'Carte Bancaire (CB)',
                'provider'=>'CB',                
                'type'=>'CB_VISA_MASTERCARD',
                'percentage_fee'=>1.4,
                'fixed_fee'=>0.25,
            ],
            [
                'name'=>'Maestro',
                'provider'=>'MAESTRO',                
                'type'=>'MAESTRO',
                'percentage_fee'=>1.6,
                'fixed_fee'=>0.25,
            ],
            [
                'name'=>'Bancontact',
                'provider'=>'BCMC',                
                'type'=>'BCMC',
                'percentage_fee'=>1.6,
                'fixed_fee'=>0.25,
            ],
        ];
        PaymentCard::insert($data);
    }
}
