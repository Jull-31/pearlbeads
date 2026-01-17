<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pearlbeads</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        * {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-100 via-pink-100 to-purple-200 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur-sm shadow-sm">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <span class="text-2xl font-bold text-purple-600">Pearlbeads.co</span>
                </a>
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-purple-600">← Back to Home</a>
            </div>
        </div>
    </nav>

    <!-- Login Section -->
    <div class="container mx-auto px-6 py-12">
        <div class="max-w-5xl mx-auto">
            <div class="grid md:grid-cols-2 gap-8">
                
                <!-- Sign In Card -->
                <div class="bg-white rounded-3xl shadow-2xl p-8 border-4 border-purple-200 transform transition hover:scale-105">
                    <div class="text-center mb-8">
                        <div class="mb-6">
                            <img src="https://img.icons8.com/clouds/200/000000/add-user-male.png" alt="Sign In" class="w-48 h-48 mx-auto">
                        </div>
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">SIGN IN</h2>
                        <p class="text-gray-600">
                            BUAT AKUN DAN DAPATKAN MANFAAT KEMUDAHAN<br>
                            BERBELANJA ANDA
                        </p>
                    </div>
                    <a href="{{ route('register') }}"
                       class="block w-full bg-gradient-to-r from-purple-500 to-pink-500 text-white text-center py-3 rounded-full font-semibold hover:from-purple-600 hover:to-pink-600 transition shadow-lg">
                        Create Account
                    </a>
                </div>

                <!-- Login Card -->
                <div class="bg-white rounded-3xl shadow-2xl p-8 border-4 border-teal-200">
                    <div class="text-center mb-8">
                        <div class="mb-6">
                            <img src="https://img.icons8.com/clouds/200/000000/login-rounded-right.png" alt="Login" class="w-48 h-48 mx-auto">
                        </div>
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">LOGIN</h2>
                        <p class="text-gray-600">MASUK KE AKUN ANDA YANG SUDAH DI DAFTARKAN</p>
                    </div>

                    @if($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- ✅ FORM LOGIN (UPDATED) -->
                    <form action="{{ route('login') }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- Redirect back after login -->
                        <input type="hidden" name="redirect"
                               value="{{ request()->get('redirect', url()->previous()) }}">

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat Email
                            </label>
                            <input type="email" name="email" id="email"
                                   value="{{ old('email') }}" required
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                   placeholder="your@email.com">
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password
                            </label>
                            <input type="password" name="password" id="password" required
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                   placeholder="••••••••">
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="remember" id="remember"
                                   class="w-4 h-4 text-purple-600 rounded">
                            <label for="remember" class="ml-2 text-sm text-gray-600">
                                Ingat Saya
                            </label>
                        </div>

                        <button type="submit"
                                class="w-full bg-gradient-to-r from-teal-500 to-blue-500 text-white py-3 rounded-full font-semibold hover:from-teal-600 hover:to-blue-600 transition shadow-lg">
                            Login 
                        </button>
                    </form>

                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">
                            Tidak memiliki Akun?
                            <a href="{{ route('register') }}"
                               class="text-purple-600 font-semibold hover:text-purple-800">
                                Sign Up
                            </a>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
