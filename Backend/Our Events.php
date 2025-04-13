<?php
require_once 'db_connect.php';
require_once 'auth_check.php';

// Define isAdmin function if not already defined
if (!function_exists('isAdmin')) {
    function isAdmin() {
        // Example logic: Check if the user has an admin role
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }
}

$pageTitle = "Upcoming Events";
$activePage = "events";

// Get all events from database
try {
    $currentDateTime = date('Y-m-d H:i:s');
    
    // Get upcoming events (including cancelled)
    $stmt = $pdo->prepare("SELECT *
                          FROM events
                          WHERE status IN ('upcoming', 'cancelled')
                          AND start_datetime > ?
                          ORDER BY 
                              CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END,
                              start_datetime ASC");
    $stmt->execute([$currentDateTime]);
    $upcomingEvents = $stmt->fetchAll();
    
    // Get past events
    $stmt = $pdo->prepare("SELECT *
                          FROM events
                          WHERE status = 'past' 
                          OR (status = 'upcoming' AND start_datetime <= ?)
                          ORDER BY start_datetime DESC
                          LIMIT 10");
    $stmt->execute([$currentDateTime]);
    $pastEvents = $stmt->fetchAll();
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
    <style>
        .event-card {
            transition: transform 0.3s ease;
            margin-bottom: 20px;
            border: none;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }
        .event-card.cancelled {
            border-left: 4px solid #dc3545;
            opacity: 0.9;
        }
        .event-card.cancelled .card-header {
            background-color: #dc3545 !important;
            color: white;
        }
        .event-img {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
        .status-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            color:yellow;
            font-weight: bold;
        }
        .section-title {
            position: relative;
            margin-bottom: 30px;
            padding-bottom: 10px;
        }
        .section-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 60px;
            height: 3px;
            background: #103e6c;
        }
        .cancellation-details {
            border-left: 3px solid #dc3545;
            padding-left: 10px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div id="header-container"></div>
    <script src="loadHeader.js"></script>

    <div class="container py-5">
        <?php include 'messages.php'; ?>

        <!-- Upcoming Events Section -->
        <div class="mb-5">
            <h2 class="section-title">Upcoming Events</h2>
            
            <?php if (empty($upcomingEvents)): ?>
                <div class="alert alert-info">
                    No upcoming events scheduled. Check back later!
                </div>
            <?php else: ?>
                <div class="row" id="eventsContainer">
                    <?php foreach ($upcomingEvents as $event): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card event-card h-100 <?= $event['status'] === 'cancelled' ? 'cancelled' : '' ?>" 
                             data-id="<?= $event['id'] ?>">
                            <div class="card-header position-relative text-white 
                                <?= $event['status'] === 'cancelled' ? 'bg-danger' : 'bg-primary' ?>">
                                <h5><?= htmlspecialchars($event['title']) ?></h5>
                                <span class="badge <?= $event['status'] === 'cancelled' ? 'bg-warning' : 'bg-light' ?> status-badge">
                                    <?= ucfirst($event['status']) ?>
                                </span>
                            </div>
                            <div class="card-body">
                                <p class="text-muted">
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    <?= date('F j, Y', strtotime($event['event_date'])) ?>
                                    <?php if (!empty($event['event_time'])): ?>
                                        <i class="fas fa-clock ms-3 me-2"></i>
                                        <?= date('h:i A', strtotime($event['event_time'])) ?>
                                    <?php endif; ?>
                                </p>
                                <?php if (!empty($event['location'])): ?>
                                <p><i class="fas fa-map-marker-alt me-2"></i> <?= htmlspecialchars($event['location']) ?></p>
                                <?php endif; ?>
                                <p><?= nl2br(htmlspecialchars(substr($event['description'], 0, 150))) ?>...</p>
                                
                                <?php if ($event['status'] === 'cancelled'): ?>
                                <div class="cancellation-details">
                                    <h6 class="text-danger">Cancellation Details</h6>
                                    <p><strong>Reason:</strong> <?= htmlspecialchars($event['cancellation_reason']) ?></p>
                                    <?php if ($event['cancelled_at']): ?>
                                    <p><strong>Date:</strong> <?= date('M j, Y g:i A', strtotime($event['cancelled_at'])) ?></p>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="card-footer bg-white">
                                <a href="event_view.php?id=<?= $event['id'] ?>" class="btn btn-outline-primary">
                                    View Details
                                </a>
                                <?php if (isAdmin() && $event['status'] === 'upcoming'): ?>
                                <button onclick="cancelEvent(<?= $event['id'] ?>)" 
                                        class="btn btn-outline-danger float-end">
                                    Cancel Event
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Past Events Section -->
        <div class="mb-5">
            <h2 class="section-title">Past Events</h2>
            <?php if (empty($pastEvents)): ?>
                <div class="alert alert-info">
                    No past events to display.
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($pastEvents as $event): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card event-card h-100">
                            <div class="card-header bg-secondary text-white">
                                <h5><?= htmlspecialchars($event['title']) ?></h5>
                                <span class="badge bg-light text-dark status-badge">
                                    Past Event
                                </span>
                            </div>
                            <div class="card-body">
                                <p class="text-muted">
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    <?= date('F j, Y', strtotime($event['event_date'])) ?>
                                </p>
                                <?php if (!empty($event['description'])): ?>
                                <p><?= nl2br(htmlspecialchars(substr($event['description'], 0, 100))) ?>...</p>
                                <?php endif; ?>
                            </div>
                            <div class="card-footer bg-white">
                                <a href="event_view.php?id=<?= $event['id'] ?>" class="btn btn-outline-secondary w-100">
                                    View Recap
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="loadFooter.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    // Function to handle event cancellation
    function cancelEvent(eventId) {
        const reason = prompt('Please enter cancellation reason:');
        if (!reason) return;

        fetch('cancel_event.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                'event_id': eventId,
                'cancellation_reason': reason,
                'csrf_token': document.querySelector('meta[name="csrf-token"]').content
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Find and update the event card
                const card = document.querySelector(`.event-card[data-id="${eventId}"]`);
                if (card) {
                    card.classList.add('cancelled');
                    card.querySelector('.card-header').classList.replace('bg-primary', 'bg-danger');
                    card.querySelector('.status-badge').textContent = 'Cancelled';
                    card.querySelector('.status-badge').className = 'badge bg-warning status-badge';
                    
                    const cancellationHtml = `
                        <div class="cancellation-details">
                            <h6 class="text-danger">Cancellation Details</h6>
                            <p><strong>Reason:</strong> ${data.event.cancellation_reason}</p>
                            <p><strong>Date:</strong> ${new Date(data.event.cancelled_at).toLocaleString()}</p>
                        </div>
                    `;
                    card.querySelector('.card-body').insertAdjacentHTML('beforeend', cancellationHtml);
                    
                    // Remove cancel button
                    const cancelBtn = card.querySelector('.btn-outline-danger');
                    if (cancelBtn) cancelBtn.remove();
                }
                
                // Show success message
                const alert = document.createElement('div');
                alert.className = 'alert alert-success alert-dismissible fade show';
                alert.innerHTML = `
                    Event cancelled successfully!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.querySelector('.container').prepend(alert);
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error cancelling event');
        });
    }
    </script>
</body>
</html>