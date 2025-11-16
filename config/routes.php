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
$router->get('/post/{id}', 'BlogController@show');
$router->get('/category/{id}', 'BlogController@category');

// Authentication routes
$router->get('/login', 'AuthController@showLoginForm');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');

// Admin routes (authentication required - we'll add middleware later)
$router->get('/admin/dashboard', 'Admin\DashboardController@index');
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
$router->post('/admin/admins/{id}/delete', 'Admin\AdminController@delete');

$router->get('/admin/profile', 'Admin\ProfileController@index');
$router->post('/admin/profile', 'Admin\ProfileController@update');
