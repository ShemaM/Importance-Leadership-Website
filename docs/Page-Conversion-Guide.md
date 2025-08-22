# Page Conversion Guide - HTML to PHP Component Architecture

## Overview

This guide provides step-by-step instructions for converting monolithic HTML pages to our component-based PHP architecture with Tailwind CSS. Use this as a template for all page conversions.

---

## 📋 Pre-Conversion Checklist

### 1. **Branch Management**
```bash
# Always start with clean main branch
git checkout main
git pull origin main
git checkout -b page-name-conversion
```

### 2. **Reference Analysis**
- [ ] Read reference HTML file in `reference-files/`
- [ ] Identify all content sections
- [ ] Note any special styling or functionality
- [ ] List all images and assets used

### 3. **Content Inventory**
- [ ] Hero section content
- [ ] Main content sections 
- [ ] Call-to-action content
- [ ] Navigation elements
- [ ] Meta information (title, description)

---

## 🏗️ Page Structure Template

### File Location
Create new page at: `pages/page-name.php`

### Required PHP Structure
```php
<?php
// pages/page-name.php - Page description
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/security.php';

// Page configuration
$page_title = "Page Title | Importance Leadership";
$meta_description = "Page description from reference";
$meta_keywords = "relevant, keywords, from, reference";
$canonical_url = "https://www.importanceleadership.com/page-url";
$body_class = "page-name-class";

// Additional head content
$additional_head = '
<link rel="canonical" href="' . $canonical_url . '">
<meta property="og:title" content="' . $page_title . '">
<meta property="og:description" content="' . $meta_description . '">
<meta property="og:type" content="website">
<meta property="og:url" content="' . $canonical_url . '">
<meta property="og:image" content="' . $canonical_url . '/assets/images/icons/logo.jpg">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="' . $page_title . '">
<meta name="twitter:description" content="' . $meta_description . '">
<meta name="twitter:image" content="' . $canonical_url . '/assets/images/icons/logo.jpg">';

// Include header and navigation
include __DIR__ . '/../components/header.php';
include __DIR__ . '/../components/nav.php';
?>

<!-- Skip to content link for accessibility -->
<a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-primary-500 text-white px-4 py-2 rounded-lg z-50">
    Skip to main content
</a>

<!-- Main Content -->
<main id="main-content">
    <!-- Page sections go here -->
</main>

<?php include __DIR__ . '/../components/footer.php'; ?>
```

---

## 🎨 UI Conversion Rules

### 1. **Content Preservation (CRITICAL)**
- ✅ **NEVER change any text content**
- ✅ **Keep all original wording exactly**
- ✅ **Preserve all quotes and names**
- ✅ **Maintain paragraph structure**
- ✅ **Keep button text identical**

### 2. **UI Consistency (INDEX PAGE MATCHING)**
- ✅ **Match index page styling patterns**
- ✅ **Use consistent color scheme**
- ✅ **Apply same typography scale**
- ✅ **Maintain spacing patterns**
- ✅ **Follow same animation delays**

### 3. **Section Templates**

#### Hero Section Template
```php
<!-- Hero Section -->
<section class="relative h-screen min-h-[600px] flex items-center justify-center text-white overflow-hidden">
    <!-- Background -->
    <div class="absolute inset-0 z-0">
        <div class="w-full h-full bg-cover bg-center bg-no-repeat" 
             style="background-image: url('/assets/images/backgrounds/hero-bg.jpg')"></div>
    </div>
    
    <!-- Dark Overlay -->
    <div class="absolute inset-0 bg-gradient-to-br from-primary-500/80 to-primary-700/90 z-10"></div>
    
    <!-- Content -->
    <div class="container mx-auto px-4 relative z-20 py-8">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl md:text-6xl font-bold font-secondary leading-tight mb-6" data-aos="fade-up" data-aos-delay="100">
                <!-- EXACT content from reference -->
            </h1>
            
            <p class="text-xl md:text-2xl mb-8 opacity-95 max-w-4xl mx-auto leading-relaxed" data-aos="fade-up" data-aos-delay="200">
                <!-- EXACT content from reference -->
            </p>
            
            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center" data-aos="fade-up" data-aos-delay="300">
                <!-- EXACT button text from reference -->
            </div>
        </div>
    </div>
</section>
```

