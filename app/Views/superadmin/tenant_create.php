<?php
/**
 * @var string $pageTitle
 */
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($pageTitle) ?> — LMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<nav class="bg-indigo-700 text-white px-6 py-4 flex justify-between items-center shadow">
    <span class="font-bold text-lg">🎓 LMS Super Admin</span>
    <div class="flex items-center gap-4 text-sm">
        <a href="/superadmin/dashboard" class="hover:underline">← Dashboard</a>
        <a href="/superadmin/logout"
           class="bg-white text-indigo-700 px-3 py-1 rounded hover:bg-indigo-100 font-medium">
            Logout
        </a>
    </div>
</nav>

<div class="max-w-3xl mx-auto px-4 py-8">

    <!-- Flash error global -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="mb-4 bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded">
            ❌ <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl shadow p-8">
        <h1 class="text-xl font-bold text-gray-800 mb-1"><?= esc($pageTitle) ?></h1>
        <p class="text-sm text-gray-500 mb-6">
            Tenant baru akan langsung memiliki satu akun Tenant Admin yang bisa login.
        </p>

        <?php
        // Helper untuk tampilkan pesan error per field
        $errors = session()->getFlashdata('errors') ?? [];
        $old    = fn(string $key, string $default = '') =>
            esc(old($key, $default));
        $err    = fn(string $key) => isset($errors[$key])
            ? '<p class="mt-1 text-xs text-red-500">' . esc($errors[$key]) . '</p>'
            : '';
        $inputCls = fn(string $key) => 'w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 '
            . (isset($errors[$key]) ? 'border-red-400 bg-red-50' : 'border-gray-300');
        ?>

        <form method="POST" action="/superadmin/tenants/store" novalidate>
            <?= csrf_field() ?>

            <!-- ─── Section: Data Tenant ─────────────────────────────── -->
            <div class="mb-6">
                <h2 class="text-sm font-semibold text-indigo-700 uppercase tracking-wide mb-4
                            border-b border-indigo-100 pb-2">
                    Informasi Tenant
                </h2>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Tenant <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="tenant_name"
                           value="<?= $old('tenant_name') ?>"
                           placeholder="Contoh: Universitas Al-Ma'ata"
                           class="<?= $inputCls('tenant_name') ?>">
                    <?= $err('tenant_name') ?>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        URL Identifier <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center border rounded-lg overflow-hidden
                                <?= isset($errors['url_string']) ? 'border-red-400' : 'border-gray-300' ?>">
                        <span class="bg-gray-100 text-gray-500 text-sm px-3 py-2 border-r border-gray-300
                                     whitespace-nowrap">
                            lms.domain.com/
                        </span>
                        <input type="text" name="url_string"
                               value="<?= $old('url_string') ?>"
                               placeholder="almaata_ac_id_tenant_id_3"
                               class="flex-1 px-3 py-2 text-sm focus:outline-none focus:ring-2
                                      focus:ring-indigo-400 <?= isset($errors['url_string']) ? 'bg-red-50' : '' ?>">
                    </div>
                    <p class="mt-1 text-xs text-gray-400">
                        Hanya huruf, angka, strip (-), dan underscore (_). Tidak bisa diubah setelah disimpan.
                    </p>
                    <?= $err('url_string') ?>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Domain Custom <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <input type="url" name="domain"
                           value="<?= $old('domain') ?>"
                           placeholder="https://lms.universitascontoh.ac.id"
                           class="<?= $inputCls('domain') ?>">
                    <?= $err('domain') ?>
                </div>
            </div>

            <!-- ─── Section: Data Tenant Admin ──────────────────────── -->
            <div class="mb-6">
                <h2 class="text-sm font-semibold text-indigo-700 uppercase tracking-wide mb-4
                            border-b border-indigo-100 pb-2">
                    Akun Tenant Admin Perdana
                </h2>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Admin <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="admin_name"
                           value="<?= $old('admin_name') ?>"
                           placeholder="Contoh: Admin LMS Al-Ma'ata"
                           class="<?= $inputCls('admin_name') ?>">
                    <?= $err('admin_name') ?>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Email Admin <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="admin_email"
                           value="<?= $old('admin_email') ?>"
                           placeholder="admin@universitascontoh.ac.id"
                           class="<?= $inputCls('admin_email') ?>">
                    <?= $err('admin_email') ?>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="admin_password"
                               placeholder="Min. 8 karakter"
                               class="<?= $inputCls('admin_password') ?>">
                        <p class="mt-1 text-xs text-gray-400">
                            Harus ada huruf besar, kecil, dan angka.
                        </p>
                        <?= $err('admin_password') ?>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="admin_password_confirm"
                               placeholder="Ulangi password"
                               class="<?= $inputCls('admin_password_confirm') ?>">
                        <?= $err('admin_password_confirm') ?>
                    </div>
                </div>
            </div>

            <!-- ─── Actions ──────────────────────────────────────────── -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="/superadmin/tenants"
                   class="px-5 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2 text-sm font-medium bg-indigo-600 text-white rounded-lg
                               hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-400">
                    Simpan Tenant
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Auto-generate URL identifier dari nama tenant -->
<script>
    const nameInput   = document.querySelector('input[name="tenant_name"]');
    const urlInput    = document.querySelector('input[name="url_string"]');
    let   urlTouched  = urlInput.value.length > 0;

    urlInput.addEventListener('input', () => { urlTouched = true; });

    nameInput.addEventListener('input', function () {
        if (urlTouched) return;
        urlInput.value = this.value
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s_-]/g, '')   // hapus karakter tidak valid
            .replace(/\s+/g, '_')              // spasi → underscore
            .replace(/_+/g, '_')               // deduplikasi underscore
            .substring(0, 100);
    });
</script>

</body>
</html>