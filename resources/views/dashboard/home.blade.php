@extends('layouts.app')

@section('title', 'Course Detail')

@section('content')

  <h1>Welkom op het dashboard</h1>

  <ul>
      <li>
        <a href="/dashboard/users">Beheer gebruikers</a>
      </li>

      <li>
        <a href="/dashboard/rings">Beheer ringen</a>
      </li>

      <li>
        <a href="/dashboard/orders">Beheer bestellingen</a>
      </li>

      <li>
        <a href="/dashboard/suppliers">Beheer leveranciers</a>
      </li>
  </ul>
@endsection