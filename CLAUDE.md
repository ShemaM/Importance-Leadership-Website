# CLAUDE.md - Working Guide for Claude AI

**Project:** Importance Leadership Organization Website  
**Architecture:** PHP Component-Based System following PHP Website Organization Doctrine  
**Last Updated:** August 2024  

## 📋 Quick Reference

### Project Overview
This is a professional website for the Importance Leadership Organization built using a component-based PHP architecture. The project follows the **PHP Website Organization Doctrine** which emphasizes:
- Everything goes through PHP (no standalone HTML)
- Component-based reusable architecture
- Clean URLs and professional structure
- Security, performance, and SEO optimization

### Core Architecture
```
project-root/
├── components/          # Reusable PHP components
│   ├── header.php       # HTML head + opening body
│   ├── nav.php          # Navigation menu
│   └── footer.php       # Footer + closing HTML
├── includes/            # Backend functionality
│   ├── config.php       # Database & environment config
│   └── functions.php    # 40+ utility functions
├── css/                 # Stylesheets
│   ├── main.css         # Base styles, variables, utilities
│   └── components/      # Component-specific styles
├── pages/               # Main content pages
├── forms/               # Form processing scripts
├── api/                 # AJAX endpoints
├── admin/               # Admin panel
└── reference-files/     # Original files for reference
```

## 🔧 Development Workflow

### Before Making Changes
1. **Read the Implementation Plan**: Check `IMPLEMENTATION_PLAN.md` for context
2. **Understand the Architecture**: Review `PHP-Website-Organization-Doctrine.md`
3. **Use Test Environment**: Always test in `test-environment/` folder first
4. **Follow Component Pattern**: Match existing component structure

### Working with Components

#### PHP Components (`components/`)
- **header.php**: Contains `<html>`, `<head>`, SEO meta tags, CSS imports, opening `<body>`
- **nav.php**: Navigation menu with dropdowns, mobile support, user authentication states
- **footer.php**: Footer content, newsletter signup, social links, closing `</body></html>`

**Component Usage Pattern:**
```php
<?php
// Set page variables
$page_title = "Page Title";
$meta_description = "Page description";
$body_class = "page-class";

// Include components
include 'components/header.php';
include 'components/nav.php';
?>

<main class="main-content">
    <!-- Your page content -->
</main>

<?php include 'components/footer.php'; ?>
```

#### CSS Components (`css/components/`)
- **header.css**: Flash messages, loading indicators, skip links
- **nav.css**: Navigation styles, dropdowns, mobile menu
- **footer.css**: Footer layout, newsletter form, social media
- **pages.css**: Page layouts, hero sections, cards, grids

**Adding New Component CSS:**
1. Create `css/components/newcomponent.css`
2. Add reference in `components/header.php`
3. Follow CSS custom properties pattern (`var(--primary-color)`)

### Configuration System

#### Environment Detection
```php
// Automatic environment detection in includes/config.php
define('ENVIRONMENT', $_SERVER['SERVER_NAME'] === 'localhost' ? 'development' : 'production');

// Use throughout code
if (isDevelopment()) {
    // Development-only code
}
```

#### Key Configuration Files
- **includes/config.php**: Database, email, payment settings, security
- **includes/functions.php**: 40+ utility functions
- **.htaccess**: Clean URLs, security, performance optimization

### Essential Functions Reference

#### Security Functions
```php
generateCSRFToken()              // Generate CSRF token
validateCSRFToken($token)        // Validate CSRF token
sanitizeInput($data)             // Clean user input
validateEmail($email)            // Email validation
rateLimitCheck($action, $limit)  // Rate limiting
```

#### Database Functions
```php
dbQuery($sql, $params)          // Execute SQL with parameters
dbFetchAll($sql, $params)       // Fetch multiple rows
dbFetchOne($sql, $params)       // Fetch single row
dbInsert($table, $data)         // Insert with associative array
```

