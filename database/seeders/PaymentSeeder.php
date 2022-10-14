<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = collect([
            (object)[
                "merchant_id" => 6,
                "payment_id" => 13,
                "status" => "completed",
                "amount" => 500,
                "amount_paid" => 500,
                "timestamp" => 1654103837,
                "sign" => "f027612e0e6cb321ca161de060237eeb97e46000da39d3add08d09074f931728"
            ],
        ]);

        $items->each(function ($item) {
            $model = new Payment();
            $model->merchant_id = $item->merchant_id;
            $model->payment_id = $item->payment_id;
            $model->status = $item->status;
            $model->amount = $item->amount;
            $model->amount_paid = $item->amount_paid;
            $model->timestamp = $item->timestamp;
            $model->sign = $item->sign;
            $model->save();
        });
    }
}
