<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTenantsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'url_string' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'comment'    => 'Slug unik untuk segmen URL pertama',
            ],
            'domain' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'default'    => null,
            ],
            'storage_bucket' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'settings' => [
                'type' => 'JSON',
                'null' => true,
            ],
            'is_active' => [
                'type'    => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('url_string');
        $this->forge->createTable('tenants');
    }

    public function down(): void
    {
        $this->forge->dropTable('tenants');
    }
}