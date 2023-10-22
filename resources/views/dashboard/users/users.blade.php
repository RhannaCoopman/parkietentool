@extends('layouts.app')

@section('title', 'Course Detail')

@section('content')

<main class="container">

<h1>Gebruikers</h1>

@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif


<h2>Maak een nieuwe gebruiker aan</h2>
<a href="{{ route('register') }}" class="btn btn-primary">Maak een nieuwe gebruiker</a>
<hr>

<h2>Zoek een gebruiker</h2>
<form action="{{ route('users.home') }}" method="GET" class="mb-4">
    <div class="form-row">
        <div class="col-md-2">
            <div class="form-group">
                <label for="id">Stamnummer:</label>
                <input type="text" name="stamnr" id="stamnr" class="form-control" value="{{ request('stamnr') }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="name">Naam:</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ request('name') }}">
            </div>
        </div>


        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('users.home') }}" class="btn btn-secondary">Verwijder alle filters</a>
        </div>
    </div>
</form>

<h2>Bekijk gebruikers</h2>
<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Voornaam</th>
            <th scope="col">Achternaam</th>
            <th scope="col">Email</th>
            <th scope="col">Telefoonnummer</th>
            <th scope="col">Stamnummer</th>
            <th scope="col">Bekijk</th>
            <th scope="col">Bewerk</th>
            <th scope="col">Verwijder</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->firstname }}</td>
            <td>{{ $user->lastname}}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone}}</td>
            <td>{{ $user->stamnr}}</td>
            <td>
                <a href="{{ route('dashboard.users.show', $user->id) }}" class="btn btn-primary">Bekijk details</a>
            </td>
            <td>
                <a href="{{ route('dashboard.users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
            </td>
            <td>
                <form action="{{ route('dashboard.users.delete', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</div>

</main>

@endsection