<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ═══════════════════════════════════════════════════════════════════════════
// DEFAULT ROUTE (Perbaikan untuk GET: /)
// ═══════════════════════════════════════════════════════════════════════════
// Ini akan mengarahkan root url (http://localhost:8080) ke Home controller 
// atau bisa Anda ubah jika ingin langsung redirect ke halaman login
$routes->get('/', 'Home::index'); 
$routes->get('login', 'Home::globalLogin');
$routes->get('register-institution', 'Home::registerInstitution');
$routes->post('register-institution', 'Home::storeInstitution');

// ═══════════════════════════════════════════════════════════════════════════
// SUPER ADMIN ROUTES
// ═══════════════════════════════════════════════════════════════════════════
$routes->group('superadmin', static function ($routes) {

    // Rute publik super admin (login tidak butuh filter)
    $routes->get('login',  'SuperAdmin\AuthController::loginForm');
    $routes->post('login', 'SuperAdmin\AuthController::loginProcess');

    // Semua rute di bawah ini dilindungi SuperAdminFilter
    $routes->group('', ['filter' => 'superadmin'], static function ($routes) {
        
        // Perbaikan untuk GET: superadmin
        // Menangani url http://localhost:8080/superadmin agar langsung ke dashboard
        $routes->get('/', 'SuperAdmin\SuperAdminController::index');

        $routes->get('logout',   'SuperAdmin\AuthController::logout');

        // Dashboard
        $routes->get('dashboard', 'SuperAdmin\SuperAdminController::index');

        // Tenant Management
        $routes->get('tenants',              'SuperAdmin\SuperAdminController::tenantList');
        $routes->get('tenants/create',       'SuperAdmin\SuperAdminController::createTenant');
        $routes->post('tenants/store',       'SuperAdmin\SuperAdminController::storeTenant');
        $routes->post('tenants/(:num)/toggle', 'SuperAdmin\SuperAdminController::toggleBlockTenant/$1');
        $routes->get('tenants/(:num)',       'SuperAdmin\SuperAdminController::showTenant/$1');
    });
});

