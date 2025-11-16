<?php

/**
 * Routes Configuration
 * 
 * This file defines all application routes.
 * Each route maps a URL pattern to a Controller and method.
 * 
 * WHY?
 * - Clean URLs: /login instead of Login.php
 * - Flexibility: Easy to change URLs without touching controllers
 * - RESTful: Support for different HTTP methods (GET, POST, etc.)
 */

// Public routes (no authentication required)
$router->get('/', 'BlogController@index');
$router->get('/blog', 'BlogController@index');
$router->post('/', 'BlogController@index'); // Newsletter subscription
$router->get('/post/{id}', 'BlogController@show');
$router->post('/post/{id}', 'BlogController@show'); // Comment submission
$router->get('/category/{id}', 'BlogController@category');
$router->get('/about', 'BlogController@about');
$router->get('/profile', 'BlogController@profile');

// Authentication routes
$router->get('/login', 'AuthController@showLoginForm');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');

// Admin routes (authentication required - we'll add middleware later)
$router->get('/admin/dashboard', 'Admin\DashboardController@index');
$router->get('/admin/search', 'Admin\DashboardController@search');
$router->get('/admin/posts', 'Admin\PostController@index');
$router->get('/admin/posts/create', 'Admin\PostController@create');
$router->post('/admin/posts', 'Admin\PostController@store');
$router->get('/admin/posts/{id}/edit', 'Admin\PostController@edit');
$router->post('/admin/posts/{id}', 'Admin\PostController@update');
$router->post('/admin/posts/{id}/delete', 'Admin\PostController@delete');

$router->get('/admin/categories', 'Admin\CategoryController@index');
$router->get('/admin/categories/create', 'Admin\CategoryController@create');
$router->post('/admin/categories', 'Admin\CategoryController@store');
$router->post('/admin/categories/{id}/delete', 'Admin\CategoryController@delete');

$router->get('/admin/comments', 'Admin\CommentController@index');
$router->post('/admin/comments/{id}/approve', 'Admin\CommentController@approve');
$router->post('/admin/comments/{id}/disapprove', 'Admin\CommentController@disapprove');
$router->post('/admin/comments/{id}/delete', 'Admin\CommentController@delete');

$router->get('/admin/admins', 'Admin\AdminController@index');
$router->get('/admin/admins/create', 'Admin\AdminController@create');
$router->post('/admin/admins', 'Admin\AdminController@store');
$router->get('/admin/admins/{id}/edit', 'Admin\AdminController@edit');
$router->post('/admin/admins/{id}', 'Admin\AdminController@update');
$router->post('/admin/admins/{id}/delete', 'Admin\AdminController@delete');

// Role management routes
$router->get('/admin/roles', 'Admin\RoleController@index');
$router->get('/admin/roles/assign', 'Admin\RoleController@assign');
$router->post('/admin/roles/update-user-role', 'Admin\RoleController@updateUserRole');
$router->post('/admin/roles/bulk-assign', 'Admin\RoleController@bulkAssign');
$router->get('/admin/roles/permissions/{role}', 'Admin\RoleController@showPermissions');
$router->get('/admin/roles/users/{role}', 'Admin\RoleController@usersByRole');

$router->get('/admin/profile', 'Admin\ProfileController@index');
$router->post('/admin/profile', 'Admin\ProfileController@update');
