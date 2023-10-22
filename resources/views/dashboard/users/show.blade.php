@extends('layouts.app')

@section('content')

<main class="container">

  <h1>Bestellingen van {{$user->name}}</h1>

    @if (count($orders) < 1) <h2>Deze gebruiker heeft nog geen bestellingen.</h2>
    @endif
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
          <th scope="col">Bekijk in detail</th>

        </tr>
      </thead>
      <tbody>
        @foreach ($orders as $order)

        <tr>
          <th scope="row">{{ $order->id }}</th>
          <td>00000</td>
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
          <td><a href="{{ route('dashboard.orders.detail', $order->id) }}" class="btn btn-primary">Details</a></td>

        </tr>

        @endforeach

      </tbody>
    </table>


</main>

@endsection