<?php
// router.php - Simple router for PHP built-in server
// This handles routing when using php -S localhost:8000 router.php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove leading slash
$uri = ltrim($uri, '/');

// Handle root
if (empty($uri) || $uri === 'index.php') {
    include 'index.php';
    return;
}

// Handle static files (let the built-in server serve them)
$path = __DIR__ . '/' . $uri;
if (is_file($path)) {
    return false; // Let the built-in server handle static files
}

// Handle specific pages if they exist
$possible_pages = [
    'about' => 'pages/about.php',
    'who-we-are' => 'pages/who-we-are.php',
    'team' => 'pages/team.php',
    'usa' => 'pages/usa.php',
    'canada' => 'pages/canada.php',
    'kenya' => 'pages/kenya.php',
    'contact' => 'pages/contact.php',
    'what-we-do' => 'pages/what-we-do.php',
    'impact' => 'pages/impact.php',
    'blog' => 'pages/blog.php',
    'donate' => 'pages/donate.php',
    'join-us' => 'pages/join-us.php',
];

if (isset($possible_pages[$uri]) && file_exists($possible_pages[$uri])) {
    include $possible_pages[$uri];
    return;
}

// Check if it's a page in the pages directory
if (file_exists("pages/{$uri}.php")) {
    include "pages/{$uri}.php";
    return;
}

// If nothing matches, show 404
http_response_code(404);
include '404.php';
?>