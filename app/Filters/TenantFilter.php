<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\IncomingRequest;
use App\Models\TenantModel;

class TenantFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        /** @var IncomingRequest $request */
        $session = session();

        // ─── 1. Ekstrak segmen pertama URL ───────────────────────────────────
        // Cast ke IncomingRequest agar akses ->uri valid (fix PHP0416)
        $tenantStringId = $request->getUri()->getSegment(1);

        if (empty($tenantStringId)) {
            return service('response')
                ->setStatusCode(403)
                ->setBody('403 Forbidden: Tenant identifier missing.');
        }

        // ─── 2. Validasi tenant ke database ──────────────────────────────────
        $tenantModel = new TenantModel();
        $tenant = $tenantModel
            ->where('tenant_string_id', $tenantStringId)
            ->where('status', 'active')
            ->first();

        if (! $tenant) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Tenant tidak ditemukan atau diblokir.');
        }

        // Simpan ke session agar controller tidak perlu query ulang
        $session->set('current_tenant_id',     $tenant->id);
        $session->set('current_tenant_string',  $tenantStringId);

        // ─── 3. Cek login ─────────────────────────────────────────────────────
        if (! $session->has('user_id')) {
            return redirect()->to("/{$tenantStringId}/login");
        }

        $sessionTenantId = $session->get('tenant_id');
        $sessionRole     = $session->get('role');

        // ─── 4. Super Admin bypass ────────────────────────────────────────────
        if ($sessionRole === 'super_admin' && is_null($sessionTenantId)) {
            return;
        }

        // ─── 5. Validasi silang tenant_id sesi vs URL ─────────────────────────
        if ((int) $sessionTenantId !== (int) $tenant->id) {
            log_message('warning', sprintf(
                '[TenantFilter] Akses ilegal! User ID %s (tenant_id=%s) mencoba akses tenant "%s" (id=%s). IP: %s',
                $session->get('user_id'),
                $sessionTenantId,
                $tenantStringId,
                $tenant->id,
                $request->getIPAddress()
            ));

            return service('response')
                ->setStatusCode(403)
                ->setBody('403 Forbidden: Anda tidak memiliki akses ke tenant ini.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}