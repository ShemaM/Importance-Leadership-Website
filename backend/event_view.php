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

    // Fetch event media
    $mediaStmt = $pdo->prepare("SELECT * FROM event_media WHERE event_id = ? ORDER BY display_order, uploaded_at DESC");
    $mediaStmt->execute([$eventId]);
    $mediaFiles = $mediaStmt->fetchAll(PDO::FETCH_ASSOC);

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <link rel="stylesheet" href="styles/admin.css">
    <style>
        /* [Previous CSS styles remain the same] */
        
        /* Media Gallery Styles */
        .media-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        
        .media-item {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            background-color: #fff;
        }
        
        .media-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .media-thumbnail {
            height: 150px;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        
        .media-thumbnail i {
            font-size: 3rem;
            color: rgba(255,255,255,0.8);
            text-shadow: 0 2px 5px rgba(0,0,0,0.3);
        }
        
        .media-info {
            padding: 10px;
        }
        
        .media-title {
            font-size: 0.9rem;
            margin-bottom: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .media-meta {
            font-size: 0.8rem;
            color: #6c757d;
        }
        
        .media-actions {
            position: absolute;
            top: 5px;
            right: 5px;
            display: flex;
            gap: 5px;
        }
        
        .media-badge {
            position: absolute;
            top: 5px;
            left: 5px;
            background-color: rgba(0,0,0,0.7);
            color: white;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 0.7rem;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .media-gallery {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }
            
            .media-thumbnail {
                height: 120px;
            }
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

            <!-- Media Gallery Section -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Event Media</h5>
                    <a href="event_media_upload.php?event_id=<?= $event['id'] ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Add Media
                    </a>
                </div>
                <div class="card-body">
                    <?php if (empty($mediaFiles)): ?>
                        <div class="alert alert-info">No media files available for this event.</div>
                    <?php else: ?>
                        <div class="media-gallery">
                            <?php foreach ($mediaFiles as $media): ?>
                                <div class="media-item">
                                    <div class="media-badge">
                                        <?= ucfirst($media['media_type']) ?>
                                    </div>
                                    
                                    <?php if ($media['media_type'] === 'image'): ?>
                                        <a href="<?= htmlspecialchars($media['file_url']) ?>" data-lightbox="event-media" data-title="<?= htmlspecialchars($media['caption'] ?? $media['file_name']) ?>">
                                            <div class="media-thumbnail" style="background-image: url('<?= htmlspecialchars($media['thumbnail_url'] ?: $media['file_url']) ?>')">
                                                <i class="fas fa-expand"></i>
                                            </div>
                                        </a>
                                    <?php elseif ($media['media_type'] === 'video'): ?>
                                        <a href="<?= htmlspecialchars($media['file_url']) ?>" data-lightbox="event-media" data-title="<?= htmlspecialchars($media['caption'] ?? $media['file_name']) ?>">
                                            <div class="media-thumbnail" style="background-image: url('<?= htmlspecialchars($media['thumbnail_url'] ?: 'https://via.placeholder.com/300x200?text=Video') ?>')">
                                                <i class="fas fa-play"></i>
                                            </div>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= htmlspecialchars($media['file_url']) ?>" target="_blank">
                                            <div class="media-thumbnail" style="background-image: url('<?= htmlspecialchars($media['thumbnail_url'] ?: 'https://via.placeholder.com/300x200?text=' . ucfirst($media['media_type'])) ?>')">
                                                <i class="fas fa-file"></i>
                                            </div>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <div class="media-info">
                                        <div class="media-title" title="<?= htmlspecialchars($media['file_name']) ?>">
                                            <?= htmlspecialchars($media['caption'] ?? $media['file_name']) ?>
                                        </div>
                                        <div class="media-meta">
                                            <?= round($media['file_size'] / 1024, 1) ?> KB
                                        </div>
                                    </div>
                                    
                                    <div class="media-actions">
                                        <a href="download.php?file=<?= urlencode($media['file_url']) ?>&name=<?= urlencode($media['file_name']) ?>" class="btn btn-sm btn-outline-secondary" title="Download">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <?php if ($_SESSION['user_role'] === 'admin' || $_SESSION['user_id'] == $media['uploaded_by']): ?>
                                            <a href="delete_media.php?id=<?= $media['id'] ?>&event_id=<?= $event['id'] ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this media?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script>
        // Initialize lightbox with custom options
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'albumLabel': 'Media %1 of %2',
            'disableScrolling': true,
            'fitImagesInViewport': true
        });
    </script>
</body>
</html>