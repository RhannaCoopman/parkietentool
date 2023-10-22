<?php

namespace App\Http\Controllers;

use League\CommonMark\Environment\Environment;
use Mollie\Laravel\Facades\Mollie;
use Illuminate\Http\Request;



class PaymentController extends Controller
{
    public function paymentWithMollie(Request $request)
    {
        $order_id = $request->input('order_id');
        $total_price = $request->input('total_price');


        $webhookUrl = route('webhooks.mollie');

        // if (App::environment('local')) {
        //     $webhookUrl = 'https://a4b2-2a02-1811-940d-1700-b518-2cde-6080-6f60.ngrok-free.app/webhooks/mollie';
        // }

        $totalPriceFormatted = number_format($total_price, $decimals = 2, $decimal_separator = ".", $thousands_separator = " ");


        $payment = Mollie::api()->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => $totalPriceFormatted // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            "description" => "Payment",
            "redirectUrl" => route('payment.success', ['order_id' => $order_id]),
            "webhookUrl" => 'https://a4b2-2a02-1811-940d-1700-b518-2cde-6080-6f60.ngrok-free.app/webhooks/mollie',
            "metadata" => [
                "order_id" => $order_id,
            ],
        ]);

        // redirect customer to Mollie checkout page
        return redirect($payment->getCheckoutUrl(), 303);
    }

    public function paymentMembershipSubscription($id)
    {
        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey("test_nwaW289SakfK8j8UUP5dRxcBsV4cPT");

        $customer = $mollie->customers->get($id);
        $customer->createSubscription([
            "amount" => [
                "currency" => "EUR",
                "value" => "26.00",
            ],
            "times" => '',
            "interval" => "12 months",
            "startdate" => Date("Y") . "/10/01",
            "description" => "Jaarlijks lidgeld",
            "webhookUrl" => "https://a4b2-2a02-1811-940d-1700-b518-2cde-6080-6f60.ngrok-free.app/webhooks/mollie",
        ]);
    }

    public function paymentSuccess(Request $request)
    {
        $order_id = $request->input('order_id');
        return redirect('/order/' . $order_id)->with('ordered', 'Je bestelling is goed binnengekomen en betaald!');
    }
}
