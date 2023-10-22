<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Firstname -->
        <div>
            <x-input-label for="firstname" :value="__('Voornaam')" />
            <x-text-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autofocus autocomplete="firstname" />
            <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
        </div>

        <!-- Lastname -->
        <div>
            <x-input-label for="lastname" :value="__('Achternaam')" />
            <x-text-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" required autofocus autocomplete="lastname" />
            <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Gebruikersnaam')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Wachtwoord')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Bevestig wachtwoord')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Street -->
        <div>
            <x-input-label for="address_street" :value="__('Straat')" />
            <x-text-input id="address_street" class="block mt-1 w-full" type="text" name="address_street" :value="old('address_street')" required autofocus autocomplete="address_street" />
            <x-input-error :messages="$errors->get('address_street')" class="mt-2" />
        </div>

        <!-- House number -->
        <div>
            <x-input-label for="address_nr" :value="__('Huisnummer')" />
            <x-text-input id="address_nr" class="block mt-1 w-full" type="number" name="address_nr" :value="old('address_nr')" required autofocus autocomplete="address_nr" />
            <x-input-error :messages="$errors->get('address_nr')" class="mt-2" />
        </div>

        <!-- Zipcode -->
        <div>
            <x-input-label for="address_zipcode" :value="__('Postcode')" />
            <x-text-input id="address_zipcode" class="block mt-1 w-full" type="text" min="4" max="4" name="address_zipcode" :value="old('address_zipcode')" required autofocus autocomplete="address_zipcode" />
            <x-input-error :messages="$errors->get('address_zipcode')" class="mt-2" />
        </div>

        <!-- City -->
        <div>
            <x-input-label for="lastname" :value="__('Stad')" />
            <x-text-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" required autofocus autocomplete="city" />
            <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
        </div>
        
        <!-- Birthdate -->
        <div>
            <x-input-label for="birthdate" :value="__('Geboortedatum')" />
            <x-text-input id="birthdate" class="block mt-1 w-full" type="date" name="birthdate" :value="old('birthdate')" required autofocus autocomplete="city" />
            <x-input-error :messages="$errors->get('birthdate')" class="mt-2" />
        </div>

        <!-- Phone number -->
        <div>
            <x-input-label for="phone" :value="__('Telefoonnummer')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="phone" min="9" max="12" name="phone" :value="old('phone')" required autofocus autocomplete="city" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">

            <x-primary-button class="ml-4">
                {{ __('Registreer nieuwe gebruiker') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
