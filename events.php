<?php
require_once 'auth_check.php';
require_once 'db_connect.php';

$pageTitle = "Events Management";
$activePage = "events";

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed");
    }

    if (isset($_POST['add_event'])) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM events ORDER BY event_date DESC");
            $stmt->execute([
                $_POST['title'],
                $_POST['description'],
                $_POST['location'],
                $_POST['start_datetime'],
                $_POST['end_datetime'],
                $_POST['status']
            ]);
            $_SESSION['message'] = "Event added successfully!";
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error adding event: " . $e->getMessage();
        }
    }
    header("Location: events.php");
    exit;
}

// Get all events
try {
    $events = $pdo->query("SELECT * FROM events ORDER BY start_datetime DESC")->fetchAll();
} catch (PDOException $e) {
    die("Error fetching events: " . $e->getMessage());
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
            <?php include 'messages.php'; ?>

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Events Management</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEventModal">
                        <i class="fas fa-plus"></i> Add Event
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Location</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($events as $event): ?>
                                <tr>
                                    <td><?= htmlspecialchars($event['title']) ?></td>
                                    <td><?= htmlspecialchars($event['location']) ?></td>
                                    <td><?= date('M j, Y g:i A', strtotime($event['start_datetime'])) ?></td>
                                    <td><?= date('M j, Y g:i A', strtotime($event['end_datetime'])) ?></td>
                                    <td>
                                        <span class="badge bg-<?= 
                                            $event['status'] === 'upcoming' ? 'primary' : 
                                            ($event['status'] === 'ongoing' ? 'success' : 'secondary')
                                        ?>">
                                            <?= ucfirst($event['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="event_view.php?id=<?= $event['id'] ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="event_edit.php?id=<?= $event['id'] ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
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

    <!-- Add Event Modal -->
    <div class="modal fade" id="addEventModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Event</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Event Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Start Date & Time</label>
                                <input type="datetime-local" name="start_datetime" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">End Date & Time</label>
                                <input type="datetime-local" name="end_datetime" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="upcoming">Upcoming</option>
                                <option value="ongoing">Ongoing</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="add_event" class="btn btn-primary">Add Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Set default datetime values
        document.addEventListener('DOMContentLoaded', function() {
            const now = new Date();
            const start = new Date(now.getTime() + 60 * 60 * 1000); // 1 hour from now
            const end = new Date(start.getTime() + 2 * 60 * 60 * 1000); // 3 hours from now
            
            document.querySelector('input[name="start_datetime"]').value = formatDateTime(start);
            document.querySelector('input[name="end_datetime"]').value = formatDateTime(end);
            
            function formatDateTime(date) {
                return date.toISOString().slice(0, 16);
            }
        });
    </script>
</body>
</html>