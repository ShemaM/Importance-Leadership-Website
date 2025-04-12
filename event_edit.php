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

    // Fetch event media
    $mediaStmt = $pdo->prepare("SELECT * FROM event_media WHERE event_id = ? ORDER BY display_order, uploaded_at DESC");
    $mediaStmt->execute([$eventId]);
    $mediaFiles = $mediaStmt->fetchAll(PDO::FETCH_ASSOC);

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
                status = ?,
                is_virtual = ?,
                virtual_meeting_url = ?,
                max_attendees = ?,
                registration_required = ?,
                registration_deadline = ?,
                thumbnail_url = ?,
                banner_url = ?
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
            isset($_POST['is_virtual']) ? 1 : 0,
            $_POST['virtual_meeting_url'] ?? null,
            $_POST['max_attendees'] ?? null,
            isset($_POST['registration_required']) ? 1 : 0,
            $_POST['registration_deadline'] ?? null,
            $_POST['thumbnail_url'] ?? null,
            $_POST['banner_url'] ?? null,
            $eventId
        ]);

        $_SESSION['message'] = "Event updated successfully!";
        header("Location: event_edit.php?id=$eventId");
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
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
        
        /* Dropzone styles */
        .dropzone {
            border: 2px dashed #0087F7;
            border-radius: 5px;
            background: #f8f9fa;
            min-height: 150px;
            padding: 20px;
        }
        
        .dropzone .dz-message {
            font-size: 1.2rem;
            color: #6c757d;
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

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="isVirtual" name="is_virtual" 
                                    <?= $event['is_virtual'] ? 'checked' : '' ?>>
                                <label class="form-check-label" for="isVirtual">Virtual Event</label>
                            </div>

                            <div class="mb-3 virtual-meeting-url" style="<?= $event['is_virtual'] ? '' : 'display: none;' ?>">
                                <label class="form-label">Virtual Meeting URL</label>
                                <input type="url" name="virtual_meeting_url" class="form-control" 
                                       value="<?= htmlspecialchars($event['virtual_meeting_url']) ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Thumbnail URL</label>
                                <input type="url" name="thumbnail_url" class="form-control" 
                                       value="<?= htmlspecialchars($event['thumbnail_url']) ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Banner URL</label>
                                <input type="url" name="banner_url" class="form-control" 
                                       value="<?= htmlspecialchars($event['banner_url']) ?>">
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

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="registrationRequired" name="registration_required" 
                                    <?= $event['registration_required'] ? 'checked' : '' ?>>
                                <label class="form-check-label" for="registrationRequired">Require Registration</label>
                            </div>

                            <div class="mb-3 registration-fields" style="<?= $event['registration_required'] ? '' : 'display: none;' ?>">
                                <label class="form-label">Max Attendees</label>
                                <input type="number" name="max_attendees" class="form-control" 
                                       value="<?= htmlspecialchars($event['max_attendees']) ?>">
                            </div>

                            <div class="mb-3 registration-fields" style="<?= $event['registration_required'] ? '' : 'display: none;' ?>">
                                <label class="form-label">Registration Deadline</label>
                                <input type="datetime-local" name="registration_deadline" class="form-control" 
                                       value="<?= $event['registration_deadline'] ? date('Y-m-d\TH:i', strtotime($event['registration_deadline'])) : '' ?>">
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

                    <!-- Media Upload Section -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Event Media</h5>
                        </div>
                        <div class="card-body">
                            <!-- Dropzone for file uploads -->
                            <div class="dropzone mb-4" id="mediaDropzone">
                                <div class="dz-message">
                                    <i class="fas fa-cloud-upload-alt fa-2x mb-3"></i><br>
                                    Drop files here or click to upload<br>
                                    <span class="text-muted">(Images, Videos, PDFs, etc.)</span>
                                </div>
                            </div>

                            <!-- Existing Media Files -->
                            <?php if (!empty($mediaFiles)): ?>
                                <h6>Existing Media Files</h6>
                                <div class="media-gallery">
                                    <?php foreach ($mediaFiles as $media): ?>
                                        <div class="media-item">
                                            <div class="media-badge">
                                                <?= ucfirst($media['media_type']) ?>
                                                <?= $media['is_featured'] ? '★' : '' ?>
                                            </div>
                                            
                                            <?php if ($media['media_type'] === 'image'): ?>
                                                <a href="<?= htmlspecialchars($media['file_url']) ?>" target="_blank">
                                                    <div class="media-thumbnail" style="background-image: url('<?= htmlspecialchars($media['thumbnail_url'] ?: $media['file_url']) ?>')">
                                                        <i class="fas fa-expand"></i>
                                                    </div>
                                                </a>
                                            <?php elseif ($media['media_type'] === 'video'): ?>
                                                <a href="<?= htmlspecialchars($media['file_url']) ?>" target="_blank">
                                                    <div class="media-thumbnail" style="background-image: url('<?= htmlspecialchars($media['thumbnail_url'] ?: 'https://via.placeholder.com/300x200?text=Video') ?>')">
                                                        <i class="fas fa-play"></i>
                                                    </div>
                                                </a>
                                            <?php else: ?>
                                                <a href="<?= htmlspecialchars($media['file_url']) ?>" target="_blank">
                                                    <div class="media-thumbnail" style="background-image: url('https://via.placeholder.com/300x200?text=' + '<?= ucfirst($media['media_type']) ?>')">
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
                                                <button type="button" class="btn btn-sm btn-outline-primary media-feature-btn" 
                                                    title="<?= $media['is_featured'] ? 'Unfeature' : 'Feature' ?>" 
                                                    data-media-id="<?= $media['id'] ?>" 
                                                    data-is-featured="<?= $media['is_featured'] ? 1 : 0 ?>">
                                                    <i class="fas fa-star<?= $media['is_featured'] ? '' : '-o' ?>"></i>
                                                </button>
                                                <a href="delete_media.php?id=<?= $media['id'] ?>&event_id=<?= $event['id'] ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this media?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info">No media files uploaded yet.</div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
    <script>
        // Toggle virtual meeting URL field
        document.getElementById('isVirtual').addEventListener('change', function() {
            document.querySelector('.virtual-meeting-url').style.display = this.checked ? 'block' : 'none';
        });

        // Toggle registration fields
        document.getElementById('registrationRequired').addEventListener('change', function() {
            document.querySelectorAll('.registration-fields').forEach(el => {
                el.style.display = this.checked ? 'block' : 'none';
            });
        });

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

        // Initialize Dropzone
        Dropzone.autoDiscover = false;
        const mediaDropzone = new Dropzone("#mediaDropzone", {
            url: "upload_media.php?event_id=<?= $eventId ?>",
            paramName: "file",
            maxFilesize: 20, // MB
            acceptedFiles: "image/*,video/*,.pdf,.doc,.docx,.ppt,.pptx",
            addRemoveLinks: true,
            headers: {
                "X-CSRF-Token": "<?= $_SESSION['csrf_token'] ?>"
            },
            init: function() {
                this.on("success", function(file, response) {
                    if (response.success) {
                        // Reload the page to show the new media
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        this.removeFile(file);
                        alert(response.message || "Error uploading file");
                    }
                });
                this.on("error", function(file, message) {
                    this.removeFile(file);
                    alert(message);
                });
            }
        });

        // Feature/unfeature media
        document.querySelectorAll('.media-feature-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const mediaId = this.dataset.mediaId;
                const isFeatured = this.dataset.isFeatured === '1';
                
                fetch('feature_media.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `media_id=${mediaId}&is_featured=${isFeatured ? 0 : 1}&csrf_token=<?= $_SESSION['csrf_token'] ?>`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message || "Error updating media");
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("An error occurred");
                });
            });
        });
    </script>
</body>
</html>