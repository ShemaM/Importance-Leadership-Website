<?php
require_once 'auth_check.php'; // This should contain your session/auth logic
require_once 'db_connect.php'; // This should contain your PDO connection

$pageTitle = "Programs Management";
$activePage = "programs";

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed");
    }

    // Handle different actions
    if (isset($_POST['add_program'])) {
        // Add new program
        try {
            $stmt = $pdo->prepare("INSERT INTO programs 
                                  (name, description, start_date, end_date, status) 
                                  VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['name'],
                $_POST['description'],
                $_POST['start_date'],
                $_POST['end_date'],
                $_POST['status']
            ]);
            $_SESSION['message'] = "Program added successfully!";
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error adding program: " . $e->getMessage();
        }
    } elseif (isset($_POST['update_program'])) {
        // Update existing program
        try {
            $stmt = $pdo->prepare("UPDATE programs SET 
                                  name = ?, 
                                  description = ?, 
                                  start_date = ?, 
                                  end_date = ?, 
                                  status = ? 
                                  WHERE id = ?");
            $stmt->execute([
                $_POST['name'],
                $_POST['description'],
                $_POST['start_date'],
                $_POST['end_date'],
                $_POST['status'],
                $_POST['program_id']
            ]);
            $_SESSION['message'] = "Program updated successfully!";
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error updating program: " . $e->getMessage();
        }
    } elseif (isset($_GET['delete'])) {
        // Delete program
        try {
            $stmt = $pdo->prepare("DELETE FROM programs WHERE id = ?");
            $stmt->execute([$_GET['delete']]);
            $_SESSION['message'] = "Program deleted successfully!";
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error deleting program: " . $e->getMessage();
        }
        header("Location: programs.php");
        exit;
    }

    // Redirect to prevent form resubmission
    header("Location: programs.php");
    exit;
}

// Get all programs from database
try {
    $programs = $pdo->query("SELECT * FROM programs ORDER BY start_date DESC")->fetchAll();
} catch (PDOException $e) {
    die("Error fetching programs: " . $e->getMessage());
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
        
        <div class="container-fluid">
            <!-- Display messages/errors -->
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-success"><?= $_SESSION['message'] ?></div>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Programs Management</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProgramModal">
                        <i class="fas fa-plus"></i> Add Program
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($programs as $program): ?>
                                <tr>
                                    <td><?= htmlspecialchars($program['name']) ?></td>
                                    <td><?= htmlspecialchars(substr($program['description'], 0, 50)) ?>...</td>
                                    <td><?= date('M j, Y', strtotime($program['start_date'])) ?></td>
                                    <td><?= date('M j, Y', strtotime($program['end_date'])) ?></td>
                                    <td>
                                        <span class="badge bg-<?= 
                                            $program['status'] === 'active' ? 'success' : 
                                            ($program['status'] === 'upcoming' ? 'warning' : 'danger') 
                                        ?>">
                                            <?= ucfirst($program['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary edit-program" 
                                                data-id="<?= $program['id'] ?>"
                                                data-name="<?= htmlspecialchars($program['name']) ?>"
                                                data-description="<?= htmlspecialchars($program['description']) ?>"
                                                data-start="<?= $program['start_date'] ?>"
                                                data-end="<?= $program['end_date'] ?>"
                                                data-status="<?= $program['status'] ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <a href="programs.php?delete=<?= $program['id'] ?>" 
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Are you sure you want to delete this program?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Program Modal -->
    <div class="modal fade" id="addProgramModal" tabindex="-1" aria-labelledby="addProgramModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProgramModalLabel">Add New Program</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Program Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="active">Active</option>
                                <option value="upcoming">Upcoming</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="add_program" class="btn btn-primary">Save Program</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Program Modal -->
    <div class="modal fade" id="editProgramModal" tabindex="-1" aria-labelledby="editProgramModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <input type="hidden" name="program_id" id="edit_program_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProgramModalLabel">Edit Program</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Program Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="edit_start_date" name="start_date" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="edit_end_date" name="end_date" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_status" class="form-label">Status</label>
                            <select class="form-select" id="edit_status" name="status" required>
                                <option value="active">Active</option>
                                <option value="upcoming">Upcoming</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="update_program" class="btn btn-primary">Update Program</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Handle edit button clicks
        document.querySelectorAll('.edit-program').forEach(button => {
            button.addEventListener('click', function() {
                const modal = new bootstrap.Modal(document.getElementById('editProgramModal'));
                
                document.getElementById('edit_program_id').value = this.dataset.id;
                document.getElementById('edit_name').value = this.dataset.name;
                document.getElementById('edit_description').value = this.dataset.description;
                document.getElementById('edit_start_date').value = this.dataset.start;
                document.getElementById('edit_end_date').value = this.dataset.end;
                document.getElementById('edit_status').value = this.dataset.status;
                
                modal.show();
            });
        });

        // Set default dates for new program
        document.getElementById('addProgramModal').addEventListener('shown.bs.modal', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('start_date').value = today;
            document.getElementById('end_date').value = today;
        });
    </script>
</body>
</html>