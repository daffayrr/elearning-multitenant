<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    /**
     * $arguments berisi role yang diizinkan, dikirim dari Routes.
     * Contoh: filter('role:tenant_admin,super_admin')
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session      = session();
        $sessionRole  = $session->get('role');
        $tenantString = $request->uri->getSegment(1);

        // Pastikan user sudah login
        if (! $session->has('user_id')) {
            return redirect()->to("/{$tenantString}/login");
        }

        // Jika tidak ada argumen role yang didefinisikan, tolak akses
        if (empty($arguments)) {
            return service('response')
                ->setStatusCode(403)
                ->setBody('403 Forbidden: Konfigurasi role tidak ditemukan.');
        }

        // Cek apakah role user termasuk dalam role yang diizinkan
        if (! in_array($sessionRole, $arguments, true)) {
            log_message('warning', sprintf(
                '[RoleFilter] Akses ditolak. User ID %s dengan role "%s" mencoba akses halaman yang membutuhkan role: %s',
                $session->get('user_id'),
                $sessionRole,
                implode(', ', $arguments)
            ));

            return service('response')
                ->setStatusCode(403)
                ->setBody('403 Forbidden: Role Anda tidak memiliki izin akses.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}