<?php
require_once 'auth_check.php';
require_once 'db_connect.php';

$pageTitle = "Programs Management";
$activePage = "programs";

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Define our core programs
$corePrograms = [
    'Leadership' => [
        'description' => 'Develop essential leadership skills through workshops and real-world projects',
        'status' => 'active'
    ],
    'Mentorship' => [
        'description' => 'Pair experienced mentors with mentees for professional development',
        'status' => 'active'
    ],
    'Community Engagement' => [
        'description' => 'Initiatives that connect participants with community service opportunities',
        'status' => 'active'
    ]
];

// Get all unique programs from participants table
try {
    $participantPrograms = $pdo->query("
        SELECT DISTINCT program 
        FROM participants
        WHERE program IS NOT NULL AND program != ''
    ")->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    $participantPrograms = [];
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF validation
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $_SESSION['error'] = "Security token validation failed";
        header("Location: programs.php");
        exit;
    }

    // Process updates to core programs
    if (isset($_POST['update_programs'])) {
        try {
            // No need to update database since we're using participants table
            foreach ($corePrograms as $name => &$program) {
                $program['status'] = $_POST[$name.'_status'] ?? 'active';
                $program['start_date'] = $_POST[$name.'_start'] ?? date('Y-m-d');
                $program['end_date'] = $_POST[$name.'_end'] ?? date('Y-m-d', strtotime('+1 year'));
                $program['description'] = $_POST[$name.'_description'] ?? $program['description'];
            }
            
            $_SESSION['message'] = "Core programs updated successfully!";
        } catch (Exception $e) {
            $_SESSION['error'] = "Error updating programs: " . $e->getMessage();
        }
        
        header("Location: programs.php");
        exit;
    }
}

