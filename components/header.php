<?php
// components/header.php - Clean header component
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'Importance Leadership | Developing Ethical Leaders for Global Impact' ?></title>
    <meta name="description" content="<?= $meta_description ?? 'Empowering young leaders in Kenya through mentorship, education, and advocacy for ethical leadership and community impact.' ?>">
    <meta name="keywords" content="<?= $meta_keywords ?? 'youth leadership, leadership development, mentorship programs, community impact, African leadership, social change' ?>">
    <meta name="author" content="Importance Leadership">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= $canonical_url ?? 'https://www.importanceleadership.com' ?>" />
    
    <!-- Open Graph / Social Media Meta Tags -->
    <meta property="og:title" content="<?= $page_title ?? 'Importance Leadership | Developing Ethical Leaders for Global Impact' ?>">
    <meta property="og:description" content="<?= $meta_description ?? 'Empowering young leaders through mentorship, education, and advocacy programs.' ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= $canonical_url ?? 'https://www.importanceleadership.com' ?>">
    <meta property="og:image" content="https://www.importanceleadership.com/assets/images/icons/logo.png">
    <meta property="og:image:alt" content="Importance Leadership Logo">
    <meta property="og:site_name" content="Importance Leadership">
    
    <!-- Favicon -->
    <link rel="icon" href="/assets/images/icons/logo.jpg" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon-16x16.png">
    <link rel="manifest" href="/assets/site.webmanifest">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS - ONLY CSS FRAMEWORK ALLOWED -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9f2',
                            100: '#dcf2e2', 
                            500: '#2C5530', // Main brand color
                            600: '#234427',
                            700: '#1a331d',
                            900: '#0d1a0f'
                        },
                        secondary: {
                            500: '#4A7C59',
                            600: '#3d6647'
                        },
                        accent: {
                            500: '#F4A261',
                            600: '#f19937'
                        }
                    },
                    fontFamily: {
                        'primary': ['Poppins', 'system-ui', 'sans-serif'],
                        'secondary': ['Playfair Display', 'serif']
                    }
                }
            }
        }
    </script>
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <?= $additional_head ?? '' ?>
</head>
<body class="<?= $body_class ?? '' ?> font-primary text-gray-800 leading-relaxed scroll-smooth bg-gray-50">