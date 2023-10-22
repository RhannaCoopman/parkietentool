@extends('layouts.app')

@section('content')
<h1>Show order # {{$order->id}}</h1>

@if (session('success'))
<div class="alert alert-success">
  {{ session('success') }}
</div>
@endif

<a href="{{ route('dashboard.orders.export-pdf', $order->id) }}" class="btn btn-primary">Export PDF</a>

<h2>Bestel gegevens</h2>
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Totaal aantal ringen: </th>

      <th scope="col">Totale prijs: </th>
      <th scope="col">Betaald:</th>
      <th scope="col">Betaal data:</th>
      <th scope="col">Verzend datum: </th>
      <th scope="col">Geplaatst op:</th>
      <th scope="col">Aangepast op: </th>
      <th scope="col">Opmerkingen door klant</th>
      <th scope="col">Opmerkingen door Admin</th>
      <th scope="col">Pas bestelling aan</th>


    </tr>
  </thead>
  <tbody>


    <tr>
      <th scope="row">{{ $order->id }}</th>
      <td>{{ $ordered_amount_rings }}</td>
      <td>{{ $order->total_price}}</td>

      @switch($order->status)
      @case('Niet betaald')
      <td class="table-danger">{{ $order->status}}</td>
      @break

      @case('Betaald')
      <td class="table-success">{{ $order->status}}</td>
      @break

      @case('Betaald en besteld')
      <td class="table-info">{{ $order->status}}</td>
      @break

      @case('Bestelling volledig in orde')
      <td class="">{{ $order->status}}</td>
      @break

      @default
      <td class="table-danger">{{ $order->status}}</td>
      @endswitch




      <td>{{ $order->shipping_data}}</td>
      <td>{{ $order->payment_data}}</td>
      <td>{{ $order->created_at}}</td>
      <td>{{ $order->updated_at}}</td>
      <td>{{ $order->remarks}}</td>
      <td>{{ $order->admin_remarks}}</td>
      <td><a href="{{ route('dashboard.orders.edit', $order->id) }}" class="btn btn-primary">Edit</a></td>

    </tr>



  </tbody>
</table>

<h2>Gebruiker info</h2>
<table class="table table-hover">
  <thead>
    <tr>

      <th scope="col">Voornaam</th>
      <th scope="col">Achternaam</th>
      <th scope="col">Stamnummer</th>

      <th scope="col">Email</th>
      <th scope="col">Telefoon</th>
      <th scope="col">Geboortedatum</th>

      <th scope="col">Adres</th>

    </tr>
  </thead>
  <tbody>

    <tr>

      <td scope="col">{{$user_info->firstname}}</td>
      <td scope="col">{{$user_info->lastname}}</td>
      <td scope="col">{{$user_info->stamnr}}</td>

      <td scope="col">{{$user_info->email}}</td>
      <td scope="col">{{$user_info->phone}}</td>
      <td scope="col">{{$user_info->birthdate}}</td>

      <td scope="col">{{$user_info->address_street}} {{$user_info->address_nr}}, {{$user_info->address_zipcode}} {{$user_info->address_city}}</td>

    </tr>

  </tbody>
</table>

<h2>Bestelde ringen</h2>
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Order Id</th>
      <th scope="col">Ring Id</th>
      <th scope="col">Bestelde hoeveelheid</th>
      <th scope="col">Eerste ringnummer</th>
      <th scope="col">Laatste ringnummer</th>
      <th scope="col">Ring codes</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($order_items as $order_item)

    <tr>
      <th scope="row">{{ $order_item->id }}</th>
      <td>{{ $order_item->order_id}}</td>
      <td>{{ $order_item->ring_id}}</td>
      <td>{{ $order_item->amount}}</td>
      <td>{{ $order_item->first_ring_number}}</td>
      <td>{{ $order_item->last_ring_number}}</td>
      <td>
        <or>

          <?php

          $ring_codes = explode(",", $order_item->ring_codes);

          foreach ($ring_codes as $ring_code)
            // echo $ring_code;
            echo "<li>$ring_code</li>";

          ?>
        </or>
      </td>


    </tr>

    @endforeach

  </tbody>
</table>



@endsection