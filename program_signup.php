<?php
// Start secure session
session_start([
    'cookie_secure' => true,
    'cookie_httponly' => true,
    'cookie_samesite' => 'Strict',
    'use_strict_mode' => true
]);

// Initialize variables
$success = '';
$errors = [];
$formData = [];
$databaseError = '';
$pdo = null;

// Configure valid options
$validPrograms = [
    'Leadership Development' => 'Build essential leadership skills',
    'Mentorship Program' => 'Get guidance from experienced mentors',
    'Community Impact' => 'Drive change in your community'
];

$validGenders = [
    'Male' => 'Male',
    'Female' => 'Female',
    'Other' => 'Other',
    'Prefer not to say' => 'Prefer not to say'
];

// Database connection
$dbFile = __DIR__ . '/db.php';
if (file_exists($dbFile)) {
    require_once $dbFile;
    
    if (!isset($pdo) || !($pdo instanceof PDO)) {
        $databaseError = "System configuration error. Please contact support. Ensure the database connection is properly configured.";
    } else {
        try {
            $pdo->query('SELECT 1');
        } catch (PDOException $e) {
            $databaseError = "Database connection error. Please try again later.";
            $pdo = null;
        }
    }
} else {
    $databaseError = "System configuration error. Please contact support.";
}

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrfToken = $_SESSION['csrf_token'];

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($databaseError) && $pdo instanceof PDO) {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $csrfToken) {
        $errors[] = 'Invalid form submission';
    } else {
        // Sanitize inputs
        $formData = [
            'name' => trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'phone' => preg_replace('/[^0-9]/', '', $_POST['phone'] ?? ''),
            'program' => trim($_POST['program'] ?? ''),
            'age' => $_POST['age'] ?? null,
            'gender' => trim($_POST['gender'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
            'education' => trim($_POST['education'] ?? ''),
            'experience' => trim($_POST['experience'] ?? ''),
            'goals' => trim($_POST['goals'] ?? '')
        ];

        // Validate required fields
        if (empty($formData['name'])) {
            $errors[] = 'Full name is required';
        } elseif (strlen($formData['name']) > 100) {
            $errors[] = 'Name must be less than 100 characters';
        }

        if (empty($formData['email']) || !filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Valid email address is required';
        }

        if (!empty($formData['phone']) && strlen($formData['phone']) < 10) {
            $errors[] = 'Phone number must be at least 10 digits';
        }

        if (empty($formData['program']) || !array_key_exists($formData['program'], $validPrograms)) {
            $errors[] = 'Please select a valid program';
        }

        if (!empty($formData['age'])) {
            $age = filter_var($formData['age'], FILTER_VALIDATE_INT, [
                'options' => ['min_range' => 16, 'max_range' => 120]
            ]);
            if ($age === false) {
                $errors[] = 'Age must be between 16 and 120';
            }
            $formData['age'] = $age;
        }

        if (!empty($formData['gender']) && !array_key_exists($formData['gender'], $validGenders)) {
            $errors[] = 'Invalid gender selection';
        }

        // Process if no errors
        if (empty($errors)) {
            try {
                // Check existing registration
                $stmt = $pdo->prepare("SELECT id FROM participants WHERE email = ? AND program = ?");
                $stmt->execute([$formData['email'], $formData['program']]);
                
                if ($stmt->fetch()) {
                    $errors[] = 'This email is already registered for the selected program';
                } else {
                    // Insert new registration
                    $stmt = $pdo->prepare("INSERT INTO participants 
                        (name, email, phone, program, age, gender, address, education, experience, goals, registration_date) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
                    
                    $stmt->execute([
                        $formData['name'],
                        $formData['email'],
                        $formData['phone'],
                        $formData['program'],
                        $formData['age'],
                        $formData['gender'],
                        $formData['address'],
                        $formData['education'],
                        $formData['experience'],
                        $formData['goals']
                    ]);
                    
                    $_SESSION['form_success'] = 'Thank you for registering! We will contact you soon.';
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit;
                }
            } catch (PDOException $e) {
                error_log("Database error: " . $e->getMessage());
                $errors[] = "A system error occurred. Please try again later.";
            }
        }
    }
}

// Retrieve success message
if (!empty($_SESSION['form_success'])) {
    $success = $_SESSION['form_success'];
    unset($_SESSION['form_success']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' https://cdn.jsdelivr.net; style-src 'self' https://cdn.jsdelivr.net; img-src 'self' data:">
    <title>Program Registration - Leadership Development</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
     <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="program_signup.css">
  
</head>
<body>
    <div class="registration-container">
        <div class="registration-header">
            <h1>Leadership Program Registration</h1>
            <p class="mb-0">Join our transformative leadership development experience</p>
        </div>

        <div class="registration-body">
            <?php if ($databaseError): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($databaseError, ENT_QUOTES, 'UTF-8') ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <h5>Please fix these errors:</h5>
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" novalidate>
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">

                <div class="row g-3 mb-4">
                    <!-- Personal Information -->
                    <div class="col-md-6">
                        <label class="form-label required">Full Name</label>
                        <input type="text" class="form-control" name="name" 
                               value="<?= htmlspecialchars($formData['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label required">Email</label>
                        <input type="email" class="form-control" name="email" 
                               value="<?= htmlspecialchars($formData['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" name="phone" 
                               value="<?= htmlspecialchars($formData['phone'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Age</label>
                        <input type="number" class="form-control" name="age" min="16" max="120"
                               value="<?= htmlspecialchars($formData['age'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Gender</label>
                        <select class="form-select" name="gender">
                            <option value="">Select...</option>
                            <?php foreach ($validGenders as $value => $label): ?>
                                <option value="<?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?>" 
                                    <?= ($formData['gender'] ?? '') === $value ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" 
                               value="<?= htmlspecialchars($formData['address'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                </div>

                
                 <!-- ADD PROGRAM CARDS HERE -->
                 <div class="col-12">
                        <label class="form-label required">Program Selection</label>
                        <select class="form-select" name="program" required>
                            <option value="">Choose a program...</option>
                            <?php foreach ($validPrograms as $program => $description): ?>
                                <option value="<?= htmlspecialchars($program, ENT_QUOTES, 'UTF-8') ?>"
                                    <?= ($formData['program'] ?? '') === $program ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($program, ENT_QUOTES, 'UTF-8') ?> - 
                                    <?= htmlspecialchars($description, ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
    </div>
</div>

                <!-- Additional Information -->
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label class="form-label">Educational Background</label>
                        <textarea class="form-control" name="education" rows="2"><?= htmlspecialchars($formData['education'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Professional Experience</label>
                        <textarea class="form-control" name="experience" rows="2"><?= htmlspecialchars($formData['experience'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label required">Leadership Goals</label>
                        <textarea class="form-control" name="goals" rows="3" required><?= htmlspecialchars($formData['goals'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                        <small class="text-muted">Describe your leadership goals and expectations from this program</small>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100" <?= $databaseError ? 'disabled' : '' ?>>Submit Application</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<script>
          
    document.addEventListener('DOMContentLoaded', function() {
        // Program card selection functionality
        const programCards = document.querySelectorAll('.program-card');
        
        programCards.forEach(card => {
            card.addEventListener('click', function(e) {
                // Remove previous selection
                programCards.forEach(c => {
                    c.classList.remove('selected');
                    c.querySelector('input[type="radio"]').checked = false;
                });
                
                // Set new selection
                this.classList.add('selected');
                const radio = this.querySelector('input[type="radio"]');
                radio.checked = true;
                
                // Trigger form validation
                radio.dispatchEvent(new Event('change'));
            });

            // Initialize selection from PHP
            if (card.querySelector('input[type="radio"]').checked) {
                card.classList.add('selected');
            }
        });
    });

</script>
</body>
</html>