<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNewFeaturesForInstructor extends Migration
{
    public function up()
    {
        // 1. Modify assignments table
        $this->forge->modifyColumn('assignments', [
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['submission', 'quiz', 'essay', 'cbt'],
                'default'    => 'submission',
            ],
        ]);
        
        $this->forge->addColumn('assignments', [
            'question_bank_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ]
        ]);

        // 2. Create student_submissions table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'assignment_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'student_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'file_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'essay_answer' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'score' => [
                'type' => 'INT',
                'constraint' => 3,
                'null' => true,
            ],
            'feedback' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('student_submissions');

        // 3. Create question_banks table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tenant_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'instructor_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('question_banks');

        // 4. Create questions table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'question_bank_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['multiple_choice', 'essay'],
                'default'    => 'multiple_choice',
            ],
            'question_text' => [
                'type' => 'TEXT',
            ],
            'options' => [
                'type' => 'TEXT', // Will store JSON for multiple choice options
                'null' => true,
            ],
            'correct_answer' => [
                'type' => 'TEXT', // A, B, C, D or Essay answer guide
                'null' => true,
            ],
            'points' => [
                'type' => 'INT',
                'constraint' => 3,
                'default' => 10,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('questions');
    }

    public function down()
    {
        $this->forge->dropTable('questions');
        $this->forge->dropTable('question_banks');
        $this->forge->dropTable('student_submissions');
        $this->forge->dropColumn('assignments', 'question_bank_id');
        $this->forge->modifyColumn('assignments', [
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['submission', 'quiz'],
                'default'    => 'submission',
            ],
        ]);
    }
}