#### Standard Section Template
```php
<!-- Section Name -->
<section class="py-20 bg-white" id="section-id">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-bold font-secondary text-primary-500 mb-6">
                <!-- EXACT heading from reference -->
            </h2>
            <div class="w-20 h-1 bg-accent-500 mx-auto"></div>
        </div>
        
        <!-- Section content with responsive grid -->
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- EXACT content from reference -->
        </div>
    </div>
</section>
```

#### Dark Section Template
```php
<!-- Dark Section -->
<section class="py-20 bg-primary-500 text-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-bold font-secondary mb-6">
                <!-- EXACT heading from reference -->
            </h2>
            <div class="w-20 h-1 bg-accent-500 mx-auto"></div>
        </div>
        
        <!-- Content -->
    </div>
</section>
```

---

## 🎯 Tailwind CSS Standards

### Color Palette
- **Primary**: `primary-500`, `primary-600`, `primary-700`
- **Accent**: `accent-500`, `accent-600`
- **Text**: `text-primary-500`, `text-gray-600`, `text-white`
- **Backgrounds**: `bg-white`, `bg-gray-50`, `bg-primary-500`

### Typography Scale
```css
/* Headings */
.text-4xl md:text-6xl       /* Hero titles */
.text-4xl md:text-5xl       /* Section titles */
.text-2xl                   /* Subsection titles */
.text-xl                    /* Large text */

/* Body Text */
.text-xl md:text-2xl        /* Hero descriptions */
.text-xl                    /* Important paragraphs */
.text-gray-600              /* Regular paragraphs */
```

### Spacing System
```css
/* Section Padding */
.py-20                      /* Standard section padding */
.mb-16                      /* Title bottom margin */
.mb-6                       /* Heading bottom margin */
.gap-12                     /* Grid gap */

/* Container */
.container mx-auto px-4     /* Standard container */
.max-w-4xl mx-auto         /* Content width limit */
```

### Button Styles
```css
/* Primary Button */
.bg-accent-500 hover:bg-accent-600 text-white px-8 py-4 rounded-full font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105

/* Secondary Button */
.border-2 border-white text-white hover:bg-white hover:text-primary-500 px-8 py-4 rounded-full font-bold text-lg transition-all duration-300

/* Card Buttons */
.bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg
```

---

## 📱 Responsive Design Patterns

### Grid Systems
```css
/* Two Column */
.grid lg:grid-cols-2 gap-12 items-center

/* Three Column */
.grid md:grid-cols-2 lg:grid-cols-3 gap-8

/* Card Grid */
.grid md:grid-cols-2 lg:grid-cols-6 gap-8 items-center
```

### Responsive Typography
```css
.text-4xl md:text-6xl       /* Hero responsive */
.text-4xl md:text-5xl       /* Section responsive */
.text-xl md:text-2xl        /* Description responsive */
```

### Mobile Optimization
```css
/* Button Stacking */
.flex flex-col sm:flex-row gap-4 justify-center

/* Text Alignment */
.text-center sm:text-left

/* Visibility */
.hidden sm:flex             /* Hide on mobile */
.block sm:hidden            /* Show only on mobile */
```

---

## 🎬 Animation Patterns

### AOS (Animate On Scroll) Standards
```html
<!-- Section Headers -->
data-aos="fade-up"

<!-- Content with Delays -->
data-aos="fade-up" data-aos-delay="100"
data-aos="fade-up" data-aos-delay="200"
data-aos="fade-up" data-aos-delay="300"

<!-- Cards with Staggered Animation -->
data-aos="fade-up" data-aos-delay="100"
data-aos="fade-up" data-aos-delay="200"
data-aos="fade-up" data-aos-delay="300"
```

### Hover Effects
```css
/* Card Hover */
.hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2

/* Button Hover */
.transition-all duration-300 transform hover:scale-105

/* Link Hover */
.transition-all duration-300 transform hover:-translate-y-1
```

---

## 🖼️ Asset Management

