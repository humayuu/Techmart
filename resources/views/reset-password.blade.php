<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - TechMart</title>
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
                <h2 class="text-2xl font-semibold text-gray-800">Reset Password</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Please enter your email address and choose a new password.
                </p>
            </div>

            <!-- Reset Password Form -->
            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div>
                    <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}"
                        required autofocus autocomplete="username"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition ease-in-out duration-150 @error('email') border-red-500 @enderror">

                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition ease-in-out duration-150 @error('password') border-red-500 @enderror">

                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Confirm
                        Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        autocomplete="new-password"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition ease-in-out duration-150 @error('password_confirmation') border-red-500 @enderror">

                    @error('password_confirmation')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex items-center justify-end">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Reset Password
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
