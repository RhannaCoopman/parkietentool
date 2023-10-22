@extends('layouts.app')

@section('content')
<h1>Show order # {{$id}}</h1>


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