<!DOCTYPE html>
<html>
<head>
    <style>
        /* Add your custom CSS styles for the PDF here */
    </style>
</head>
<body>
    <h1>Show order # {{ $order->id }}</h1>

    <p>De volgende ringen behoren toe aan Mr/Mevr</p>

    <h2>{{ $user_info->firstname }} {{ $user_info->lastname }}</h2>

    <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Stamnummer</th>
      <th scope="col">Maat</th>
      <th scope="col">Code</th>
      <th scope="col">Aantal</th>
      <th scope="col">Eerste ringnummer</th>
      <th scope="col">Laatste ringnummer</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($order_items as $order_item)

    <tr>
      <th scope="row">{{ $order_item->id }}</th>
      <td>{{ $user_info->stamnr }}</td>
      <td>{{ $order_item->size}}</td>
      <td>{{ $order_item->typename}}</td>
      <td>{{ $order_item->amount}}</td>
      <td>{{ $order_item->first_ring_number}}</td>
      <td>{{ $order_item->last_ring_number}}</td>
    
    </tr>

    @endforeach

  </tbody>
</table>

</body>
</html>
