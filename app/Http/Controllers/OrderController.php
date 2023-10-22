<?php

namespace App\Http\Controllers;

use App\Models\Orders_item;
use App\Models\Order;
use App\Models\Ring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mollie\Laravel\Facades\Mollie;
use App\Http\Controllers\PaymentController;
use App\Rules\MultipleOfFive;

class OrderController extends Controller
{

    public function index()
    {
        $currentDate = Date("m");
        if ($currentDate >= 10) {
            $isLaterThanOctober = 'true';
        } else {
            $isLaterThanOctober = 'false';
        }

        $rings = Ring::join('types', 'rings.type_id', '=', 'types.id')
        ->select('rings.*', 'types.name as type_name')
        ->get();

        return view('order.index', compact('rings', 'isLaterThanOctober'));
    }

    public function placeOrder(Request $r)
    {
        //Validation
        $r->validate([
            'ringId' => ['numeric', new MultipleOfFive],
            'delivery' => ['required', 'string'],
            'payment' => ['required', 'string'],
            'remarks' => ['nullable', 'string', 'max:255'],
        ]);

        // Calculates total price of order
        $total_price =  $this->calculate_totalprice($r->ringId, $r->delivery, $r);

        // place new order
        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->total_price = $total_price;
        $order->remarks = $r->remarks;
        $order->status = 'Niet betaald';
        $order->save();

        // calculate ring number and save it in the db
        $this->save_calculated_ringnr_as_orderitem($r, $order->id);

        if ($r->payment === "mollie") {
            // If buyer has chosen to pay with Mollie, they get redirected to the payment page.
            return redirect()->route('payment', ['order_id' => $order->id, 'total_price' => $total_price]);
        } else {
            // else redirect to order detail page
            return redirect('/order/' . $order->id)->with('ordered', 'Je bestelling is goed binnengekomen! Vergeet niet om te betalen!');
        }
    }

    public function show($id)
    {
        // get order from id
        $order = Order::where('id', $id)->first();
        $order_items = Orders_item::where('order_id', $id)->get();

        return view('order.show', compact('order', 'order_items'));
    }

    private function calculate_totalprice($ringId, $deliveryCost, $r)
    {
        // Select all rings from database
        $rings = Ring::all();

        // Declares a global 'empty' variable to save total price
        global $totalprice;

        // Calculates total price per type of ring and adds this price to the total price of the complete order
        foreach ($rings as $ring) {
            // Concanates ring_ and id from database, because the ids input fields in the form are in the format ring_id
            $ringId = 'ring_' . $ring->id;


            // Gets the amount of rings ordered of type from the form
            $ordered_amount = $r->$ringId;

            // Function only needs to run if there are rings ordered of the type.
            if ($ordered_amount > 0) {

                // Calculates price per type by multiplying amount from form and price from database
                $price = ($ordered_amount) * ($ring->price);
                // print_r($price);

                // Adds calculated price to totalprice
                $totalprice += $price;
                // print_r($totalprice);

            }
        }
        //Adds delivery method to endprice
        $totalprice += $deliveryCost;

        return $totalprice;
    }

    private function save_calculated_ringnr_as_orderitem($r, $order_id)
    {
        // Select all rings from database
        $rings = Ring::all();

        // Declares 'empty' array to save used sizes
        $used_sizes = [];

        foreach ($rings as $ring) {
            // Concanates ring_ and id from database, because the ids input fields in the form are in the format ring_id
            $ringId = 'ring_' . $ring->id;

            // Amount of rings ordered of type
            $ordered_amount = $r->$ringId;

            // Function only needs to run if there are rings ordered of the type.
            if ($ordered_amount > 0) {

                // If this ring size is in the array of used_sizes, it means this rings save was also ordered in another material. In that case, we take the last used number of that size.
                if (array_key_exists($ring->size, $used_sizes)) {
                    $current_lastnumber = $used_sizes[$ring->size];
                } else {
                    // The current number is 000
                    $current_lastnumber = 000; //TODO: Change to number from database
                }

                // Declares empty array to save the used numbers
                $used_numbers = [];

                // Declares empty array to save the used complete numbers
                $used_complete_codes = [];

                $i = 0;

                // For every ordered ring
                while ($i < $ordered_amount) {
                    $current_lastnumber++;

                    //Save lastnumber in used numbers
                    array_push($used_numbers, str_pad($current_lastnumber, 3, '0', STR_PAD_LEFT));

                    // Parts of the complete number
                    $club = 'ABAP';
                    $stamnumber = Auth::user()->stamnr;
                    $binnendiameter = $ring->size;
                    $country = "B";
                    $year = date("Y");
                    $umpteenth_number = str_pad($current_lastnumber, 3, '0', STR_PAD_LEFT);

                    // Complete number
                    $complete_number = $club . ' ' . $stamnumber . ' ' . $binnendiameter . ' ' . $country . ' ' . $year . ' ' . $umpteenth_number;

                    //Save complete number in used codes
                    array_push($used_complete_codes, $complete_number);

                    $i++;
                }

                // Save the last number of this size in used sizes.
                $used_sizes[$ring->size] = $current_lastnumber;

                // The first used ring number, str_pad to fit format.
                $first_ring_number = str_pad($used_numbers[0], 3, '0', STR_PAD_LEFT);

                // The last used ring number, str_pad to fit format.
                $last_ring_number = str_pad(end($used_numbers), 3, '0', STR_PAD_LEFT);

                $validationRules = [];

                // Saves in the database
                $r->validate($validationRules);
                $volgnumber = new Orders_item();
                $volgnumber->ring_id = $ring->id;
                $volgnumber->order_id = $order_id;
                $volgnumber->amount = $ordered_amount;
                $volgnumber->ring_codes = implode(",", $used_complete_codes);
                $volgnumber->first_ring_number = $first_ring_number;
                $volgnumber->last_ring_number = $last_ring_number;
                $volgnumber->save();
            }
        }
    }
}