#### Utility Functions
```php
getAssetUrl($asset)             // Get versioned asset URL
redirect($url)                  // Safe redirect
formatDate($date)               // Format dates
truncateText($text, $length)    // Truncate text with ellipsis
setFlashMessage($type, $msg)    // Set flash message
getCurrentUser()                // Get logged-in user
```

## 🧪 Testing Guidelines

### Testing Workflow
1. **Use Test Environment**: Work in `test-environment/` folder
2. **Run PHP Tests**: Use provided test scripts
3. **Verify Components**: Test each component individually
4. **Browser Testing**: Use `php -S localhost:8000` for web testing

### Available Test Scripts
```bash
# In test-environment/
php simple-test.php           # Basic functionality test
php test-index.php            # Full index page test
php test-css-components.php   # CSS structure test
```

### Testing New Features
1. Create test file: `test-feature-name.php`
2. Use test configuration: `includes/config-test.php`
3. Test error cases and edge cases
4. Verify responsive design
5. Check accessibility features

## 🎨 Styling Guidelines

### CSS Architecture
- **main.css**: CSS custom properties, base styles, utilities
- **components/**: Component-specific styles matching PHP components
- **Mobile-first**: All styles include responsive breakpoints
- **CSS Variables**: Use `var(--variable-name)` throughout

### CSS Custom Properties (Variables)
```css
/* Primary colors */
--primary-color: #2c3e50;
--secondary-color: #e74c3c;
--accent-color: #f39c12;

/* Spacing */
--spacing-md: 1rem;
--spacing-lg: 1.5rem;
--spacing-xl: 2rem;

/* Typography */
--font-family-primary: 'Inter', sans-serif;
--font-family-heading: 'Playfair Display', serif;
```

### Component Styling Pattern
```css
/* css/components/component-name.css */

/* Component base styles */
.component-name {
    /* Base styles */
}

/* Component variations */
.component-name.modifier {
    /* Modified styles */
}

/* Responsive styles */
@media (max-width: 768px) {
    .component-name {
        /* Mobile styles */
    }
}
```

## 🔒 Security Considerations

### Always Include
- CSRF token validation in forms
- Input sanitization using `sanitizeInput()`
- SQL injection prevention with prepared statements
- XSS protection with proper escaping
- Rate limiting for forms and APIs

### Security Headers (Production)
Already configured in `components/header.php`:
- Content Security Policy
- X-Frame-Options
- X-XSS-Protection
- X-Content-Type-Options

## 📱 Responsive Design

### Breakpoints
- **Mobile**: `max-width: 767px`
- **Tablet**: `768px - 1023px`
- **Desktop**: `1024px+`

### Mobile-First Approach
```css
/* Mobile styles (default) */
.component {
    /* Mobile styles */
}

/* Tablet and up */
@media (min-width: 768px) {
    .component {
        /* Tablet styles */
    }
}

/* Desktop and up */
@media (min-width: 1024px) {
    .component {
        /* Desktop styles */
    }
}
```

## 🚀 Deployment Guidelines

### Development to Production
1. **Test Thoroughly**: Use test environment
2. **Update Config**: Check `includes/config.php` for production settings
3. **Asset Optimization**: CSS/JS minification handled automatically
4. **Database Migration**: Update connection settings
5. **Security Check**: Enable production security headers

### Hosting Compatibility
- **Target**: Hostinger shared hosting
- **Requirements**: PHP 7.4+, MySQL, Apache with mod_rewrite
- **No Build Process**: Direct file upload compatibility

## 🐛 Debugging

### Development Debugging
```php
// Use utility function
debugLog("Debug message here");

// Check environment
if (isDevelopment()) {
    var_dump($variable);
    error_log("Debug info");
}
```

### Common Issues
1. **Database Connection**: Check `includes/config.php` credentials
2. **CSS Not Loading**: Verify file paths in `components/header.php`
3. **Component Errors**: Ensure all required variables are set
4. **Flash Messages**: Use `setFlashMessage()` and `getFlashMessages()`

## 📝 Adding New Pages

### Page Creation Pattern
```php
<?php
// pages/new-page.php

// Set page variables
$page_title = "New Page | Importance Leadership";
$meta_description = "Description of the new page";
$body_class = "new-page";

