<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Panel' ?></title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .sidebar-link {
            @apply transition-all duration-200 ease-in-out;
        }

        .sidebar-link:hover {
            @apply bg-gray-800;
        }

        .sidebar-link.active {
            @apply bg-black border-l-4 border-white;
        }

        .stat-card {
            @apply transition-all duration-300 ease-in-out;
        }

        .stat-card:hover {
            @apply transform scale-105 shadow-2xl;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
    </style>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#000000',
                        secondary: '#ffffff',
                        accent: '#333333',
                        gray: {
                            850: '#1a1a1a',
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50" x-data="{ sidebarOpen: true, mobileMenuOpen: false }">

    <!-- Mobile Menu Button -->
    <div class="lg:hidden fixed top-4 left-4 z-50">
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="bg-black text-white p-3 rounded-lg shadow-lg">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- Sidebar -->
    <aside
        class="fixed top-0 left-0 h-screen bg-gradient-to-b from-gray-900 via-black to-gray-900 text-white transition-all duration-300 z-40 overflow-y-auto"
        :class="sidebarOpen ? 'w-64' : 'w-20'"
        x-show="mobileMenuOpen || window.innerWidth >= 1024"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0">
        <!-- Sidebar Header -->
        <div class="p-6 border-b border-gray-800">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3" x-show="sidebarOpen">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                        <i class="fas fa-blog text-black text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold">CMS Admin</h2>
                        <p class="text-xs text-gray-400">Management Panel</p>
                    </div>
                </div>
                <button @click="sidebarOpen = !sidebarOpen" class="hidden lg:block text-gray-400 hover:text-white">
                    <i class="fas" :class="sidebarOpen ? 'fa-chevron-left' : 'fa-chevron-right'"></i>
                </button>
            </div>
        </div>

        <!-- User Profile -->
        <div class="p-6 border-b border-gray-800">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-gradient-to-br from-gray-600 to-gray-800 rounded-full flex items-center justify-center text-xl font-bold">
                    <?= strtoupper(substr($_SESSION['user']['username'] ?? 'A', 0, 1)) ?>
                </div>
                <div x-show="sidebarOpen">
                    <p class="font-semibold"><?= htmlspecialchars($_SESSION['user']['username'] ?? 'Admin') ?></p>
                    <p class="text-xs text-gray-400"><?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?></p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="p-4 space-y-2">
            <a href="/admin/dashboard" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white <?= strpos($_SERVER['REQUEST_URI'], '/admin/dashboard') !== false ? 'active' : '' ?>">
                <i class="fas fa-chart-line w-6"></i>
                <span x-show="sidebarOpen">Dashboard</span>
            </a>

            <a href="/admin/posts" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white <?= strpos($_SERVER['REQUEST_URI'], '/admin/posts') !== false ? 'active' : '' ?>">
                <i class="fas fa-file-alt w-6"></i>
                <span x-show="sidebarOpen">Posts</span>
            </a>

            <a href="/admin/categories" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white <?= strpos($_SERVER['REQUEST_URI'], '/admin/categories') !== false ? 'active' : '' ?>">
                <i class="fas fa-folder w-6"></i>
                <span x-show="sidebarOpen">Categories</span>
            </a>

            <a href="/admin/comments" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white <?= strpos($_SERVER['REQUEST_URI'], '/admin/comments') !== false ? 'active' : '' ?>">
                <i class="fas fa-comments w-6"></i>
                <span x-show="sidebarOpen">Comments</span>
            </a>

            <a href="/admin/profile" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white <?= strpos($_SERVER['REQUEST_URI'], '/admin/profile') !== false ? 'active' : '' ?>">
                <i class="fas fa-user w-6"></i>
                <span x-show="sidebarOpen">Profile</span>
            </a>

            <div class="border-t border-gray-800 my-4"></div>

            <a href="/" target="_blank" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white">
                <i class="fas fa-globe w-6"></i>
                <span x-show="sidebarOpen">View Site</span>
            </a>

            <a href="/logout" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg text-red-400 hover:text-red-300 hover:bg-red-900/20">
                <i class="fas fa-sign-out-alt w-6"></i>
                <span x-show="sidebarOpen">Logout</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="transition-all duration-300" :class="sidebarOpen ? 'lg:ml-64' : 'lg:ml-20'">

        <!-- Top Bar -->
        <header class="bg-white border-b border-gray-200 sticky top-0 z-30 glass-effect">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900"><?= $pageTitle ?? 'Dashboard' ?></h1>
                        <p class="text-sm text-gray-500 mt-1">
                            <i class="far fa-calendar-alt"></i>
                            <?= date('l, F j, Y') ?>
                        </p>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Search Bar -->
                        <div class="relative hidden md:block">
                            <input
                                type="text"
                                placeholder="Search..."
                                class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>

                        <!-- Notifications -->
                        <button class="relative p-2 text-gray-600 hover:text-black transition-colors">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="p-6">
            <?php require __DIR__ . '/../' . $view . '.php'; ?>
        </div>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-12">
            <div class="px-6 py-4">
                <div class="flex flex-col md:flex-row items-center justify-between text-sm text-gray-600">
                    <p>&copy; <?= date('Y') ?> CMS Admin Panel. All rights reserved.</p>
                    <p class="mt-2 md:mt-0">
                        Made with <i class="fas fa-heart text-red-500"></i> by Your Team
                    </p>
                </div>
            </div>
        </footer>

    </main>

    <script>
        // Auto-hide mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('aside');
            const menuButton = document.querySelector('[\\@click="mobileMenuOpen = !mobileMenuOpen"]');

            if (window.innerWidth < 1024 && !sidebar?.contains(event.target) && !menuButton?.contains(event.target)) {
                Alpine.store('mobileMenuOpen', false);
            }
        });
    </script>

</body>

</html>