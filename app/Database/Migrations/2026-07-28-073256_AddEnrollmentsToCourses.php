<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEnrollmentsToCourses extends Migration
{
    public function up()
    {
        // Already created manually / failed midway
    }

    public function down()
    {
        $this->forge->dropTable('course_enrollments');
        $this->forge->dropColumn('courses', 'enrollment_key');
    }
}
