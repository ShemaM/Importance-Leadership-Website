<?php
require_once 'auth_check.php';
require_once 'db_connect.php';

$pageTitle = "Edit Event";
$activePage = "events";

// Check if event ID is provided
if (!isset($_GET['id'])) {
    $_SESSION['error'] = "No event ID provided!";
    header("Location: events.php");
    exit;
}

$eventId = (int)$_GET['id'];

// Fetch event data
try {
    $stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
    $stmt->execute([$eventId]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$event) {
        $_SESSION['error'] = "Event not found!";
        header("Location: events.php");
        exit;
    }
} catch (PDOException $e) {
    $_SESSION['error'] = "Error fetching event: " . $e->getMessage();
    header("Location: events.php");
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error'] = "CSRF token validation failed";
        header("Location: event_edit.php?id=$eventId");
        exit;
    }

    try {
        // Prepare the update query
        $stmt = $pdo->prepare("
            UPDATE events 
            SET 
                title = ?, 
                description = ?, 
                location = ?, 
                event_date = ?, 
                event_time = ?, 
                start_datetime = ?, 
                end_datetime = ?, 
                status = ?
            WHERE id = ?
        ");

        // Parse datetime into date + time
        $startDateTime = new DateTime($_POST['start_datetime']);
        $eventDate = $startDateTime->format('Y-m-d');
        $eventTime = $startDateTime->format('H:i:s');

        // Execute the update
        $stmt->execute([
            $_POST['title'],
            $_POST['description'],
            $_POST['location'],
            $eventDate,
            $eventTime,
            $_POST['start_datetime'],
            $_POST['end_datetime'],
            $_POST['status'],
            $eventId
        ]);

        $_SESSION['message'] = "Event updated successfully!";
        header("Location: events.php");
        exit;

    } catch (PDOException $e) {
        $_SESSION['error'] = "Error updating event: " . $e->getMessage();
        header("Location: event_edit.php?id=$eventId");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> - <?= SITE_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .event-card.cancelled-event {
    border-left: 4px solid #dc3545;
    opacity: 0.9;
}

.event-card.cancelled-event .card-header {
    background-color: #dc3545 !important;
    color: white;
}

.cancellation-info {
    border-left: 3px solid #dc3545;
}
</style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <?php include 'header.php'; ?>
        
        <div class="container-fluid">
            <?php include 'messages.php'; ?>

            <div class="form-section">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4>Edit Event</h4>
                    <a href="events.php" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Events
                    </a>
                </div>

                <form method="POST">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required-field">Event Title</label>
                                <input type="text" name="title" class="form-control" 
                                       value="<?= htmlspecialchars($event['title']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="5"><?= htmlspecialchars($event['description']) ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label required-field">Location</label>
                                <input type="text" name="location" class="form-control" 
                                       value="<?= htmlspecialchars($event['location']) ?>" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required-field">Start Date & Time</label>
                                <input type="datetime-local" name="start_datetime" class="form-control" 
                                       value="<?= date('Y-m-d\TH:i', strtotime($event['start_datetime'])) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">End Date & Time</label>
                                <input type="datetime-local" name="end_datetime" class="form-control" 
                                       value="<?= $event['end_datetime'] ? date('Y-m-d\TH:i', strtotime($event['end_datetime'])) : '' ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label required-field">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="upcoming" <?= $event['status'] === 'upcoming' ? 'selected' : '' ?>>Upcoming</option>
                                    <option value="past" <?= $event['status'] === 'past' ? 'selected' : '' ?>>Past</option>
                                    <option value="cancelled" <?= $event['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                </select>
                            </div>

                            <?php if ($event['status'] === 'cancelled'): ?>
                            <div class="alert alert-warning">
                                <h6>Cancellation Details</h6>
                                <p><strong>Reason:</strong> <?= htmlspecialchars($event['cancellation_reason']) ?></p>
                                <p><strong>Cancelled On:</strong> <?= date('M j, Y g:i A', strtotime($event['cancelled_at'])) ?></p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save me-2"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Set default end datetime if empty
        document.addEventListener('DOMContentLoaded', function() {
            const startDatetime = document.querySelector('input[name="start_datetime"]');
            const endDatetime = document.querySelector('input[name="end_datetime"]');
            
            if (startDatetime && endDatetime && !endDatetime.value) {
                const startDate = new Date(startDatetime.value);
                startDate.setHours(startDate.getHours() + 2);
                endDatetime.value = startDate.toISOString().slice(0, 16);
            }
        });
    </script>
</body>
</html>