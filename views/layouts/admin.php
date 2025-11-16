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

            <?php if (can('manage_admins')): ?>
                <a href="/admin/admins" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white <?= strpos($_SERVER['REQUEST_URI'], '/admin/admins') !== false ? 'active' : '' ?>">
                    <i class="fas fa-users-cog w-6"></i>
                    <span x-show="sidebarOpen">Manage Users</span>
                </a>

                <a href="/admin/roles" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white <?= strpos($_SERVER['REQUEST_URI'], '/admin/roles') !== false ? 'active' : '' ?>">
                    <i class="fas fa-user-shield w-6"></i>
                    <span x-show="sidebarOpen">Role Management</span>
                    <?php
                    $totalUsers = \App\Models\User::count();
                    if ($totalUsers > 0):
                    ?>
                        <span x-show="sidebarOpen" class="ml-auto bg-gray-800 text-gray-300 text-xs px-2 py-1 rounded-full">
                            <?= $totalUsers ?>
                        </span>
                    <?php endif; ?>
                </a>
            <?php endif; ?>

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
                        <div class="relative hidden md:block" x-data="{ searchOpen: false }">
                            <form action="/admin/search" method="GET" class="relative">
                                <input
                                    type="text"
                                    name="q"
                                    placeholder="Search posts, categories..."
                                    value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
                                    @focus="searchOpen = true"
                                    @blur="setTimeout(() => searchOpen = false, 200)"
                                    class="pl-10 pr-4 py-2 w-64 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                                    autocomplete="off">
                                <button type="submit" class="absolute left-3 top-3 text-gray-400 hover:text-black">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>

                            <!-- Search suggestions (optional) -->
                            <div x-show="searchOpen"
                                x-transition
                                class="absolute top-full mt-2 w-64 bg-white border border-gray-200 rounded-lg shadow-lg z-50 hidden">
                                <div class="p-3 text-xs text-gray-500">
                                    <p>Search for posts, categories, or comments</p>
                                </div>
                            </div>
                        </div>

                        <!-- Notifications -->
                        <div class="relative" x-data="{ notifOpen: false }">
                            <button @click="notifOpen = !notifOpen"
                                class="relative p-2 text-gray-600 hover:text-black transition-colors">
                                <i class="fas fa-bell text-xl"></i>
                                <?php if (($pending_comments ?? 0) > 0): ?>
                                    <span class="absolute top-0 right-0 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold">
                                        <?= min($pending_comments ?? 0, 9) ?><?= ($pending_comments ?? 0) > 9 ? '+' : '' ?>
                                    </span>
                                <?php else: ?>
                                    <span class="absolute top-0 right-0 w-2 h-2 bg-gray-400 rounded-full"></span>
                                <?php endif; ?>
                            </button>

                            <!-- Notifications Dropdown -->
                            <div x-show="notifOpen"
                                @click.away="notifOpen = false"
                                x-transition
                                class="absolute right-0 mt-2 w-80 bg-white border border-gray-200 rounded-lg shadow-xl z-50">
                                <div class="p-4 border-b border-gray-200">
                                    <h3 class="font-bold text-gray-900">Notifications</h3>
                                </div>
                                <div class="max-h-96 overflow-y-auto">
                                    <?php if (($pending_comments ?? 0) > 0): ?>
                                        <a href="/admin/comments" class="block p-4 hover:bg-gray-50 transition-colors border-b border-gray-100">
                                            <div class="flex items-start space-x-3">
                                                <div class="flex-shrink-0 w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-comment text-yellow-600"></i>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-semibold text-gray-900">
                                                        <?= $pending_comments ?? 0 ?> Pending Comment<?= ($pending_comments ?? 0) !== 1 ? 's' : '' ?>
                                                    </p>
                                                    <p class="text-xs text-gray-500 mt-1">
                                                        Waiting for your approval
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    <?php endif; ?>

                                    <?php if (($pending_comments ?? 0) === 0): ?>
                                        <div class="p-8 text-center">
                                            <i class="fas fa-bell-slash text-4xl text-gray-300 mb-3"></i>
                                            <p class="text-sm text-gray-500">No new notifications</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="p-3 border-t border-gray-200 text-center">
                                    <a href="/admin/comments" class="text-sm text-black hover:text-gray-700 font-medium">
                                        View All Comments <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
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
                <div class="flex items-center justify-center text-sm text-gray-600">
                    <p>&copy; <?= date('Y') ?> CMS Admin Panel. All rights reserved.</p>
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