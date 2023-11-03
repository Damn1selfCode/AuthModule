<?php

namespace Database\Seeders;

use App\Models\PaymentPlatform;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentPlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('payment_platforms')->truncate();
        PaymentPlatform::create(
            [
                'name' => 'Paypal',
                'image' => 'img/plataforma_pago/Paypal.jpg'
            ],
            [
                'name' => 'MercadoPago',
                'image' => 'img/plataforma_pago/Mercadopago.png'
            ]
        );
    }
}
