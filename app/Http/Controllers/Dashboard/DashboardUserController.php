<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

use App\Models\Role;
use App\Models\User;
use App\Models\User_group;

use Illuminate\Http\Request;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Order;
use Illuminate\Validation\Rule;

class DashboardUserController extends Controller
{
  public function users(Request $request)
  {

    $query = User::orderBy('stamnr', 'DESC');

    $this->applyFilters($request, $query);

    $users = $query->get();

    return view('dashboard.users.users', compact('users'));
  }

  public function showUsers(User $user)
  {

    $orders = Order::where('user_id', $user->id)->get();

    return view('dashboard.users.show', compact('user', 'orders'));
  }

  public function editUsers(User $user)
  {

    $roles = Role::all();
    $groups = User_group::all();

    // dd($roles);

    return view('dashboard.users.edit', compact('user', 'roles', 'groups'));
  }

  public function updateUsers(User $user, ProfileUpdateRequest $r)
  {
    $r->validate([
      'firstname' => ['string', 'max:255'],
      'lastname' => ['string', 'max:255'],
      'role' => ['numeric'],
      'group' => ['numeric'],
      'active' => ['numeric'],
      'phone' => ['string', 'digits_between:9,12'],
      'email' => ['string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
      'address_street' => ['string', 'max:255'],
      'address_nr' => ['numeric'],
      'address_zipcode' => ['numeric', 'digits:4'],
      'address_city' => ['string', 'max:255'],

    ]);

    $user->firstname = $r->firstname;
    $user->lastname = $r->lastname;

    $user->role_id = $r->role;
    $user->group_id = $r->group;
    $user->active = $r->active;

    $user->phone = $r->phone;
    $user->email = $r->email;

    $user->address_street = $r->street;
    $user->address_nr = $r->number;
    $user->address_zipcode = $r->zipcode;
    $user->address_city = $r->city;

    $user->updated_at = date("Y-M-d h:m:s");

    $user->save();

    return redirect()->route('users.home');
  }

  private function applyFilters(Request $request, $query)
  {

    if ($request->filled('stamnr')) {
      $stamnr = $request->input('stamnr');
      $query->where(function ($query) use ($stamnr) {
        $query->where('users.stamnr', 'LIKE', "%$stamnr%");
      });
    }

    if ($request->filled('name')) {
      $name = $request->input('name');
      $query->where(function ($query) use ($name) {
        $query->where('users.firstname', 'LIKE', "%$name%")
          ->orWhere('users.lastname', 'LIKE', "%$name%");
      });
    }
  }
}
