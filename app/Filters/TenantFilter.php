<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\TenantModel;

class TenantFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // ─── 1. Ekstrak segmen pertama URL ───────────────────────────────────
        // Contoh URL: /almaata_ac_id_tenant_id_3/admin_tenant/dashboard
        $tenantStringId = service('router')->detectedLocale()
            ?? $request->uri->getSegment(1);

        // Jika tidak ada segmen pertama, tolak akses
        if (empty($tenantStringId)) {
            return service('response')
                ->setStatusCode(403)
                ->setBody('403 Forbidden: Tenant identifier missing.');
        }

        // ─── 2. Validasi tenant string ke database ───────────────────────────
        $tenantModel = new TenantModel();
        $tenant = $tenantModel->where('url_string', $tenantStringId)
                              ->where('is_active', 1)
                              ->first();

        if (! $tenant) {
            return service('response')
                ->setStatusCode(403)
                ->setBody('403 Forbidden: Tenant tidak valid atau tidak aktif.');
        }

        // ─── 3. Simpan tenant ke dalam session & $GLOBALS untuk akses global ─
        // Ini memungkinkan controller mengakses tenant context tanpa query ulang
        $session->set('current_tenant_id', $tenant['id']);
        $session->set('current_tenant_string', $tenantStringId);

        // ─── 4. Cek apakah user sudah login ──────────────────────────────────
        if (! $session->has('user_id')) {
            // Belum login — redirect ke halaman login tenant
            return redirect()->to("/{$tenantStringId}/login");
        }

        $sessionTenantId = $session->get('tenant_id');   // tenant_id dari sesi login
        $sessionRole     = $session->get('role');

        // ─── 5. Super Admin bypass — boleh akses tenant manapun ──────────────
        // Super Admin memiliki tenant_id = NULL di database
        if ($sessionRole === 'super_admin' && is_null($sessionTenantId)) {
            return; // Lanjutkan tanpa blokir
        }

        // ─── 6. Validasi silang: tenant_id sesi VS tenant dari URL ───────────
        // Ini adalah inti isolasi multi-tenant: user A tidak boleh akses URL tenant B
        if ((int) $sessionTenantId !== (int) $tenant['id']) {
            // Catat percobaan akses ilegal untuk audit
            log_message('warning', sprintf(
                '[TenantFilter] Akses ilegal! User ID %s (tenant_id=%s) mencoba akses tenant "%s" (id=%s). IP: %s',
                $session->get('user_id'),
                $sessionTenantId,
                $tenantStringId,
                $tenant['id'],
                $request->getIPAddress()
            ));

            return service('response')
                ->setStatusCode(403)
                ->setBody('403 Forbidden: Anda tidak memiliki akses ke tenant ini.');
        }

        // Semua validasi lolos, lanjutkan request
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada post-processing yang diperlukan
    }
}