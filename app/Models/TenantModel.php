<?php

namespace App\Models;

use CodeIgniter\Model;

class TenantModel extends Model
{
    protected $table         = 'tenants';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'name',
        'url_string',   // slug unik: "almaata_ac_id_tenant_id_3"
        'domain',       // domain custom jika ada
        'is_active',
        'storage_bucket',
        'settings',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validasi di level model sebagai lapisan kedua pertahanan
    protected $validationRules = [
        'name'       => 'required|min_length[3]|max_length[150]',
        'url_string' => 'required|alpha_dash|max_length[100]|is_unique[tenants.url_string,id,{id}]',
        'is_active'  => 'in_list[0,1]',
    ];
}