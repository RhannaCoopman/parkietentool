@extends('layouts.app')

@section('content')
<form enctype="multipart/form-data" action="{{ route('dashboard.orders.update', $order->id) }}" method="POST" class="row g-3">
  @csrf
  @method('PUT')

  <h1>Edit order #{{ $order->id }}</h2>

  @if($errors->any())
  <ul style="color: red;">
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
  @endif

  <h2>Bewerk bestelstatus</h2>
  <input type="hidden" name="id" value="{{ $order->id }}">

  <div class="col-md-4">
    <label for="shipping_data" class="form-label">Verzend info</label>
    <input type="text" class="form-control" name="shipping_data" id="shipping_data" value="{{ old('shipping_data') ? old('shipping_data') : $order->shipping_data }}" @if($errors->has('shipping_data')) style="border-color: red;" @endif
    >
    <small id="shipping_data_warning" class="form-text text-warning">Vergeet niet de status van de bestelling aan te passen.</small>

  </div>

  <div class="col-md-4">
    <label for="payment_data" class="form-label">Betaalinfo</label>
    <input type="text" class="form-control" name="payment_data" id="payment_data" value="{{ old('payment_data') ? old('payment_data') : $order->payment_data }}" @if($errors->has('payment_data')) style="border-color: red;" @endif
    >
    <small id="payment_data_info" class="form-text text-muted">Vergeet niet de datum, bedrag en bij een overschijrving het rekeningnummer en melding te vermelden.</small>
    <small id="payment_data_warning" class="form-text text-warning">Vergeet niet de status van de bestelling aan te passen!</small>

  </div>



  <div class="col-md-4">
    <label for="status" class="form-label">Status van bestelling</label>
    <select id="status" name="status" class="form-select">

      <option value="Niet betaald" <?= ($order->status == "Niet betaald") ? 'selected' : '' ?>>Niet betaald</option>
      <option value="Betaald" <?= ($order->status == "Betaald") ? 'selected' : '' ?>>Betaald</option>
      <option value="Betaald en besteld" <?= ($order->status == "Betaald en besteld") ? 'selected' : '' ?>>Betaald en besteld</option>
      <option value="Bestelling volledig in orde" <?= ($order->status == "Bestelling volledig in orde") ? 'selected' : '' ?>>Bestelling volledig in orde</option>

    </select>
  </div>

  <div class="col-md-6">
    <label for="admin_remarks" class="form-label">Opmerkingen van admin</label>
    <input type="text" class="form-control" name="admin_remarks" id="admin_remarks" value="{{ old('admin_remarks') ? old('admin_remarks') : $order->admin_remarks }}" @if($errors->has('admin_remarks')) style="border-color: red;" @endif
    >
    <small id="admin_remarks_info" class="form-text text-muted">De klant ziet deze opmerkingen niet.</small>

  </div>

  <h2>Bewerk bestelde ringen</h2>
  @foreach ($order_items as $order_item)
    <h3>Bewerk ring {{ $order_item->ring_id }}</h3>
    <div class="col-md-5">
<label for="ring_id" class="form-label">Ringsoort</label>
<select id="ring_id" name="ring_id" class="form-select">
  @foreach ($rings as $ring)
    <option value="{{ $ring->id }}" <?= ($order_item->ring_id == $ring->id ) ? 'selected' : '' ?>>ring id: {{ $ring->id }} - ring diameter: {{ $ring->size }} - materiaal: {{ $ring->type_name }}</option>
  @endforeach
</select>
</div>

<div class="col-md-2">
<label for="amount" class="form-label">Aantal ringen</label>
<input type="number" class="form-control" name="amount" id="amount" value="{{ old('amount') ? old('amount') : $order_item->amount }}" @if($errors->has('amount')) style="border-color: red;" @endif
>

</div>

<div class="form-group">
<label for="ring_codes" class="form-label">Ring codes</label>
    <textarea class="form-control" rows="3" name="ring_codes" id="ring_codes" @if($errors->has('ring_codes')) style="border-color: red;" @endif>{{ old('ring_codes') ? old('ring_codes') : $order_item->ring_codes }}</textarea>
    <small id="ring_codes_warning" class="form-text text-warning">Voeg geen spaties toe tussen de ringcodes!</small>

  </div>

<!-- <div class="col-md-5">
<label for="ring_codes" class="form-label">Aantal ringen</label>
<input type="text" class="form-control" name="ring_codes" id="ring_codes" value="{{ old('ring_codes') ? old('ring_codes') : $order_item->ring_codes }}" @if($errors->has('ring_codes')) style="border-color: red;" @endif
>

</div> -->


</div>
  @endforeach

  </div>

  

  <!-- Submit button -->
  <button type="submit" class="btn btn-primary">Pas de gegevens aan</button>
</form>

@endsection