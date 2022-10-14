<?php

namespace App\Listeners;

use App\Events\PaymentUpdated;
use GuzzleHttp\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Hash;

class SendPaymentData implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PaymentUpdated $event)
    {
        $payment = $event->payment;

        if ($payment->merchant_id !== 6) return;

        try {
            $merchant_key = 'KaTf5tZYHx4v7pgZ';
            $client = new Client();

            $response = $client->post('callback_url', [
                'headers' => [
                    'Accept' => 'application/json'
                ],
                'json' => [
                    "merchant_id" => $payment->merchant_id,
                    "payment_id" => $payment->payment_id,
                    "status" => $payment->status,
                    "amount" => $payment->amount,
                    "amount_paid" => $payment->amount_paid,
                    "timestamp" => $payment->timestamp,
                    "sign" => $payment->sign
                ]
            ]);

            if ($response->getStatusCode() == 200) {
                $sha256 = "$payment->merchant_id:$payment->payment_id:$payment->status:$payment->amount:$payment->amount_paid:$payment->timestamp:$merchant_key";
                $hash = Hash::make($sha256);
                \Log::error($hash);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }
}
