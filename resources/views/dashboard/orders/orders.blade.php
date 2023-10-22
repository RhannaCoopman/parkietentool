@extends('layouts.app')

@section('content')

<main class="container">

  <h1>Bestellingen</h1>

  <form action="{{ route('orders.home') }}" method="GET" class="mb-4">
    <div class="form-row">
      <div class="col-md-2">
        <div class="form-group">
          <label for="id">Order ID:</label>
          <input type="number" name="id" id="id" class="form-control" value="{{ request('id') }}">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="name">Naam:</label>
          <input type="text" name="name" id="name" class="form-control" value="{{ request('name') }}">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="status">Status:</label>
          <select name="status" id="status" class="form-control">
            <option value="">-- Selecteer --</option>
            <option value="Niet betaald" {{ request('status') === 'Niet betaald' ? 'selected' : '' }}>Niet betaald</option>
            <option value="Betaald" {{ request('status') === 'Betaald' ? 'selected' : '' }}>Betaald</option>
            <option value="Betaald en besteld" {{ request('status') === 'Betaald en besteld' ? 'selected' : '' }}>Betaald en besteld</option>
            <option value="Bestelling volledig in orde" {{ request('status') === 'Bestelling volledig in orde' ? 'selected' : '' }}>Bestelling volledig in orde</option>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="created_at">Geplaatst in:</label>
          <select name="created_at" id="created_at" class="form-control">
            <option value="">-- Selecteer --</option>
            <option value="this_month" {{ request('created_at') === 'this_month' ? 'selected' : '' }}>Deze maand</option>
            <option value="2023-05" {{ request('created_at') === '2023-05' ? 'selected' : '' }}>Mei 2023</option>
            <option value="2023-04" {{ request('created_at') === '2023-05' ? 'selected' : '' }}>April 2023</option>
            <option value="2023-03" {{ request('created_at') === '2023-05' ? 'selected' : '' }}>Maart 2023</option>
            <option value="2023-02" {{ request('created_at') === '2023-05' ? 'selected' : '' }}>Februari 2023</option>
            <option value="2023-01" {{ request('created_at') === '2023-05' ? 'selected' : '' }}>Januari 2023</option>

          </select>
        </div>
      </div>
      <div class="col-md-12">
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('orders.home') }}" class="btn btn-secondary">Verwijder alle filters</a>
      </div>
    </div>
  </form>

  @if (session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>
  @endif

  <form action="{{ route('dashboard.orders.export') }}" method="POST">
    @csrf

    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Selecteer</th>
          <th scope="col">Geplaatst door:</th>
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
          <th><input type="checkbox" name="selected_orders[]" value="{{ $order->id }}" checked></th>
          <td>{{ $order->firstname}} {{ $order->lastname}}</td>
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

    <div class="pagination">
  <!-- Pagination links -->
  {!! $orders->render() !!}
  <!-- Order count -->
  <p>Je ziet nu {{ $orders->firstItem() }} tot {{ $orders->lastItem() }} bestellingen.</p>
</div>

    <div class="container">
    <div class="col-md-4">
        <div class="form-group">
          <label for="excel_name">Naam voor het Excel bestand:</label>
          <input type="text" name="excel_name" id="excel_name" class="form-control">
          <small id="excel_name_warning" class="form-text text-info">Typ enkel de naam die je wenst, zet achteraan niet .xlsx en gebruik geen / in de naam! Om zeker te zijn dat de bestandnaam uniek is, wordt er vanzelf de datum van vandaag toegevoegd.</small>

        </div>
      </div>

    <button type="submit" class="btn btn-primary">Exporteer geselecteerde bestellingen naar Excel</button>
    </div>

  </form>

</main>

@endsection