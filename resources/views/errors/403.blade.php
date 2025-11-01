<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Access Denied - CRM</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 text-center">
            <div>
                <div class="mx-auto h-24 w-24 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-shield-alt text-red-600 text-4xl"></i>
                </div>
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    Access Denied
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    You don't have permission to access this resource.
                </p>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-center space-x-2 text-red-600">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span class="font-medium">Error 403: Forbidden</span>
                    </div>

                    <p class="text-gray-600">
                        Your current role doesn't have sufficient permissions to view this page.
                        Please contact your administrator if you believe this is an error.
                    </p>

                    @auth
                        <div class="bg-gray-50 rounded p-3">
                            <p class="text-sm text-gray-600">
                                <strong>Current User:</strong> {{ Auth::user()->name }}<br>
                                <strong>Email:</strong> {{ Auth::user()->email }}<br>
                                <strong>Roles:</strong>
                                @if (Auth::user()->roles->count() > 0)
                                    {{ Auth::user()->roles->pluck('display_name')->implode(', ') }}
                                @else
                                    No roles assigned
                                @endif
                            </p>
                        </div>
                    @endauth

                    <div class="flex space-x-3 justify-center">
                        <a href="{{ route('dashboard') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-150">
                            <i class="fas fa-home mr-1"></i>
                            Go to Dashboard
                        </a>

                        <button onclick="history.back()"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-150">
                            <i class="fas fa-arrow-left mr-1"></i>
                            Go Back
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
