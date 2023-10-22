@extends('layouts.app')

@section('content')
<form enctype="multipart/form-data" action="{{ route('dashboard.users.update', $user->id) }}" method="POST" class="row g-3">
    @csrf
    @method('PUT')

    <h2>Edit user</h2>
    
    @if($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <input type="hidden" name="id" value="{{ $user->id }}">
    
    <div class="col-md-4">
        <label for="firstname" class="form-label">Voornaam</label>
        <input
            type="text" class="form-control" name="firstname" id="firstname" value="{{ old('firstname') ? old('firstname') : $user->firstname }}"
            @if($errors->has('firstname')) style="border-color: red;" @endif
        >
    </div>

    <div class="col-md-4">
        <label for="lastname" class="form-label">Achternaam</label>
        <input
            type="text" class="form-control" name="lastname" id="lastname" value="{{ old('lastname') ? old('lastname') : $user->lastname }}"
            @if($errors->has('lastname')) style="border-color: red;" @endif
        >
    </div>


    <div class="col-md-4">
      <label for="role" class="form-label">Rol</label>
      <select id="role"  name="role" class="form-select">
        @foreach ($roles as $role)
          <option value="{{ $role->id }}" <?= ($role->id === $user->role_id) ? 'selected' : '' ?>>{{ $role->id }} - {{ $role->name }}</option>
        @endforeach
      </select>
    </div>

    <div class="col-md-4">
      <label for="group" class="form-label">Betaalcategorie</label>
      <select id="group" name="group" class="form-select">
        @foreach ($groups as $group)
          <option value="{{ $group->id }}" <?= ($group->id === $user->group_id) ? 'selected' : '' ?> >{{ $role->name }}</option>
        @endforeach
      </select>
    </div>

    <div class="col-md-4">
      <label for="active" class="form-label">Actief</label>
      <select id="active" name="active" class="form-select">
        <option value="1" <?= (1 === $user->active) ? 'selected' : '' ?>>Ja</option>
        <option value="0" <?= (0 === $user->active) ? 'selected' : '' ?>>Nee</option>

      </select>
    </div>

        <!-- Phone -->
        <div class="col-md-4">
          <label for="phone" class="form-label">Telefoonnummer</label>
          <input
              type="text" class="form-control" name="phone" id="phone" value="{{ old('phone') ? old('phone') : $user->phone }}"
              @if($errors->has('phone')) style="border-color: red;" @endif
          >
        </div>

        <!-- Email -->
        <div class="col-md-4">
          <label for="email" class="form-label">Email</label>
          <input
              type="text" class="form-control" name="email" id="email" value="{{ old('email') ? old('email') : $user->email }}"
              @if($errors->has('email')) style="border-color: red;" @endif
          >
        </div>

        <h3>Adresgegevens</h3>

        <!-- Street -->
        <div class="col-md-4">
          <label for="street" class="form-label">Straat</label>
          <input
              type="text" class="form-control" name="street" id="street" value="{{ old('street') ? old('street') : $user->address_street }}"
              @if($errors->has('street')) style="border-color: red;" @endif
          >
        </div>

        <!-- Number -->
        <div class="col-md-4">
          <label for="number" class="form-label">Huisnummer</label>
          <input
              type="number" class="form-control" name="number" id="number" value="{{ old('number') ? old('number') : $user->address_nr }}"
              @if($errors->has('number')) style="border-color: red;" @endif
          >
        </div>

        <!-- Number -->
        <div class="col-md-4">
          <label for="zipcode" class="form-label">Postcode</label>
          <input
              type="number" class="form-control" name="zipcode" id="zipcode" value="{{ old('zipcode') ? old('zipcode') : $user->address_zipcode }}"
              @if($errors->has('zipcode')) style="border-color: red;" @endif
          >
        </div>

        <!-- City -->
        <div class="col-md-4">
          <label for="city" class="form-label">Stad</label>
          <input
              type="text" class="form-control" name="city" id="city" value="{{ old('city') ? old('city') : $user->address_city }}"
              @if($errors->has('city')) style="border-color: red;" @endif
          >
        </div>
    
        <!-- Submit button -->
        <button type="submit" class="btn btn-primary">Pas de gegevens aan</button>
</form>

@endsection