<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\IncomingRequest;

class RoleFilter implements FilterInterface
{
    /**
     * $arguments = array of allowed roles dikirim dari Routes.
     * Contoh: filter('role:tenant_admin,super_admin')
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        /** @var IncomingRequest $request */
        $session = session();

        // Fix PHP0416: gunakan getUri() bukan ->uri (property access)
        $tenantString = $request->getUri()->getSegment(1);

        if (! $session->has('user_id')) {
            return redirect()->to("/{$tenantString}/login");
        }

        $sessionRole = $session->get('role');

        if (empty($arguments)) {
            return service('response')
                ->setStatusCode(403)
                ->setBody('403 Forbidden: Konfigurasi role tidak ditemukan.');
        }

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