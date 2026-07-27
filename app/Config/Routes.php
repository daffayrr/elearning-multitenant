<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ═══════════════════════════════════════════════════════════════════════════
// DEFAULT ROUTE (Perbaikan untuk GET: /)
// ═══════════════════════════════════════════════════════════════════════════
// Ini akan mengarahkan root url (http://localhost:8080) ke Home controller 
// atau bisa Anda ubah jika ingin langsung redirect ke halaman login
$routes->get('/', 'Home::index'); 

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
    $routes->get('login',    'Auth\AuthController::loginForm/$1');
    $routes->post('login',   'Auth\AuthController::loginProcess/$1');
    $routes->get('logout',   'Auth\AuthController::logout/$1');
    $routes->get('register', 'Auth\AuthController::registerForm/$1');
    $routes->post('register','Auth\AuthController::registerProcess/$1');

    // Tenant Admin
    $routes->group('admin_tenant', ['filter' => 'tenant|role:tenant_admin'], static function ($routes) {
        $routes->get('dashboard',              'TenantAdmin\DashboardController::index/$1');
        $routes->get('users',                  'TenantAdmin\UserController::index/$1');
        $routes->post('users/(:num)/block',    'TenantAdmin\UserController::block/$1/$2');
        $routes->post('users/(:num)/unblock',  'TenantAdmin\UserController::unblock/$1/$2');
        $routes->get('users/import',           'TenantAdmin\UserController::importForm/$1');
        $routes->post('users/import',          'TenantAdmin\UserController::importProcess/$1');
    });

    // Instructor
    $routes->group('instructor', ['filter' => 'tenant|role:tenant_instructor'], static function ($routes) {
        $routes->get('dashboard', 'Instructor\DashboardController::index/$1');
        $routes->get('courses',   'Instructor\CourseController::index/$1');
    });

    // Student
    $routes->group('student', ['filter' => 'tenant|role:tenant_student'], static function ($routes) {
        $routes->get('dashboard', 'Student\DashboardController::index/$1');
        $routes->get('courses',   'Student\CourseController::index/$1');
    });
});