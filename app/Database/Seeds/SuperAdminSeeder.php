<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'tenant_id'     => null,
            'role'          => 'super_admin',
            'full_name'     => 'Super Admin', // Sebelumnya 'name', di tabel 'full_name'
            'username'      => 'superadmin',  // Wajib diisi sesuai struktur database
            'email'         => 'superadmin@lms.local',
            'password_hash' => password_hash('rahasia123', PASSWORD_DEFAULT), // Sebelumnya 'password', di tabel 'password_hash'
            'is_blocked'    => 0,
            'created_at'    => date('Y-m-d H:i:s'),
        ];

        // Hapus updated_at karena kolom tersebut tidak ada di struktur tabel users
        $this->db->table('users')->insert($data);
    }
}