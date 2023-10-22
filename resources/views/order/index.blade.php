@extends('layouts.app')

@section('content')

<main class="container">

    <h1>Bestel ringen</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    <form id="order" class="row g-3" method="POST" autocomplete="off" data-type="order" action="/place-order">
        @csrf

        <!-- Date -->

        <div class="mb-3">
            <h3>Datum van vandaag</h3>
            <label class="form-label" for="date">
                Datum van vandaag
            </label>
            <input id="date" type="date" placeholder="" name="date" class="form-control field required" required value="<?= date('Y-m-d') ?>" readonly />
        </div>

        <h3>Persoonlijke gegevens</h3>
        <!-- Last Name -->
        <div class="col-md-5">
            <label class="label" for="lastName">
                <i class="icon-user icon"></i>
            </label>
            <input id="lastName" type="text" placeholder="Lastname" name="lastname" class="field required" minlength="2" maxlength="55" required value="{{ Auth::user()->lastname }}" readonly />
        </div>

        <!-- First Name -->
        <div class="col-md-5">
            <label class="label" for="firstName">
                <i class="icon-user icon"></i>
            </label>
            <input id="firstName" type="text" placeholder="Firstname" name="firstname" class="field required" minlength="2" maxlength="55" required value="{{ Auth::user()->firstname }}" readonly />
        </div>

        <!-- Stamnummer -->
        <div class="col-md-2">
            <label class="label" for="stamnr">
                <i class="icon-user icon"></i>
            </label>
            <input id="stamnr" type="text" placeholder="Stamnummer" name="stamnr" class="field required" minlength="3" maxlength="6" required value="{{ Auth::user()->stamnr }}" readonly />
        </div>

        <h3>Contactgegevens</h3>
        <!-- Phone number -->
        <div class="col-md-5">
            <label class="label" for="phone">
                <i class="icon-user icon"></i>
            </label>
            <input type="tel" id="phone" name="phone" value="{{ Auth::user()->phone }}" required readonly>
        </div>

        <!-- Email -->
        <div class="col-md-5">
            <label class="label" for="email">
                <i class="icon-user icon"></i>
            </label>
            <input class="field required" id="email" type="email" placeholder="Email" name="email" required value="{{ Auth::user()->email }}" />
        </div>

        <h3>Adresgegevens</h3>

        <!-- Street -->
        <div class="col-md-5">
            <label class="label" for="street">
                <i class="icon-user icon"></i>
            </label>
            <input class="field required" id="street" type="text" placeholder="street" name="street" required value="{{ Auth::user()->address_street }}" required readonly />
        </div>

        <!-- Number -->
        <div class="col-md-5">
            <label class="label" for="number">
                <i class="icon-user icon"></i>
            </label>
            <input class="field required" id="number" type="number" placeholder="number" name="number" required value="{{ Auth::user()->address_nr }}" required readonly />
        </div>

        <!-- Post code -->
        <div class="col-md-5">
            <label class="label" for="zipcode">
                <i class="icon-user icon"></i>
            </label>
            <input class="field required" id="zipcode" type="number" placeholder="zipcode" name="zipcode" required value="{{ Auth::user()->address_zipcode }}" required readonly />
        </div>

        <!-- City -->
        <div class="col-md-5">
            <label class="label" for="city">
                <i class="icon-user icon"></i>
            </label>
            <input class="field required" id="city" type="text" placeholder="city" name="city" required value="{{ Auth::user()->address_city }}" required readonly />
        </div>

        <h2>Ringen</h2>


        @foreach ($rings as $ring)
        <!-- Rings -->
        <div class="field-wrapper">
            <label class="label" for="ring_{{ $ring->id }}">
                <i class="icon-user icon">Ringdiameter: {{ $ring->size }} Ringmateriaal: {{ $ring->type_name }}</i>
            </label>
            <br>
            <input class="field required" id="ring_{{ $ring->id }}" type="number" placeholder="" name="ring_{{ $ring->id }}" required class="ring" value="" onchange="
                        document.querySelector('#totalprice_{{ $ring->id }}').innerHTML = ('Totale prijs is ' + ((document.querySelector('#ring_{{ $ring->id }}').value) * ('{{ $ring->price }}') ))
                        " />
            <p>Prijs per stuk: {{ $ring->price }}</p>
            <p id="totalprice_{{ $ring->id }}">Je hebt nog geen ringen van deze soort.</p>
            <hr>

        </div>
        @endforeach

        <h3>Levering</h3>
        <!-- Delivery -->
        <div class="field-wrapper">
            <fieldset>
                <legend required>Kies uw levering:</legend>

                <div>
                    <input type="radio" id="non-prior" name="delivery" value="2.50">
                    <label for="non-prior">Standaard - 2,50</label>
                </div>

                <div>
                    <input type="radio" id="prior" name="delivery" value="4.50">
                    <label for="prior">Binnen 24 uur - 4,50 </label>
                </div>
            </fieldset>
        </div>

        <h3>Betaling</h3>
        <!-- Payment -->
        <div class="field-wrapper">
            <fieldset>
                <legend required class="required">Kies uw betalingsmethode:</legend>

                <div>
                    <input type="radio" id="mollie" name="payment" value="mollie">
                    <label for="mollie">Mollie</label>
                </div>

                <div>
                    <input type="radio" id="overschrijving" name="payment" value="overschrijving">
                    <label for="overschrijving">Overschrijving</label>
                </div>

                <div>
                    <input type="radio" id="cash" name="payment" value="cash">
                    <label for="cash">Cash</label>
                </div>

            </fieldset>
        </div>

        <h3>Opmerkingen</h3>
        <!-- Remarks -->
        <div class="field-wrapper">
            <label class="label" for="remarks">
                <i class="icon-user icon"></i>
            </label>
            <input class="field required" id="remarks" type="text" placeholder="Schrijf hier uw opmerkingen of vragen" name="remarks" required />
        </div>

        <!-- Submit button -->
        <button onclick="document.querySelector('#order').submit();" type="submit" class="btn btn-primary">Dien je bestelbon in</button>
    </form>

    @if ($isLaterThanOctober === 'true')

    <p>Koop ringen voor volgend jaar (<?= Date("Y") ?>)!</p>

    @else
    <p>Je kan nog geen ringen kopen voor volgend jaar (<?= Date("Y") + 1 ?>)!</p>

    @endif

</main>
@endsection