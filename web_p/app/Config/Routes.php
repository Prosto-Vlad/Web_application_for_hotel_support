<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'SigninController::index');

$routes->get('signin', 'SigninController::index');
$routes->post('signin', 'SigninController::signin');

$routes->get('logout', 'LogoutController::logout');


$routes->get('manager', 'roles_controllers\ManagerController::index');
$routes->group('manager', ['namespace' => 'App\Controllers\roles_controllers\manager'], function ($routes) {
    $routes->get('workers', 'WorkersController::index');
    $routes->post('workers/search', 'WorkersController::search_worker');
    $routes->post('workers/add', 'WorkersController::add_worker');
    $routes->get('workers/update/(:any)', 'WorkersController::load_upd_view/$1');
    $routes->post('workers/update', 'WorkersController::update_worker');

    $routes->get('customers', 'CustomersController::index');
    $routes->post('customers/search', 'CustomersController::search_customer');
    $routes->post('customers/add', 'CustomersController::add_customer');
    $routes->get('customers/update/(:any)', 'CustomersController::load_upd_view/$1');
    $routes->post('customers/update', 'CustomersController::update_customer');

    $routes->get('services', 'ServicesController::index');
    $routes->post('services/search', 'ServicesController::search_services');
    $routes->post('services/add', 'ServicesController::add_services');
    $routes->get('services/update/(:any)', 'ServicesController::load_upd_view/$1');
    $routes->post('services/update', 'ServicesController::update_service');

    $routes->get('orders', 'OrdersController::index');
    $routes->post('orders/search', 'OrdersController::search_order');
    $routes->get('orders/update/(:any)', 'OrdersController::load_upd_view/$1');
    $routes->post('orders/update', 'OrdersController::update_order');
    $routes->post('orders/delete_task', 'OrdersController::delete_task');

    $routes->get('rooms', 'RoomsController::index');
    $routes->post('rooms/search', 'RoomsController::search_room');
    $routes->post('rooms/info', 'RoomsController::info');
    $routes->get('rooms/update/(:any)', 'RoomsController::load_upd_view/$1');
    $routes->post('rooms/update', 'RoomsController::update_room');
});

$routes->get('manager/schedule', 'ScheduleController::index');



$routes->get('administrator', 'roles_controllers\AdministratorController::index');
$routes->group('administrator', ['namespace' => 'App\Controllers\roles_controllers\administrator'], function ($routes) {
    $routes->get('rooms/search', 'RoomsSearchController::index');
    $routes->post('rooms/search/search_room', 'RoomsSearchController::search_room');
    $routes->post('rooms/search/update_room_status', 'RoomsSearchController::update_room_status');

    $routes->get('rooms/register', 'RoomsRegisterController::index');
    $routes->post('rooms/register/add_customer', 'RoomsRegisterController::add_customer');
    $routes->post('rooms/register/phone_search', 'RoomsRegisterController::phone_search');
    $routes->post('rooms/register/search_room', 'RoomsRegisterController::search_room');
    $routes->post('rooms/register/add_settlement', 'RoomsRegisterController::add_settlement');

    $routes->get('customers', 'ViewCustomersController::index');
    $routes->post('customers/search_customer', 'ViewCustomersController::search_customer');
    $routes->post('customers/add_customer', 'ViewCustomersController::add_customer');

    $routes->get('orders/create', 'OrderCreateController::index');
    $routes->post('orders/create/create_order', 'OrderCreateController::create_order');

    $routes->get('orders/view', 'OrderViewController::index');
    $routes->get('orders/view/(:any)', 'OrderViewController::load_upd_view/$1');
    $routes->post('orders/view/search', 'OrderViewController::search_order');
    $routes->post('orders/view/update_order', 'OrderViewController::update_order');
    $routes->post('orders/view/delete_task', 'OrderViewController::delete_task');
});

$routes->get('administrator/schedule', 'ScheduleController::index');



$routes->get('worker', 'roles_controllers\WorkerController::index');
$routes->group('worker', ['namespace' => 'App\Controllers\roles_controllers\worker'], function ($routes) {
    $routes->get('tasks', 'TasksController::index');
    $routes->post('tasks/load', 'TasksController::load');
    $routes->post('tasks/update', 'TasksController::update_task');
});

$routes->get('worker/schedule', 'ScheduleController::index');





$routes->get('errors/404', 'ErrorController::index');
