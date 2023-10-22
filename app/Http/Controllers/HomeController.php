<?php

namespace App\Http\Controllers;

use App\Models\Orders_item;
use App\Models\Order;
use App\Models\Ring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mollie\Laravel\Facades\Mollie;
use App\Http\Controllers\PaymentController;

class HomeController extends Controller
{

    public function index()
    {
        return view('home.index');
    }
}