// ═══════════════════════════════════════════════════════════════════════════
// TENANT DYNAMIC ROUTES
// ═══════════════════════════════════════════════════════════════════════════
$routes->group('(:segment)', static function ($routes) {

    // Public
    $routes->get('/',        'Auth\AuthController::tenantIndex/$1');
    $routes->get('login',    'Auth\AuthController::loginForm/$1');
    $routes->post('login',   'Auth\AuthController::loginProcess/$1');
    $routes->get('logout',   'Auth\AuthController::logout/$1');
    $routes->get('register', 'Auth\AuthController::registerForm/$1');
    $routes->post('register','Auth\AuthController::registerProcess/$1');

    // Downloads
    $routes->get('download/s3', 'DownloadController::s3/$1');

    // Tenant Admin
    $routes->group('admin_tenant', ['filter' => ['tenant', 'role:tenant_admin']], static function ($routes) {
        $routes->get('dashboard',              'TenantAdmin\DashboardController::index/$1');
        $routes->get('users',                  'TenantAdmin\UserController::index/$1');
        $routes->post('users/(:num)/block',    'TenantAdmin\UserController::block/$1/$2');
        $routes->post('users/(:num)/unblock',  'TenantAdmin\UserController::unblock/$1/$2');
        $routes->get('users/import',           'TenantAdmin\UserController::importForm/$1');
        $routes->post('users/import',          'TenantAdmin\UserController::importProcess/$1');

        // Instructors
        $routes->get('instructors',                     'TenantAdmin\InstructorController::index/$1');
        $routes->post('instructors',                    'TenantAdmin\InstructorController::store/$1');
        $routes->post('instructors/(:num)/update',      'TenantAdmin\InstructorController::update/$1/$2');
        $routes->post('instructors/(:num)/delete',      'TenantAdmin\InstructorController::delete/$1/$2');
        $routes->post('instructors/import',             'TenantAdmin\InstructorController::importExcel/$1');
        $routes->get('instructors/download-template',   'TenantAdmin\InstructorController::downloadTemplate/$1');

        // Students
        $routes->get('students',                        'TenantAdmin\StudentController::index/$1');
        $routes->post('students',                       'TenantAdmin\StudentController::store/$1');
        $routes->post('students/(:num)/update',         'TenantAdmin\StudentController::update/$1/$2');
        $routes->post('students/(:num)/delete',         'TenantAdmin\StudentController::delete/$1/$2');
        $routes->post('students/(:num)/block',          'TenantAdmin\StudentController::block/$1/$2');
        $routes->post('students/(:num)/unblock',        'TenantAdmin\StudentController::unblock/$1/$2');
        $routes->post('students/import',                'TenantAdmin\StudentController::importExcel/$1');
        $routes->get('students/download-template',      'TenantAdmin\StudentController::downloadTemplate/$1');

        // Courses
        $routes->get('courses',                         'TenantAdmin\CourseController::index/$1');
        $routes->get('courses/create',                  'TenantAdmin\CourseController::create/$1');
        $routes->post('courses',                        'TenantAdmin\CourseController::store/$1');
        $routes->get('courses/(:num)',                  'TenantAdmin\CourseController::show/$1/$2');

        // Admins
        $routes->get('admins',                          'TenantAdmin\AdminController::index/$1');
        $routes->post('admins/store',                   'TenantAdmin\AdminController::store/$1');
        $routes->post('admins/delete/(:num)',           'TenantAdmin\AdminController::delete/$1/$2');

        // Settings
        $routes->get('settings',                        'TenantAdmin\SettingController::index/$1');
        $routes->post('settings',                       'TenantAdmin\SettingController::update/$1');
        
        // Announcements
        $routes->get('announcements',                   'TenantAdmin\AnnouncementController::index/$1');
        $routes->post('announcements',                  'TenantAdmin\AnnouncementController::store/$1');
        $routes->post('announcements/(:num)/delete',    'TenantAdmin\AnnouncementController::delete/$1/$2');
    });

    // Instructor
    $routes->group('instructor', ['filter' => ['tenant', 'role:instructor']], static function ($routes) {
        $routes->get('/', 'Instructor\DashboardController::index/$1');
        $routes->get('dashboard', 'Instructor\DashboardController::index/$1');
        $routes->get('courses',   'Instructor\CourseController::index/$1');
        $routes->post('courses',  'Instructor\CourseController::storeCourse/$1');
        $routes->post('course/(:num)/update', 'Instructor\CourseController::updateCourse/$1/$2');
        $routes->post('course/(:num)/delete', 'Instructor\CourseController::deleteCourse/$1/$2');
        $routes->get('course/(:num)/preview', 'Instructor\CourseController::previewCourse/$1/$2');
        $routes->get('course/(:num)', 'Instructor\CourseController::courseDetail/$1/$2');
        $routes->get('course/(:num)/enrollments', 'Instructor\CourseController::enrollments/$1/$2');
        $routes->post('enrollment/(:num)/approve', 'Instructor\CourseController::approveEnrollment/$1/$2');
        $routes->post('enrollment/(:num)/reject', 'Instructor\CourseController::rejectEnrollment/$1/$2');
        $routes->post('course/(:num)/module', 'Instructor\CourseController::storeModule/$1/$2');
        $routes->post('course/(:num)/assignment', 'Instructor\CourseController::storeAssignment/$1/$2');

        // Students Management
        $routes->get('students',                        'Instructor\StudentController::index/$1');
        $routes->post('students',                       'Instructor\StudentController::store/$1');
        $routes->post('students/(:num)/update',         'Instructor\StudentController::update/$1/$2');
        $routes->post('students/(:num)/delete',         'Instructor\StudentController::delete/$1/$2');
        $routes->post('students/(:num)/block',          'Instructor\StudentController::block/$1/$2');
        $routes->post('students/(:num)/unblock',        'Instructor\StudentController::unblock/$1/$2');
        $routes->post('students/import',                'Instructor\StudentController::importExcel/$1');
        $routes->get('students/download-template',      'Instructor\StudentController::downloadTemplate/$1');

        // Quiz Banks (CBT System)
        $routes->get('quiz-banks',                      'Instructor\QuizBankController::index/$1');
        $routes->post('quiz-banks',                     'Instructor\QuizBankController::storeBank/$1');
        $routes->post('quiz-banks/(:num)/delete',       'Instructor\QuizBankController::deleteBank/$1/$2');
        $routes->get('quiz-banks/download-template',    'Instructor\QuizBankController::downloadTemplate/$1');
        $routes->post('quiz-banks/(:num)/import',       'Instructor\QuizBankController::importExcel/$1/$2');
        $routes->get('quiz-banks/(:num)',               'Instructor\QuizBankController::showBank/$1/$2');
        $routes->post('quiz-banks/(:num)/question',     'Instructor\QuizBankController::storeQuestion/$1/$2');
        $routes->post('quiz-banks/question/(:num)/update', 'Instructor\QuizBankController::updateQuestion/$1/$2');
        $routes->post('quiz-banks/question/(:num)/delete', 'Instructor\QuizBankController::deleteQuestion/$1/$2');

        // Scoring System
        $routes->get('scoring',                         'Instructor\ScoringController::index/$1');
        $routes->get('scoring/(:num)',                  'Instructor\ScoringController::courseScoring/$1/$2');
        $routes->get('scoring/(:num)/export',           'Instructor\ScoringController::exportScoring/$1/$2');

        // Announcements
        $routes->get('announcements',                   'Instructor\AnnouncementController::index/$1');
        $routes->post('announcements',                  'Instructor\AnnouncementController::store/$1');
        $routes->post('announcements/(:num)/delete',    'Instructor\AnnouncementController::delete/$1/$2');
    });

    // Student
    $routes->group('student', ['filter' => ['tenant', 'role:student']], static function ($routes) {
        $routes->get('dashboard', 'Student\DashboardController::index/$1');
        $routes->get('courses',   'Student\CourseController::index/$1');
        $routes->get('all-courses', 'Student\CourseController::allCourses/$1');
        $routes->post('course/(:num)/enroll', 'Student\CourseController::enroll/$1/$2');
        $routes->get('course/(:num)', 'Student\CourseController::show/$1/$2'); // Actually view the course content if enrolled
        
        // Announcements
        $routes->get('announcements', 'Student\AnnouncementController::index/$1');

        // Akademik
        $routes->get('assignments', 'Student\AssignmentController::index/$1');
        $routes->post('assignments/(:num)/submit', 'Student\AssignmentController::submit/$1/$2');
        $routes->get('exams', 'Student\ExamController::index/$1');
        $routes->get('exams/start/(:num)', 'Student\ExamController::start/$1/$2');
        $routes->post('exams/submit/(:num)', 'Student\ExamController::submit/$1/$2');
        $routes->get('scores', 'Student\ScoreController::index/$1');
    });
});