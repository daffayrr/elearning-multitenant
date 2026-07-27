<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ═══════════════════════════════════════════════════════════════════════════
// RUTE PUBLIK (tanpa autentikasi)
// ═══════════════════════════════════════════════════════════════════════════
$routes->get('/', 'HomeController::index');

// ─── Super Admin Routes (tidak terikat tenant, login terpisah) ────────────
$routes->group('superadmin', static function ($routes) {
    $routes->get('login',  'SuperAdmin\AuthController::loginForm');
    $routes->post('login', 'SuperAdmin\AuthController::loginProcess');
    $routes->get('logout', 'SuperAdmin\AuthController::logout');

    // Semua rute super admin dilindungi role filter
    $routes->group('', ['filter' => 'role:super_admin'], static function ($routes) {
        $routes->get('dashboard',          'SuperAdmin\DashboardController::index');
        $routes->get('tenants',            'SuperAdmin\TenantController::index');
        $routes->post('tenants/create',    'SuperAdmin\TenantController::create');
        $routes->post('tenants/(:num)/toggle', 'SuperAdmin\TenantController::toggleActive/$1');
    });
});


// ═══════════════════════════════════════════════════════════════════════════
// RUTE DINAMIS TENANT
// Pola: /{tenant_string_id}/{area}/{resource}
// Contoh: /almaata_ac_id_tenant_id_3/admin_tenant/dashboard
//
// PERHATIAN: Segmen pertama ditangkap sebagai `tenant_string_id`.
// Semua rute di dalam group ini akan melewati TenantFilter terlebih dahulu.
// ═══════════════════════════════════════════════════════════════════════════
$routes->group('(:segment)', static function ($routes) {

    // ─── Rute Login/Logout Tenant (PUBLIC — sebelum TenantFilter auth check) ─
    // TenantFilter tetap berjalan untuk validasi tenant, tapi belum cek sesi user.
    // Catatan: route login dikecualikan dari redirect loop via logika di filter.
    $routes->get('login',          'Auth\AuthController::loginForm/$1');
    $routes->post('login',         'Auth\AuthController::loginProcess/$1');
    $routes->get('logout',         'Auth\AuthController::logout/$1');
    $routes->get('register',       'Auth\AuthController::registerForm/$1');
    $routes->post('register',      'Auth\AuthController::registerProcess/$1');


    // ─────────────────────────────────────────────────────────────────────
    // AREA: TENANT ADMIN
    // Filter: tenant (validasi tenant & sesi) + role:tenant_admin
    // ─────────────────────────────────────────────────────────────────────
    $routes->group('admin_tenant', ['filter' => 'tenant|role:tenant_admin'], static function ($routes) {
        $routes->get('dashboard',              'TenantAdmin\DashboardController::index/$1');
        $routes->get('users',                  'TenantAdmin\UserController::index/$1');
        $routes->get('users/(:num)',           'TenantAdmin\UserController::show/$1/$2');
        $routes->post('users/(:num)/block',    'TenantAdmin\UserController::block/$1/$2');
        $routes->post('users/(:num)/unblock',  'TenantAdmin\UserController::unblock/$1/$2');
        $routes->get('users/import',           'TenantAdmin\UserController::importForm/$1');
        $routes->post('users/import',          'TenantAdmin\UserController::importProcess/$1');
        $routes->get('courses',                'TenantAdmin\CourseController::index/$1');
        $routes->get('reports',                'TenantAdmin\ReportController::index/$1');
    });


    // ─────────────────────────────────────────────────────────────────────
    // AREA: INSTRUCTOR
    // Filter: tenant + role:tenant_instructor
    // ─────────────────────────────────────────────────────────────────────
    $routes->group('instructor', ['filter' => 'tenant|role:tenant_instructor'], static function ($routes) {
        $routes->get('dashboard',                        'Instructor\DashboardController::index/$1');

        // Course management
        $routes->get('courses',                          'Instructor\CourseController::index/$1');
        $routes->get('courses/create',                   'Instructor\CourseController::createForm/$1');
        $routes->post('courses/create',                  'Instructor\CourseController::createProcess/$1');
        $routes->get('courses/(:num)',                   'Instructor\CourseController::show/$1/$2');
        $routes->get('courses/(:num)/edit',              'Instructor\CourseController::editForm/$1/$2');
        $routes->post('courses/(:num)/edit',             'Instructor\CourseController::editProcess/$1/$2');

        // Module management
        $routes->get('courses/(:num)/modules/create',    'Instructor\ModuleController::createForm/$1/$2');
        $routes->post('courses/(:num)/modules/create',   'Instructor\ModuleController::createProcess/$1/$2');
        $routes->get('courses/(:num)/modules/(:num)',    'Instructor\ModuleController::show/$1/$2/$3');

        // Assignment (CBT & Submission)
        $routes->get('courses/(:num)/assignments',       'Instructor\AssignmentController::index/$1/$2');
        $routes->post('courses/(:num)/assignments/create', 'Instructor\AssignmentController::create/$1/$2');

        // Student enrollment approval
        $routes->get('courses/(:num)/enrollments',       'Instructor\EnrollmentController::index/$1/$2');
        $routes->post('courses/(:num)/enrollments/(:num)/approve', 'Instructor\EnrollmentController::approve/$1/$2/$3');
        $routes->post('courses/(:num)/enrollments/(:num)/reject',  'Instructor\EnrollmentController::reject/$1/$2/$3');
    });


    // ─────────────────────────────────────────────────────────────────────
    // AREA: STUDENT
    // Filter: tenant + role:tenant_student
    // ─────────────────────────────────────────────────────────────────────
    $routes->group('student', ['filter' => 'tenant|role:tenant_student'], static function ($routes) {
        $routes->get('dashboard',                        'Student\DashboardController::index/$1');
        $routes->get('courses',                          'Student\CourseController::index/$1');
        $routes->get('courses/(:num)',                   'Student\CourseController::show/$1/$2');
        $routes->post('courses/(:num)/enroll',           'Student\CourseController::enroll/$1/$2');
        $routes->get('courses/(:num)/modules/(:num)',    'Student\ModuleController::show/$1/$2/$3');
        $routes->get('assignments/(:num)',               'Student\AssignmentController::show/$1/$2');
        $routes->post('assignments/(:num)/submit',       'Student\AssignmentController::submit/$1/$2');
    });

});