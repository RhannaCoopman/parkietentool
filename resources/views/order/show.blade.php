@extends('layouts.app')

@section('title', 'Course Detail')

@section('content')

    <h1>Order # {{ $order->id }}</h1>

    @if ($message = Session::get('ordered'))
                <div class="alert alert-success">
                    <strong>{{ $message }}</strong>
                </div>
    @endif

    @if ($message = Session::get('payed'))
                <div class="alert alert-success">
                    <strong>{{ $message }}</strong>
                </div>
    @endif

    @foreach ($order_items as $item)
      <p> Je hebt {{ $item->amount }} ringen besteld van ringsoort {{ $item->ring_id }}</p>
    @endforeach



@endsection