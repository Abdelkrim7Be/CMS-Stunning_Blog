<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 via-black to-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">

        <!-- Logo and Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-2xl shadow-2xl mb-6">
                <i class="fas fa-blog text-black text-4xl"></i>
            </div>
            <h2 class="text-4xl font-bold text-white mb-2">Welcome Back</h2>
            <p class="text-gray-400 text-lg">Sign in to your admin account</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="p-8">
                <form action="/login" method="POST" class="space-y-6">

                    <!-- Username Field -->
                    <div>
                        <label for="username" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-user mr-2"></i>Username
                        </label>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            required
                            autofocus
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition-all"
                            placeholder="Enter your username">
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2"></i>Password
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition-all"
                            placeholder="Enter your password">
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="w-4 h-4 border-gray-300 rounded text-black focus:ring-black">
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                        <a href="#" class="text-sm text-black hover:text-gray-700 font-medium">
                            Forgot password?
                        </a>
                    </div>

                    <!-- Login Button -->
                    <button
                        type="submit"
                        class="w-full py-4 bg-black text-white rounded-lg font-bold text-lg hover:bg-gray-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                    </button>

                </form>
            </div>

            <!-- Footer -->
            <div class="px-8 py-6 bg-gray-50 border-t border-gray-200">
                <p class="text-center text-sm text-gray-600">
                    <i class="fas fa-shield-alt mr-1"></i>
                    Secure Admin Access Only
                </p>
            </div>
        </div>

        <!-- Back to Site -->
        <div class="text-center mt-6">
            <a href="/" class="text-white hover:text-gray-300 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Back to Website
            </a>
        </div>

    </div>
</div>

<style>
    body {
        margin: 0;
        padding: 0;
    }
</style>