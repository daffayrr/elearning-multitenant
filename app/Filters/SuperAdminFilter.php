<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class SuperAdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // ─── Cek login ────────────────────────────────────────────────────
        if (! $session->has('user_id')) {
            return redirect()->to('/superadmin/login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // ─── Cek role: hanya super_admin yang boleh ───────────────────────
        // Double-check: role harus super_admin DAN tenant_id harus NULL
        if ($session->get('role') !== 'super_admin' || ! is_null($session->get('tenant_id'))) {
            log_message('warning', sprintf(
                '[SuperAdminFilter] Akses ditolak. User ID %s (role: %s) mencoba akses area Super Admin. IP: %s',
                $session->get('user_id'),
                $session->get('role'),
                $request->getIPAddress()
            ));

            return service('response')
                ->setStatusCode(403)
                ->setBody('403 Forbidden: Akses khusus Super Admin.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}