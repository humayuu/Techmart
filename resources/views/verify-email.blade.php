<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email - TechMart</title>
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
            <!-- Verification Message -->
            <div class="mb-4 text-sm text-gray-600">
                Thanks for signing up! Before getting started, could you verify your email address by clicking on the
                link we just emailed to you? If you didn't receive the email, we will gladly send you another.
            </div>

            <!-- Success Message (shows when resend is clicked) -->
            <!-- Uncomment this section when showing success message -->
            <!--
            <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded">
                A new verification link has been sent to the email address you provided during registration.
            </div>
            -->

            <!-- Action Buttons -->
            <div class="mt-6 flex items-center justify-between gap-4">
                <!-- Resend Verification Email -->
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Resend Verification Email
                    </button>
                </form>

                <!-- Log Out -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                        Log Out
                    </button>
                </form>
            </div>
        </div>

        <!-- Footer (Optional) -->
        <div class="mt-10 text-center text-sm text-gray-500">
            <p>&copy; 2026 TechMart. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