### Image Path Standards
```php
<!-- Background Images -->
style="background-image: url('/assets/images/backgrounds/image-name.jpg')"

<!-- Content Images -->
src="/reference-files/image/image-name.ext"    /* Temporary during conversion */
src="/assets/images/category/image-name.ext"   /* Final organized structure */
```

### Asset Organization
```
assets/images/
├── backgrounds/        # Hero and section backgrounds
├── programs/          # Program-related images
├── partners/          # Partner logos
├── team/              # Team member photos
├── icons/             # Website icons and logos
└── content/           # General content images
```

---

## 🔧 Router Configuration

### Add Route to router.php
```php
// Handle specific pages if they exist
$possible_pages = [
    'about' => 'pages/about.php',
    'who-we-are' => 'pages/who-we-are.php',
    'page-name' => 'pages/page-name.php',    // Add new route
    // ... other routes
];
```

### URL Structure
- **Clean URLs**: `/page-name` (no .html extension)
- **SEO-friendly**: Use hyphens for multi-word pages
- **Consistent**: Match navigation link structure

---

## ✅ Conversion Checklist

### Pre-Development
- [ ] Branch created from main
- [ ] Reference HTML file analyzed
- [ ] Content sections identified
- [ ] Assets inventory completed

### During Development
- [ ] PHP file structure implemented
- [ ] All content preserved exactly
- [ ] Component includes added with proper paths
- [ ] Meta tags configured
- [ ] Tailwind classes applied consistently
- [ ] Responsive design implemented
- [ ] AOS animations added
- [ ] Router updated with new route
- [ ] **Images copied from reference-files to assets directories**
- [ ] **Image src paths updated to use assets structure**

### Post-Development Testing
- [ ] Page loads at correct URL
- [ ] All content displays correctly
- [ ] Navigation works properly
- [ ] Responsive design tested (mobile, tablet, desktop)
- [ ] Links work correctly
- [ ] Images display properly
- [ ] Animations function smoothly
- [ ] **Image paths updated from reference to assets directories**

### Code Quality
- [ ] No vanilla CSS classes used
- [ ] Consistent indentation and formatting
- [ ] Comments added where necessary
- [ ] File paths use __DIR__ for includes
- [ ] Proper error handling

### Final Steps
- [ ] Git commit with descriptive message
- [ ] Test page thoroughly
- [ ] Update navigation if needed
- [ ] Document any special requirements

---

## 🚨 Common Mistakes to Avoid

### Content Changes (FORBIDDEN)
- ❌ **Never rewrite or "improve" content**
- ❌ **Don't change button text or labels**
- ❌ **Don't alter quotes or testimonials**
- ❌ **Don't modify company/person names**

### Technical Mistakes
- ❌ **Don't use vanilla CSS classes**
- ❌ **Don't mix Bootstrap or other frameworks**
- ❌ **Don't use relative paths for includes**
- ❌ **Don't hardcode URLs or paths**

### Design Inconsistencies
- ❌ **Don't deviate from index page styling**
- ❌ **Don't use different color schemes**
- ❌ **Don't change typography patterns**
- ❌ **Don't skip responsive design**

---

## 📝 Example: Who We Are Conversion

### Reference Analysis
- **File**: `reference-files/who-we-are.html`
- **Sections**: Hero, Background History, Mission & Vision, CTA
- **Special Elements**: Founder card, mission cards, testimonials

### Content Preserved
- Hero title: "Meet the Heart of Importance Leadership"
- All founder information and quotes
- Complete background history paragraphs
- Mission and vision statements

### UI Improvements Applied
- Consistent hero background and overlay
- Index page color scheme
- Responsive grid layouts
- Professional card styling
- AOS animations with proper delays

### Result
- Clean URL: `/who-we-are`
- Component-based architecture
- 100% Tailwind CSS
- Mobile-responsive design
- Preserved content integrity

---

## 🔄 Next Steps After Conversion

1. **Test thoroughly** on all screen sizes
2. **Update navigation** if needed
3. **Add to router.php** for clean URLs
4. **Commit with descriptive message**
5. **Update CLAUDE.md** progress tracking
6. **Move to next page conversion**

---

**Remember**: The goal is content preservation with UI modernization. Every word matters, every design choice should match the established patterns from the index page.