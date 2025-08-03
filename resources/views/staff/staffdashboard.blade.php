@php use Illuminate\Support\Facades\Auth; @endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Staff Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Welcome, {{ Auth::user()->name ?? Auth::user()->staff_id }}</h3>
                <p>This is your staff dashboard. Customize it as needed!</p>
            </div>
        </div>
    </div>
</x-app-layout>