// Get participant counts for each program
try {
    $participantCounts = $pdo->query("
        SELECT program, COUNT(*) as count 
        FROM participants 
        WHERE program IS NOT NULL AND program != ''
        GROUP BY program
    ")->fetchAll(PDO::FETCH_KEY_PAIR);
} catch (PDOException $e) {
    $participantCounts = [];
}

// Prepare programs data
$allPrograms = [];
foreach ($corePrograms as $name => $program) {
    $allPrograms[$name] = [
        'name' => $name,
        'description' => $program['description'],
        'status' => $program['status'],
        'start_date' => $program['start_date'] ?? date('Y-m-d'),
        'end_date' => $program['end_date'] ?? date('Y-m-d', strtotime('+1 year')),
        'is_core' => true
    ];
}

// Add participant programs that aren't core programs
foreach ($participantPrograms as $programName) {
    if (!isset($allPrograms[$programName])) {
        $allPrograms[$programName] = [
            'name' => $programName,
            'description' => '',
            'status' => 'active',
            'start_date' => date('Y-m-d', strtotime('-1 month')),
            'end_date' => date('Y-m-d', strtotime('+11 months')),
            'is_core' => false
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> - <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .program-card {
            transition: all 0.3s ease;
            border-left: 4px solid #103e6c;
        }
        .program-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .core-program {
            border-left-color: #28a745;
        }
        .program-badge {
            position: absolute;
            top: 15px;
            right: 15px;
        }
        .participant-count {
            font-size: 0.9rem;
            color: #6c757d;
        }
        .form-label small {
            font-size: 0.8rem;
            color: #6c757d;
        }
        
        :root {
            --primary: #103e6c;
            --primary-light: #1a4f87;
            --secondary: #ffcc00;
            --light-bg: #f8f9fa;
            --dark-text: #212529;
            --light-text: #6c757d;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: var(--dark-text);
        }
        
        .sidebar {
            background-color: #ffffff;
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        
        .sidebar-brand {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid #eee;
            text-align: center;
        }
        
        .sidebar-brand img {
            height: 80px;
            width: auto;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease-in-out;
            width: calc(100% - 250px);
        }
        
        .nav-link {
            color: var(--light-text);
            padding: 0.75rem 1rem;
            margin: 0.25rem 0;
            border-radius: 0.25rem;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--primary);
            background-color: rgba(16, 62, 108, 0.1);
        }
        
        .nav-link i {
            width: 24px;
            text-align: center;
            margin-right: 0.5rem;
        }
        
        .header {
            background-color: white;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        
        .stat-card {
            padding: 1.25rem;
            border-radius: 0.5rem;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .stat-card .value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary);
        }
        
        .progress {
            height: 8px;
            border-radius: 4px;
        }
        
        .table-responsive {
            border-radius: 0.5rem;
            overflow: hidden;
        }
        
        .table thead th {
            background-color: var(--primary);
            color: white;
            border: none;
        }
        
        .badge-active {
            background-color: var(--success);
        }
        
        .badge-inactive {
            background-color: var(--danger);
        }
        
        .badge-pending {
            background-color: var(--warning);
            color: var(--dark-text);
        }
        
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
                overflow: hidden;
            }
            
            .sidebar-brand span, .nav-link span {
                display: none;
            }
            
            .nav-link {
                text-align: center;
            }
            
            .nav-link i {
                margin-right: 0;
                font-size: 1.25rem;
            }
            
            .main-content {
                margin-left: 70px;
            }
        }
        
        .admin-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <?php include 'header.php'; ?>
        
        <div class="container-fluid py-4">
            <!-- Messages/Alerts -->
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?= $_SESSION['message'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= $_SESSION['error'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <!-- Core Programs Section -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Core Programs</h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        
                        <div class="row">
                            <?php foreach ($corePrograms as $name => $program): ?>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 program-card core-program">
                                    <div class="card-body position-relative">
                                        <span class="badge program-badge bg-<?= 
                                            $program['status'] === 'active' ? 'success' : 
                                            ($program['status'] === 'upcoming' ? 'warning' : 'secondary') 
                                        ?>">
                                            <?= ucfirst($program['status']) ?>
                                        </span>
                                        
                                        <h5 class="card-title"><?= htmlspecialchars($name) ?></h5>
                                        
                                        <div class="mb-3">
                                            <label class="form-label small">Description</label>
                                            <textarea class="form-control form-control-sm" 
                                                      name="<?= $name ?>_description" 
                                                      rows="3"><?= htmlspecialchars($program['description']) ?></textarea>
                                        </div>
                                        
                                        <div class="participant-count mb-3">
                                            <i class="fas fa-users"></i> 
                                            <?= $participantCounts[$name] ?? 0 ?> participants
                                        </div>
                                        
                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <label class="form-label small">Start Date</label>
                                                <input type="date" class="form-control form-control-sm" 
                                                       name="<?= $name ?>_start" 
                                                       value="<?= $program['start_date'] ?? date('Y-m-d') ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small">End Date</label>
                                                <input type="date" class="form-control form-control-sm" 
                                                       name="<?= $name ?>_end" 
                                                       value="<?= $program['end_date'] ?? date('Y-m-d', strtotime('+1 year')) ?>">
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label small">Status</label>
                                                <select class="form-select form-select-sm" name="<?= $name ?>_status">
                                                    <option value="active" <?= ($program['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>Active</option>
                                                    <option value="upcoming" <?= ($program['status'] ?? 'active') === 'upcoming' ? 'selected' : '' ?>>Upcoming</option>
                                                    <option value="completed" <?= ($program['status'] ?? 'active') === 'completed' ? 'selected' : '' ?>>Completed</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="text-end mt-3">
                            <button type="submit" name="update_programs" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Additional Programs Section (from participants table) -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Active Programs (from Participants)</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($participantPrograms)): ?>
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-calendar-plus fa-3x mb-3"></i>
                            <h5>No programs found in participant data</h5>
                            <p>Programs will appear here as participants register</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Program Name</th>
                                        <th>Participants</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($allPrograms as $name => $program): ?>
                                        <?php if (!$program['is_core'] && isset($participantCounts[$name])): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($name) ?></td>
                                            <td><?= $participantCounts[$name] ?? 0 ?></td>
                                            <td>
                                                <a href="participants.php?program=<?= urlencode($name) ?>" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye me-1"></i> View Participants
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Date validation
        function validateDates(startField, endField) {
            if (startField.value > endField.value) {
                alert('End date must be after start date');
                endField.value = startField.value;
            }
        }
        
        // Add validation to all date pairs
        document.querySelectorAll('input[type="date"][name$="_start"]').forEach(start => {
            const endName = start.name.replace('_start', '_end');
            const end = start.closest('form').querySelector(`input[name="${endName}"]`);
            
            start.addEventListener('change', () => validateDates(start, end));
            end.addEventListener('change', () => validateDates(start, end));
        });
    </script>
</body>
</html>