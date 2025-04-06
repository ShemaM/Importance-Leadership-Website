<?php
require_once 'auth_check.php';
require_once 'db_connect.php';

$pageTitle = "View Event";
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
                    <h5 class="mb-0">Event Details</h5>
                    <div>
                        <a href="event_edit.php?id=<?= $event['id'] ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <?php if ($event['status'] === 'upcoming'): ?>
                            <button class="btn btn-danger btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#cancelEventModal">
                                <i class="fas fa-times"></i> Cancel Event
                            </button>
                        <?php endif; ?>
                        <a href="events.php" class="btn btn-secondary btn-sm ms-2">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Cancellation Notice (shown only if event is cancelled) -->
                    <?php if ($event['status'] === 'cancelled'): ?>
                    <div class="alert alert-danger">
                        <h5><i class="fas fa-ban"></i> This event has been cancelled</h5>
                        <?php if (!empty($event['cancellation_reason'])): ?>
                            <p><strong>Reason:</strong> <?= htmlspecialchars($event['cancellation_reason']) ?></p>
                        <?php endif; ?>
                        <?php if (!empty($event['cancelled_at'])): ?>
                            <p><strong>Cancelled on:</strong> <?= date('M j, Y g:i A', strtotime($event['cancelled_at'])) ?></p>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-6">
                            <h4><?= htmlspecialchars($event['title']) ?></h4>
                            <p class="text-muted">
                                <i class="fas fa-calendar-alt"></i> 
                                <?= date('F j, Y', strtotime($event['event_date'])) ?>
                                <i class="fas fa-clock ms-2"></i> 
                                <?= date('h:i A', strtotime($event['event_time'])) ?>
                            </p>
                            <p><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></p>
                            <p><strong>Status:</strong> 
                                <span class="badge bg-<?= 
                                    $event['status'] === 'upcoming' ? 'primary' : 
                                    ($event['status'] === 'past' ? 'success' : 'danger')
                                ?>">
                                    <?= ucfirst($event['status']) ?>
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h5>Description</h5>
                            <p><?= nl2br(htmlspecialchars($event['description'])) ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Start Time</h5>
                            <p><?= date('F j, Y, h:i A', strtotime($event['start_datetime'])) ?></p>
                        </div>
                        <div class="col-md-6">
                            <h5>End Time</h5>
                            <p><?= $event['end_datetime'] ? date('F j, Y, h:i A', strtotime($event['end_datetime'])) : 'Not specified' ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Event Modal (shown only for upcoming events) -->
    <?php if ($event['status'] === 'upcoming'): ?>
    <div class="modal fade" id="cancelEventModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Confirm Event Cancellation</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="cancel_event.php">
                    <div class="modal-body">
                        <p>You're about to cancel: <strong><?= htmlspecialchars($event['title']) ?></strong></p>
                        
                        <div class="mb-3">
                            <label for="cancellationReason" class="form-label">Reason for cancellation (required)</label>
                            <textarea class="form-control" id="cancellationReason" name="cancellation_reason" rows="3" required></textarea>
                        </div>
                        
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> This action cannot be undone!
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keep Event</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times-circle"></i> Confirm Cancellation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>