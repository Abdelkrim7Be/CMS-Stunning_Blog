<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Stunning Blog' ?></title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Playfair Display', serif;
        }

        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #000;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #333;
        }

        .gradient-text {
            background: linear-gradient(135deg, #000000 0%, #434343 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .post-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .post-card:hover {
            transform: translateY(-8px);
        }

        .post-card img {
            transition: transform 0.5s ease;
        }

        .post-card:hover img {
            transform: scale(1.05);
        }

        .hero-pattern {
            background-color: #000000;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#000000',
                        secondary: '#ffffff',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-white" x-data="{ mobileMenuOpen: false }">

    <!-- Navigation -->
    <nav class="bg-black text-white sticky top-0 z-50 shadow-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">

                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center">
                        <i class="fas fa-blog text-black text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">Stunning Blog</h1>
                        <p class="text-xs text-gray-400">Thoughts & Stories</p>
                    </div>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-white hover:text-gray-300 transition-colors font-medium">
                        <i class="fas fa-home mr-2"></i>Home
                    </a>
                    <a href="/about" class="text-white hover:text-gray-300 transition-colors font-medium">
                        <i class="fas fa-info-circle mr-2"></i>About
                    </a>
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="/admin/dashboard" class="px-6 py-2 bg-white text-black rounded-lg hover:bg-gray-200 transition-colors font-semibold">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                    <?php else: ?>
                        <a href="/login" class="px-6 py-2 bg-white text-black rounded-lg hover:bg-gray-200 transition-colors font-semibold">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-white">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform -translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            class="md:hidden bg-gray-900 border-t border-gray-800">
            <div class="px-4 py-4 space-y-3">
                <a href="/" class="block text-white hover:text-gray-300 py-2">
                    <i class="fas fa-home mr-2"></i>Home
                </a>
                <a href="/about" class="block text-white hover:text-gray-300 py-2">
                    <i class="fas fa-info-circle mr-2"></i>About
                </a>
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="/admin/dashboard" class="block bg-white text-black px-4 py-2 rounded-lg text-center font-semibold">
                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                    </a>
                <?php else: ?>
                    <a href="/login" class="block bg-white text-black px-4 py-2 rounded-lg text-center font-semibold">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-pattern text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl md:text-7xl font-bold mb-6">
                Welcome to <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-400">Stunning Blog</span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-300 mb-8 max-w-3xl mx-auto">
                Discover amazing stories, insights, and ideas from our community of writers
            </p>

            <!-- Search Bar -->
            <div class="max-w-2xl mx-auto">
                <form action="/" method="GET" class="relative">
                    <input
                        type="text"
                        name="search"
                        placeholder="Search for articles..."
                        class="w-full px-6 py-4 pr-32 rounded-full text-gray-900 focus:outline-none focus:ring-4 focus:ring-white/50 text-lg"
                        value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                    <button
                        type="submit"
                        class="absolute right-2 top-2 px-8 py-2 bg-black text-white rounded-full hover:bg-gray-800 transition-colors font-semibold">
                        <i class="fas fa-search mr-2"></i>Search
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <?php require __DIR__ . '/../' . $view . '.php'; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-black text-white mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

                <!-- About -->
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center">
                            <i class="fas fa-blog text-black text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold">Stunning Blog</h3>
                    </div>
                    <p class="text-gray-400 mb-4 max-w-md">
                        A modern content management system built for storytellers, writers, and content creators. Share your thoughts with the world.
                    </p>
                    <div class="flex space-x-4">
                        <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-white/20 transition-colors" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-white/20 transition-colors" title="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-white/20 transition-colors" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-white/20 transition-colors" title="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-bold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="/" class="text-gray-400 hover:text-white transition-colors">Home</a></li>
                        <li><a href="/about" class="text-gray-400 hover:text-white transition-colors">About Us</a></li>
                        <li><a href="/#categories" class="text-gray-400 hover:text-white transition-colors">Categories</a></li>
                        <li><a href="/about#contact" class="text-gray-400 hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-lg font-bold mb-4">Contact Us</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>
                            <i class="fas fa-envelope mr-2"></i>
                            info@stunningblog.com
                        </li>
                        <li>
                            <i class="fas fa-phone mr-2"></i>
                            +1 234 567 890
                        </li>
                        <li>
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            123 Blog Street, Web City
                        </li>
                    </ul>
                </div>

            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; <?= date('Y') ?> Stunning Blog. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>

</html>