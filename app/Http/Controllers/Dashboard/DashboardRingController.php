<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\User_group;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Ring;
use App\Models\Type;

class DashboardRingController extends Controller
{
    public function index() {
      return view('dashboard.rings.rings');
    }

    public function rings() {
      $types = Type::all();
      $rings = Ring::join('types', 'rings.type_id', '=', 'types.id')
      ->select('rings.*', 'types.name as type_name')
      ->get();

      return view('dashboard.rings.rings', compact('rings', 'types'));
    }


    public function updateRing(Ring $ring, PostRequest $r) {
      $r->validate([
        'type' => ['required', 'numeric'],
        'name' => ['string', 'max:255'],
        'description' => ['string', 'max:255'],
        'size' => ['required', 'numeric'],
        'price' => ['required', 'numeric'],
    ]);

      $ring->type_id = $r->type;
      $ring->name = $r->name;
      $ring->description = $r->description;
      $ring->size = $r->size;      
      $ring->price = $r->price;

      $ring->updated_at = date("Y-M-d h:m:s");

      
      $ring->save();

      return redirect()->route('rings.home');
  }

  public function createRing(Ring $ring, PostRequest $r) {
    $r->validate([
      'type' => ['required', 'numeric'],
      'name' => ['string', 'max:255'],
      'description' => ['string', 'max:255'],
      'size' => ['required', 'numeric'],
      'price' => ['required', 'numeric'],
  ]);

    $ring->type_id = $r->type;
    $ring->name = $r->name;
    $ring->description = $r->description;
    $ring->size = $r->size;      
    $ring->price = $r->price;

    $ring->created_at = date("Y-M-d h:m:s");
    
    $ring->save();

    return redirect()->route('rings.home');
}
}