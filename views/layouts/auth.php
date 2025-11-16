<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Login - Admin Panel' ?></title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body>

    <!-- Flash Messages -->
    <?php
    $successMsg = \App\Core\Session::getFlash('success');
    $errorMsg = \App\Core\Session::getFlash('error');
    ?>

    <?php if ($successMsg): ?>
        <div class="fixed top-4 right-4 z-50 max-w-md">
            <div class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-2xl flex items-center space-x-3 animate-slide-in">
                <i class="fas fa-check-circle text-2xl"></i>
                <p class="font-semibold"><?= htmlspecialchars($successMsg) ?></p>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($errorMsg): ?>
        <div class="fixed top-4 right-4 z-50 max-w-md">
            <div class="bg-red-500 text-white px-6 py-4 rounded-lg shadow-2xl flex items-center space-x-3 animate-slide-in">
                <i class="fas fa-exclamation-circle text-2xl"></i>
                <p class="font-semibold"><?= htmlspecialchars($errorMsg) ?></p>
            </div>
        </div>
    <?php endif; ?>

    <?php require __DIR__ . '/../' . $view . '.php'; ?>

    <style>
        @keyframes slide-in {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .animate-slide-in {
            animation: slide-in 0.3s ease-out;
        }
    </style>

</body>

</html>