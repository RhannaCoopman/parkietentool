<?php

use App\Http\Controllers\DashboardController as ControllersDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Dashboard\DashboardController as DashboardController;
use App\Http\Controllers\Dashboard\DashboardUserController as DashboardUserController;
use App\Http\Controllers\Dashboard\DashboardRingController as DashboardRingController;
use App\Http\Controllers\Dashboard\DashboardOrderController as DashboardOrderController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Routes for everyone

//Homepage
Route::get('/', [HomeController::class, 'index'])->name('home.index');


// Routes for logged in users
Route::middleware('auth.user')->group(function () {
    //ORDER ROUTES
    //Order page
    Route::get('/order', [OrderController::class, 'index'])->name('home.index');

    // Place the order from the order page
    Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('home.index');

    // Detailpage of order
    Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');

    // Payment of the order
    Route::get('/payment', [PaymentController::class, 'paymentWithMollie'])->name('payment');

    // Webhook of Mollie
    Route::post('/webhooks/mollie', [WebhookController::class, 'handle'])->name('webhooks.mollie');

    // If order is a succes
    Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');

    //PROFILE ROUTES
    Route::get('/myprofile', [ProfileController::class, 'index'])->name('profile.index');
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/myprofile/order/{id}', [ProfileController::class, 'order'])->name('profile.order');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/payMembership/{id}', [PaymentController::class, 'paymentMembershipSubscription'])->name('profile.payMembership');

});


// Routes for admin
Route::middleware('auth.admin')->group(function () {
    //Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.home');

    // Dashboard - Users
    Route::get('/dashboard/users', [DashboardUserController::class, 'users'])->name('users.home');
    Route::get('/dashboard/show/{user}', [DashboardUserController::class, 'showUsers'])->name('dashboard.users.show');
    Route::get('/dashboard/edit/{user}', [DashboardUserController::class, 'editUsers'])->name('dashboard.users.edit');
    Route::put('/dashboard/update/{user}', [DashboardUserController::class, 'updateUsers'])->name('dashboard.users.update');
    Route::delete('/dashboard/users/delete/{user}', [DashboardUserController::class, 'users'])->name('dashboard.users.delete');

    // Dashboard - Rings
    Route::get('/dashboard/rings', [DashboardRingController::class, 'rings'])->name('rings.home');
    Route::put('/dashboard/rings/update/{ring}', [DashboardRingController::class, 'updateRing'])->name('dashboard.rings.update');
    Route::post('/dashboard/rings/create', [DashboardRingController::class, 'createRing'])->name('dashboard.rings.create');

    // Dashboard - Orders
    Route::get('/dashboard/orders', [DashboardOrderController::class, 'orders'])->name('orders.home');
    Route::post('/dashboard/orders/export', [DashboardOrderController::class, 'exportExcel'])->name('dashboard.orders.export');
    Route::get('/dashboard/orders/export-pdf/{orderId}', [DashboardOrderController::class, 'exportPdf'])->name('dashboard.orders.export-pdf');
    Route::get('/dashboard/orders/edit/{order}', [DashboardOrderController::class, 'editOrder'])->name('dashboard.orders.edit');
    Route::put('/dashboard/orders/update/{order}', [DashboardOrderController::class, 'updateOrder'])->name('dashboard.orders.update');
    Route::get('/dashboard/orders/detail/{order}', [DashboardOrderController::class, 'showOrder'])->name('dashboard.orders.detail');
});

require __DIR__ . '/auth.php';