// Include components
include '../components/header.php';
include '../components/nav.php';
?>

<main class="main-content">
    <div class="container">
        <h1>Page Title</h1>
        <!-- Page content -->
    </div>
</main>

<?php include '../components/footer.php'; ?>
```

### Clean URL Setup
URLs automatically work as `/new-page` thanks to `.htaccess` configuration.

## 🔄 Form Handling

### Form Creation Pattern
```php
// forms/form-handler.php
require_once '../includes/config.php';
require_once '../includes/functions.php';

if ($_POST && validateCSRFToken($_POST['csrf_token'])) {
    $field = sanitizeInput($_POST['field']);
    
    if ($field) {
        // Process form
        setFlashMessage('success', 'Form submitted successfully!');
    } else {
        setFlashMessage('error', 'Please fill all required fields.');
    }
}

redirect('/page');
```

### Form HTML Pattern
```html
<form action="/forms/form-handler" method="POST">
    <input type="hidden" name="csrf_token" value="<?= generateCSRFToken() ?>">
    
    <div class="form-group">
        <label for="field" class="form-label">Field Name</label>
        <input type="text" id="field" name="field" class="form-input" required>
    </div>
    
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
```

## 📚 Best Practices

### Code Organization
1. **Follow Component Pattern**: Match PHP and CSS component names
2. **Use Utility Functions**: Don't reinvent the wheel
3. **Consistent Naming**: Use kebab-case for CSS, camelCase for PHP
4. **Comment Complex Logic**: Explain non-obvious code
5. **Validate All Input**: Never trust user input

### Performance
1. **Optimize Images**: Use appropriate formats and sizes
2. **Minimize HTTP Requests**: Component-based CSS helps
3. **Cache Static Assets**: `.htaccess` handles browser caching
4. **Lazy Load Images**: Use `loading="lazy"` attribute

### Accessibility
1. **Semantic HTML**: Use proper HTML5 elements
2. **Alt Text**: Describe all images
3. **Keyboard Navigation**: Ensure all interactive elements are keyboard accessible
4. **ARIA Labels**: Use when semantic HTML isn't enough
5. **Color Contrast**: Follow WCAG guidelines

## 🎯 Common Tasks

### Adding a New Component
1. Create `components/new-component.php`
2. Create `css/components/new-component.css`
3. Add CSS reference to `components/header.php`
4. Follow existing component patterns
5. Test thoroughly

### Modifying Existing Styles
1. Locate relevant CSS file in `css/components/`
2. Make changes using CSS custom properties
3. Test responsive design
4. Verify component still works in all contexts

### Database Operations
1. Use prepared statements via `dbQuery()`
2. Validate and sanitize all input
3. Handle errors gracefully
4. Use transactions for multiple operations

### Adding JavaScript Functionality
1. Add to `js/main.js` for global functionality
2. Create component-specific JS files if needed
3. Use modern ES6+ syntax
4. Include progressive enhancement

## 🆘 Getting Help

### Key Files to Reference
- `IMPLEMENTATION_PLAN.md` - Overall project strategy
- `PHP-Website-Organization-Doctrine.md` - Architecture guidelines
- `includes/functions.php` - Available utility functions
- `css/main.css` - Available CSS variables and utilities

### Testing Commands
```bash
# Basic tests
php simple-test.php

# Component tests  
php test-index.php

# CSS structure test
php test-css-components.php

# Start web server for browser testing
php -S localhost:8000
```

## 🎉 Project Status

**Current State**: ✅ Foundation Complete
- ✅ Component architecture implemented
- ✅ CSS organization restructured  
- ✅ Security and utility functions ready
- ✅ Testing framework in place
- ✅ Professional styling and responsive design

**Next Steps Available**:
- Add more pages following the established patterns
- Implement form processing
- Create admin panel functionality
- Add blog/content management features
- Implement user authentication system

---

**Remember**: This project follows professional web development standards with security, performance, and maintainability as priorities. Always test your changes and follow the established patterns for consistency.

**Happy Coding!** 🚀