<?php

namespace App\Models;

use CodeIgniter\Model;

class TenantModel extends Model
{
    protected $table            = 'tenants';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object'; 
    
    // UBAH NILAI INI MENJADI FALSE
    protected $useSoftDeletes   = false; 
    
    protected $allowedFields    = [
        'tenant_string_id', 'name', 'domain', 'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; 
    protected $deletedField  = 'deleted_at';
}