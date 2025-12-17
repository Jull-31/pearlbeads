<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Pearlbeads</title>
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
                <a href="{{ route('login') }}" class="text-gray-600 hover:text-purple-600">← Back to Login</a>
            </div>
        </div>
    </nav>

    <!-- Register Section -->
    <div class="container mx-auto px-6 py-12">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12 border-4 border-purple-200">
                
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="mb-6">
                        <img src="https://img.icons8.com/clouds/200/000000/add-user-male.png" alt="Sign Up" class="w-48 h-48 mx-auto">
                    </div>
                    <h2 class="text-4xl font-bold text-gray-800 mb-2">CREATE ACCOUNT</h2>
                    <p class="text-gray-600">BUAT AKUN DAN DAPATKAN MANFAAT KEMUDAHAN BERBELANJA ANDA</p>
                </div>

                <!-- Error Messages -->
                @if($errors->any())
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Register Form -->
                <form action="{{ route('register') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Full Name *
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            placeholder="John Doe">
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address *
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            placeholder="your@email.com">
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password * (min. 8 characters)
                        </label>
                        <input type="password" name="password" id="password" required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            placeholder="••••••••">
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirm Password *
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            placeholder="••••••••">
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="flex items-start">
                        <input type="checkbox" id="terms" required
                            class="w-4 h-4 mt-1 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                        <label for="terms" class="ml-2 text-sm text-gray-600">
                            I agree to the <a href="#" class="text-purple-600 hover:text-purple-800 font-semibold">Terms and Conditions</a> and <a href="#" class="text-purple-600 hover:text-purple-800 font-semibold">Privacy Policy</a>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                        class="w-full bg-gradient-to-r from-purple-500 to-pink-500 text-white py-3 rounded-full font-semibold text-lg hover:from-purple-600 hover:to-pink-600 transition shadow-lg transform hover:scale-105">
                        Create Account
                    </button>
                </form>

                <!-- Login Link -->
                <div class="mt-8 text-center">
                    <p class="text-gray-600">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-purple-600 font-semibold hover:text-purple-800">Login here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>