<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Login — LMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-indigo-50 min-h-screen flex items-center justify-center">

<div class="w-full max-w-md px-4">
    <div class="bg-white rounded-2xl shadow-lg p-8">
        <div class="text-center mb-8">
            <div class="text-4xl mb-2">🎓</div>
            <h1 class="text-xl font-bold text-gray-800">Super Admin</h1>
            <p class="text-sm text-gray-400 mt-1">Learning Management System</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="mb-4 bg-red-50 border border-red-300 text-red-700 text-sm px-4 py-3 rounded-lg">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('message')): ?>
            <div class="mb-4 bg-green-50 border border-green-300 text-green-700 text-sm px-4 py-3 rounded-lg">
                <?= esc(session()->getFlashdata('message')) ?>
            </div>
        <?php endif; ?>

        <?php $errors = session()->getFlashdata('errors') ?? []; ?>

        <form method="POST" action="/superadmin/login">
            <?= csrf_field() ?>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email"
                       value="<?= esc(old('email')) ?>"
                       placeholder="superadmin@lms.local"
                       class="w-full border <?= isset($errors['email']) ? 'border-red-400' : 'border-gray-300' ?>
                              rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                <?php if (isset($errors['email'])): ?>
                    <p class="mt-1 text-xs text-red-500"><?= esc($errors['email']) ?></p>
                <?php endif; ?>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password"
                       placeholder="••••••••"
                       class="w-full border <?= isset($errors['password']) ? 'border-red-400' : 'border-gray-300' ?>
                              rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                <?php if (isset($errors['password'])): ?>
                    <p class="mt-1 text-xs text-red-500"><?= esc($errors['password']) ?></p>
                <?php endif; ?>
            </div>

            <button type="submit"
                    class="w-full bg-indigo-600 text-white font-medium py-2.5 rounded-lg
                           hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-400 transition">
                Masuk
            </button>
        </form>
    </div>
</div>

</body>
</html> 