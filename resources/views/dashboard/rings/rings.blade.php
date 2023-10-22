@extends('layouts.app')

@section('title', 'Course Detail')

@section('content')

<h1>Ringen</h1>

<!-- Create new ring -->
<section class=".container">

    <form enctype="multipart/form-data" action="{{ route('dashboard.rings.create') }}" method="POST" class="row g-3">
        @csrf
        @method('POST')

        <h2>Maak een nieuwe ring</h2>

        @if($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif


        <div class="col-md-1">
            <label for="size" class="form-label">Diameter</label>
            <input type="number" class="form-control" name="size" id="size" placeholder="Diameter 0,00" value="{{ old('size') }}" @if($errors->has('size')) style="border-color: red;" @endif
            >
        </div>

        <div class="col-md-3">
            <label for="name" class="form-label">Naam</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Naam" value="{{ old('name') }}" @if($errors->has('name')) style="border-color: red;" @endif
            >
        </div>

        <div class="col-md-4">
            <label for="description" class="form-label">Beschrijving</label>
            <input type="text" class="form-control" name="description" id="description" placeholder="Beschrijving" value="{{ old('description') }}" @if($errors->has('description')) style="border-color: red;" @endif
            >
        </div>

        <div class="col-md-1">
            <label for="price" class="form-label">Prijs</label>
            <input type="number" class="form-control" name="price" id="price" placeholder="Prijs 0,00" value="{{ old('price') }}" @if($errors->has('price')) style="border-color: red;" @endif
            >
        </div>

        <div class="col-md-5">
            <label for="type" class="form-label">Ring type</label>
            <select id="type" name="type" class="form-select" value="{{ old('type') }}" @if($errors->has('type')) style="border-color: red;" @endif>
                @foreach ($types as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>


        <!-- Submit button -->
        <button type="submit" class="btn btn-success col-md-1">Creeër nieuwe ring ring</button>
    </form>
    <hr>
    <hr>
</section>

<section class=".container">
    <h2>Update ringen</h2>


    <!-- Update existing rings -->
    @foreach ($rings as $ring)
    <form enctype="multipart/form-data" action="{{ route('dashboard.rings.update', $ring->id) }}" method="POST" class="row g-3">
        @csrf
        @method('PUT')

        <h3>Update ring # {{ $ring->id }} met diameter {{ $ring->size }} in {{ $ring->type_name}}</h3>

        @if($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif

        <input type="hidden" name="id" value="{{ $ring->id }}">

        <div class="col-md-1">
            <label for="size" class="form-label">Diameter</label>
            <input type="number" class="form-control" name="size" id="size" value="{{ old('size') ? old('size') : $ring->size }}" placeholder="Diameter 0,00" @if($errors->has('size')) style="border-color: red;" @endif
            >
        </div>

        <div class="col-md-3">
            <label for="name" class="form-label">Naam</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') ? old('name') : $ring->name }}" placeholder="Naam" @if($errors->has('name')) style="border-color: red;" @endif
            >
        </div>

        <div class="col-md-4">
            <label for="description" class="form-label">Beschrijving</label>
            <input type="text" class="form-control" name="description" id="description" value="{{ old('description') ? old('description') : $ring->description }}" placeholder="Beschrijving" @if($errors->has('description')) style="border-color: red;" @endif
            >
        </div>

        <div class="col-md-1">
            <label for="price" class="form-label">Prijs</label>
            <input type="number" class="form-control" name="price" id="price" value="{{ old('price') ? old('price') : $ring->price }}" placeholder="Prijs 0,00" @if($errors->has('price')) style="border-color: red;" @endif
            >
        </div>

        <div class="col-md-5">
            <label for="type" class="form-label">Ring type</label>
            <select id="type" name="type" class="form-select" @if($errors->has('type')) style="border-color: red;" @endif>
                @foreach ($types as $type)
                <option value="{{ $type->id }}" <?= ($ring->type_id == $type->id) ? 'selected' : '' ?>>{{ $type->name }}</option>
                @endforeach
            </select>
        </div>


        <!-- Submit button -->
        <button type="submit" class="btn btn-primary col-md-1">Update ring</button>
    </form>

    <hr>

    @endforeach
</section>

@endsection