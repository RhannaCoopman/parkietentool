@extends('layouts.app')


@section('content')

<main class="container">
    <h1>Welkom op uw profiel, {{$user->firstname}} {{$user->lastname}}</h1>

    <h2>Mijn gegevens</h2>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Voornaam</th>
                <th scope="col">Achternaam</th>
                <th scope="col">Gebruikersnaam</th>
                <th scope="col">Email</th>
                <th scope="col">Telefoonnummer</th>
                <th scope="col">Stamnummer</th>
                <th scope="col">Account gemaakt op</th>
                <th scope="col">Adres</th>
                <th scope="col">Verjaardag</th>


            </tr>
        </thead>

        <tbody>

            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->firstname }}</td>
                <td>{{ $user->lastname}}</td>
                <td>{{ $user->name}}</td>

                <td>{{ $user->email }}</td>
                <td>{{ $user->phone}}</td>
                <td>{{ $user->stamnr}}</td>
                <td>{{ $user->created_at}}</td>
                <td>{{ $user->address_street}} {{ $user->address_nr}}, {{ $user->address_zipcode}} {{ $user->address_city}}</td>
                <td>{{ $user->birthday}}</td>

            </tr>
        </tbody>
    </table>

    <h2>Betaal uw lidgeld</h2>
    <form action="{{ route('profile.payMembership', $user->id) }}" method="POST">
        @csrf
        @method('POST')
        <button type="submit" class="btn btn-danger">Betaal lidgeld</button>
    </form>


    <h2>Mijn bestellingen</h2>
    @if (count($orders) < 1) <h2>U heeft nog geen bestellingen.</h2>
        @endif
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>

                    <th scope="col">Totaal aantal ringen: </th>

                    <th scope="col">Totale prijs: </th>
                    <th scope="col">Betaald:</th>
                    <th scope="col">Verzend datum: </th>
                    <th scope="col">Geplaatst op:</th>
                    <th scope="col">Aangepast op: </th>
                    <th scope="col">Uw opmerkingen</th>
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
                    <td>{{ $order->created_at}}</td>
                    <td>{{ $order->updated_at}}</td>
                    <td>{{ $order->remarks}}</td>
                    <td><a href="{{ route('profile.order', $order->id) }}" class="btn btn-primary">Details</a></td>

                </tr>

                @endforeach

            </tbody>
        </table>



        <h2>Bewerk gegevens</h2>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>

</main>

@endsection