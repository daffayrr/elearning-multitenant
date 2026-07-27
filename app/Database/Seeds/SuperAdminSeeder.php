<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\CLI\CLI;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'tenant_id'     => null,          // Super Admin tidak terikat tenant
            'name'          => 'Super Admin',
            'email'         => 'superadmin@lms.local',
            'password'      => password_hash('SuperAdmin@2025!', PASSWORD_BCRYPT, ['cost' => 12]),
            'role'          => 'super_admin',
            'is_blocked'    => 0,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ];

        // Cek apakah super admin sudah ada (idempotent seeder)
        $existing = $this->db->table('users')
            ->where('email', $data['email'])
            ->where('role', 'super_admin')
            ->get()
            ->getRow();

        if ($existing) {
            CLI::write('[SuperAdminSeeder] Super Admin sudah ada, seeder dilewati.', 'yellow');
            return;
        }

        $this->db->table('users')->insert($data);

        CLI::write('[SuperAdminSeeder] Super Admin berhasil dibuat.', 'green');
        CLI::write('  Email    : ' . $data['email'], 'cyan');
        CLI::write('  Password : SuperAdmin@2025!', 'cyan');
        CLI::write('  PENTING  : Segera ganti password setelah login pertama!', 'red');
    }
}