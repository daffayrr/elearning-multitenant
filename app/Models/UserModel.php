<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object'; // atau 'array', sesuaikan dengan kode Claude sebelumnya
    
    // UBAH NILAI INI MENJADI FALSE
    protected $useSoftDeletes   = false; 
    
    protected $allowedFields    = [
        'tenant_id', 'role', 'full_name', 'username', 'email', 'password_hash', 'is_blocked'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // Kosongkan jika tidak ada di DB
    protected $deletedField  = 'deleted_at';
}