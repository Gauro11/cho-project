<x-guest-layout>
    <style>
        /* Background */
        body {
            background: linear-gradient(135deg, #e0f2fe, #ffffff);
            font-family: 'Inter', sans-serif;
        }

        /* Card Styling */
        .authentication-card {
            background: #fff;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            animation: fadeIn 0.6s ease-in-out;
        }

        /* Logo */
        .authentication-card img {
            border: 3px solid #bfdbfe;
            padding: 4px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        /* Headings */
        .authentication-card h2 {
            font-weight: 700;
            color: #1e3a8a;
        }

        /* Inputs */
        input[type="text"], input[type="password"] {
            border-radius: 10px !important;
            border: 1px solid #cbd5e1;
            padding: 10px;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        }

        /* Checkbox */
        input[type="checkbox"] {
            accent-color: #3b82f6;
        }

        /* Button */
        button {
            background: linear-gradient(135deg, #3b82f6, #2563eb) !important;
            border-radius: 8px;
            padding: 10px 20px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(37, 99, 235, 0.3);
        }

        /* Status Message */
        .text-green-600 {
            background: #dcfce7;
            padding: 8px;
            border-radius: 6px;
            font-weight: 500;
        }

        /* Password Toggle */
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 65%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 1.2rem;
            color: #6b7280;
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <x-authentication-card class="authentication-card">
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
                <x-input id="staff_id" class="block mt-1 w-full rounded-md border-gray-300" 
                         type="text" name="staff_id" :value="old('staff_id')" required autofocus />
            </div>

            <div class="mb-4 relative">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full rounded-md border-gray-300 pr-10" 
                         type="password" name="password" required autocomplete="current-password" />

                <!-- Eye Icon -->
                <span class="toggle-password" onclick="togglePassword()">👁️</span>
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

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-password');
            
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.textContent = "🙈"; // change icon when showing
            } else {
                passwordField.type = "password";
                toggleIcon.textContent = "👁️"; // change back when hiding
            }
        }
    </script>
</x-guest-layout>
