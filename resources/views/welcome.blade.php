<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CRM Application</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gradient-to-br from-blue-500 to-purple-600 min-h-screen">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full bg-white rounded-lg shadow-2xl p-8">
            <div class="text-center">
                <div class="mx-auto h-16 w-16 bg-blue-600 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-chart-line text-white text-2xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">CRM Application</h1>
                <p class="text-gray-600 mb-8">Manage your customers and grow your business</p>

                <div class="space-y-4">
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200 flex items-center justify-center">
                            <i class="fas fa-tachometer-alt mr-2"></i>
                            Go to Dashboard
                        </a>

                        <form action="{{ route('logout') }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit"
                                class="w-full bg-gray-600 text-white py-3 px-4 rounded-lg hover:bg-gray-700 transition duration-200 flex items-center justify-center">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                Logout ({{ Auth::user()->name }})
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200 flex items-center justify-center">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Login to Dashboard
                        </a>

                        <a href="{{ route('register') }}"
                            class="w-full bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 transition duration-200 flex items-center justify-center">
                            <i class="fas fa-user-plus mr-2"></i>
                            Create Account
                        </a>
                    @endauth

                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <i class="fas fa-users text-blue-600 text-2xl mb-2"></i>
                            <p class="text-sm text-gray-600">Manage Users</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <i class="fas fa-handshake text-green-600 text-2xl mb-2"></i>
                            <p class="text-sm text-gray-600">Track Leads</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <i class="fas fa-chart-bar text-purple-600 text-2xl mb-2"></i>
                            <p class="text-sm text-gray-600">Analytics</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
