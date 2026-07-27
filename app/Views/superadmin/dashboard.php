<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($pageTitle) ?> — LMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<!-- Navbar -->
<nav class="bg-indigo-700 text-white px-6 py-4 flex justify-between items-center shadow">
    <span class="font-bold text-lg tracking-wide">🎓 LMS Super Admin</span>
    <div class="flex items-center gap-4 text-sm">
        <span>👤 <?= esc(session()->get('name')) ?></span>
        <a href="/superadmin/logout"
           class="bg-white text-indigo-700 px-3 py-1 rounded hover:bg-indigo-100 font-medium">
            Logout
        </a>
    </div>
</nav>

<div class="max-w-7xl mx-auto px-4 py-8">

    <!-- Flash messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="mb-4 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded">
            ✅ <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="mb-4 bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded">
            ❌ <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard</h1>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-indigo-500">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Total Tenant</p>
            <p class="text-3xl font-bold text-indigo-600 mt-1"><?= esc($stats['total_tenants']) ?></p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-green-500">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Tenant Aktif</p>
            <p class="text-3xl font-bold text-green-600 mt-1"><?= esc($stats['active_tenants']) ?></p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-blue-500">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Total User</p>
            <p class="text-3xl font-bold text-blue-600 mt-1"><?= esc($stats['total_users']) ?></p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-yellow-500">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Total Course</p>
            <p class="text-3xl font-bold text-yellow-600 mt-1"><?= esc($stats['total_courses']) ?></p>
        </div>
    </div>

    <!-- Header tabel tenant terbaru -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b">
            <h2 class="font-semibold text-gray-700">Tenant Terbaru</h2>
            <a href="/superadmin/tenants/create"
               class="bg-indigo-600 text-white text-sm px-4 py-2 rounded hover:bg-indigo-700">
                + Tambah Tenant
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">Nama Tenant</th>
                        <th class="px-6 py-3">URL Identifier</th>
                        <th class="px-6 py-3">Jumlah User</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Dibuat</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (empty($tenants)): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                                Belum ada tenant terdaftar.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($tenants as $tenant): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-800">
                                <?= esc($tenant['name']) ?>
                            </td>
                            <td class="px-6 py-4">
                                <code class="bg-gray-100 text-indigo-700 px-2 py-0.5 rounded text-xs">
                                    <?= esc($tenant['url_string']) ?>
                                </code>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                <?= esc($userCounts[$tenant['id']] ?? 0) ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php if ($tenant['is_active']): ?>
                                    <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-medium">
                                        Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full font-medium">
                                        Diblokir
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-xs">
                                <?= date('d M Y', strtotime($tenant['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <a href="/superadmin/tenants/<?= $tenant['id'] ?>"
                                       class="text-indigo-600 hover:underline text-xs">Detail</a>
                                    <form method="POST"
                                          action="/superadmin/tenants/<?= $tenant['id'] ?>/toggle"
                                          onsubmit="return confirm('Yakin ubah status tenant ini?')">
                                        <?= csrf_field() ?>
                                        <button type="submit"
                                                class="text-xs <?= $tenant['is_active'] ? 'text-red-500' : 'text-green-600' ?> hover:underline">
                                            <?= $tenant['is_active'] ? 'Blokir' : 'Aktifkan' ?>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if (count($tenants) >= 10): ?>
        <div class="px-6 py-3 border-t text-right">
            <a href="/superadmin/tenants" class="text-sm text-indigo-600 hover:underline">
                Lihat semua tenant →
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>