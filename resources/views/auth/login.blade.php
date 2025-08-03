<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <img class="w-20 h-20 rounded-full mx-auto" src="image/dag_logo.png" alt="Logo">
        </x-slot>

        <x-validation-errors class="mb-4" />

        <div class="text-center mb-4">
            <h2 class="text-2xl font-semibold text-gray-800">{{ __('CHO Dagupan') }}</h2>
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <x-label for="staff_id" value="{{ __('Staff ID') }}" />
                <x-input id="staff_id" class="block mt-1 w-full rounded-md border-gray-300" type="text" name="staff_id" :value="old('staff_id')" required autofocus />
            </div>

            <div class="mb-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full rounded-md border-gray-300" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mb-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-center mb-4">
                <x-button>
                    {{ __('Log in') }}
                </x-button>
            </div>

        </form>

    </x-authentication-card>
</x-guest-layout>
