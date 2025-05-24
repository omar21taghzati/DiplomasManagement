<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In - {{ config('app.name', 'Laravel') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: url('https://www.transparenttextures.com/patterns/stardust.png');
            background-repeat: repeat;
            background-size: auto;
        }

        .bg-custom-purple {
            background-color: #6C63FF;
        }

        .text-custom-purple {
            color: #6C63FF;
        }

        .border-custom-purple {
            border-color: #6C63FF;
        }

        .placeholder-gray-500::placeholder {
            color: #A0AEC0;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>

<body class="bg-gradient-to-b from-[#3e1d16] to-[#1a0b0c] min-h-screen flex items-center justify-center text-gray-900">
    {{-- class="bg-gradient-to-b from-purple-900 to-black min-h-screen flex items-center justify-center text-gray-900" --}}
    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-2xl relative">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Sign in to your account</h2>

        @if ($errors->has('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <strong class="font-bold">Oops!</strong>
                <span class="block">{{ $errors->first('error') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-400">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="relative">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" required
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-400 pr-10">
                <button type="button" onclick="togglePasswordVisibility()"
                    class="absolute right-3 top-[38px] text-gray-500 hover:text-gray-700">
                    <i class="fas fa-eye" id="eye-icon"></i>
                </button>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember + Forgot -->
            <div class="flex items-center justify-between">
                <label class="inline-flex items-center text-sm text-gray-700">
                    <input type="checkbox" name="remember" class="form-checkbox h-4 w-4 mr-2">
                    Remember me
                </label>
                <a href="{{ route('forget.password.get') }}" class="text-sm text-purple-600 hover:underline">Forgot password?</a>
            </div>

            <!-- Submit -->
            <button type="submit"
                class="w-full bg-purple-600 text-white font-semibold py-2 rounded-md hover:bg-purple-700 transition">
                Sign In
            </button>
        </form>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>
