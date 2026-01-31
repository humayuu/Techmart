<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - TechMart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans antialiased bg-white">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-white">
        <!-- Logo/Brand Name -->
        <div class="mb-8">
            <a href="/">
                <h1 class="text-4xl font-bold text-gray-800">Tech<span class="text-blue-500">Mart</span></h1>
            </a>
        </div>

        <!-- Main Card -->
        <div
            class="w-full sm:max-w-md px-6 py-8 bg-white shadow-lg overflow-hidden sm:rounded-lg border border-gray-200">

            <!-- Header -->
            <div class="mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Forgot Password?</h2>
                <p class="mt-2 text-sm text-gray-600">
                    No problem. Just let us know your email address and we will email you a password reset link that
                    will allow you to choose a new one.
                </p>
            </div>

            <!-- Session Status (Success Message) -->
            @if (session('status'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-md">
                    <p class="text-sm text-green-600">{{ session('status') }}</p>
                </div>
            @endif

            <!-- Forgot Password Form -->
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition ease-in-out duration-150 @error('email') border-red-500 @enderror">

                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex items-center justify-between">
                    <a href="{{ route('login') }}"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                        Back to Login
                    </a>

                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Email Password Reset Link
                    </button>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="mt-10 text-center text-sm text-gray-500">
            <p>&copy; 2026 TechMart. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
