<?php
// components/header.php

// Include configuration if not already included
if (!defined('ALLOW_ACCESS')) {
    define('ALLOW_ACCESS', true);
    require_once __DIR__ . '/../includes/config.php';
    require_once __DIR__ . '/../includes/functions.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Primary Meta Tags -->
    <title><?= htmlspecialchars($page_title ?? SITE_NAME) ?></title>
    <meta name="title" content="<?= htmlspecialchars($page_title ?? SITE_NAME) ?>">
    <meta name="description" content="<?= htmlspecialchars($meta_description ?? 'Importance Leadership Organization empowers young people through leadership development and community impact initiatives.') ?>">
    <meta name="keywords" content="<?= htmlspecialchars($meta_keywords ?? 'leadership, youth empowerment, Africa, mentorship, community development') ?>">
    <meta name="author" content="Importance Leadership Organization">
    <meta name="robots" content="index, follow">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?= htmlspecialchars(getCurrentUrl()) ?>">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= htmlspecialchars(getCurrentUrl()) ?>">
    <meta property="og:title" content="<?= htmlspecialchars($page_title ?? SITE_NAME) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($meta_description ?? 'Empowering young leaders across Africa through comprehensive leadership development programs') ?>">
    <meta property="og:image" content="<?= SITE_URL ?>/images/logo-og.jpg">
    <meta property="og:site_name" content="<?= SITE_NAME ?>">
    <meta property="og:locale" content="en_US">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?= htmlspecialchars(getCurrentUrl()) ?>">
    <meta property="twitter:title" content="<?= htmlspecialchars($page_title ?? SITE_NAME) ?>">
    <meta property="twitter:description" content="<?= htmlspecialchars($meta_description ?? 'Empowering young leaders across Africa through comprehensive leadership development programs') ?>">
    <meta property="twitter:image" content="<?= SITE_URL ?>/images/logo-og.jpg">
    
    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= getAssetUrl('images/apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= getAssetUrl('images/favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= getAssetUrl('images/favicon-16x16.png') ?>">
    <link rel="manifest" href="<?= getAssetUrl('site.webmanifest') ?>">
    <meta name="theme-color" content="#2c3e50">
    
    <!-- Preload critical resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?= getAssetUrl('css/main.css') ?>">
    <link rel="stylesheet" href="<?= getAssetUrl('css/components/header.css') ?>">
    <link rel="stylesheet" href="<?= getAssetUrl('css/components/nav.css') ?>">
    <link rel="stylesheet" href="<?= getAssetUrl('css/components/footer.css') ?>">
    <link rel="stylesheet" href="<?= getAssetUrl('css/components/pages.css') ?>">
    
    <!-- Additional head content -->
    <?= $additional_head ?? '' ?>
    
    <!-- Security Headers -->
    <?php
    if (!isDevelopment()) {
        // Content Security Policy
        header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://js.stripe.com https://www.google-analytics.com https://www.googletagmanager.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data: https:; connect-src 'self' https://api.stripe.com https://www.google-analytics.com; frame-src 'self' https://js.stripe.com https://www.youtube.com;");
        
        // Other security headers
        header("X-Frame-Options: SAMEORIGIN");
        header("X-XSS-Protection: 1; mode=block");
        header("X-Content-Type-Options: nosniff");
        header("Referrer-Policy: strict-origin-when-cross-origin");
        header("Permissions-Policy: geolocation=(), microphone=(), camera=()");
    }
    ?>
    
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "<?= SITE_NAME ?>",
        "url": "<?= SITE_URL ?>",
        "logo": "<?= SITE_URL ?>/images/logo.png",
        "description": "Empowering young leaders across Africa through comprehensive leadership development programs, mentorship, and community impact initiatives.",
        "foundingDate": "2018",
        "address": {
            "@type": "PostalAddress",
            "addressCountry": "Rwanda",
            "addressRegion": "Kigali"
        },
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+250-xxx-xxx-xxx",
            "contactType": "customer service",
            "email": "<?= ADMIN_EMAIL ?>"
        },
        "sameAs": [
            "https://www.facebook.com/importanceleadership",
            "https://www.instagram.com/importanceleadership",
            "https://www.linkedin.com/company/importance-leadership",
            "https://twitter.com/importanceleadership"
        ]
    }
    </script>
    
    <!-- Analytics (production only) -->
    <?php if (!isDevelopment()): ?>
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'GA_MEASUREMENT_ID');
    </script>
    <?php endif; ?>
</head>
<body class="<?= htmlspecialchars($body_class ?? '') ?>">
    
    <!-- Skip to main content for accessibility -->
    <a href="#main-content" class="skip-link">Skip to main content</a>
    
    <!-- Flash Messages -->
    <?php if (hasFlashMessages()): ?>
    <div class="flash-messages" role="alert" aria-live="polite">
        <?php foreach (getFlashMessages() as $message): ?>
        <div class="flash-message flash-<?= htmlspecialchars($message['type']) ?>">
            <span class="flash-text"><?= htmlspecialchars($message['message']) ?></span>
            <button type="button" class="flash-close" onclick="this.parentElement.remove()" aria-label="Close message">×</button>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    
    <!-- Loading indicator -->
    <div id="loading-indicator" class="loading-indicator" style="display: none;" aria-hidden="true">
        <div class="loading-spinner"></div>
        <span class="loading-text">Loading...</span>
    </div>