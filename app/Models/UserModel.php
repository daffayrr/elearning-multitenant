<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table         = 'users';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'tenant_id',
        'name',
        'email',
        'password',
        'role',
        'is_blocked',
        'last_login_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // ─── Jangan pernah return field password ke luar model ───────────────
    protected $hiddenFields = ['password'];

    protected $validationRules = [
        'email'     => 'required|valid_email|max_length[255]',
        'password'  => 'required|min_length[8]',
        'role'      => 'required|in_list[super_admin,tenant_admin,tenant_instructor,tenant_student]',
    ];

    // ─── Hash password otomatis sebelum insert/update ────────────────────
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data): array
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash(
                $data['data']['password'],
                PASSWORD_BCRYPT,
                ['cost' => 12]
            );
        }

        return $data;
    }
}