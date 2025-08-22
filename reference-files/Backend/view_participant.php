<?php
require_once 'auth_check.php';
require_once 'db_connect.php';

$pageTitle = "View Participant";
$activePage = "participants";

// Get participant ID from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    header("Location: participants.php");
    exit();
}

// Fetch participant details
try {
    $stmt = $pdo->prepare("
        SELECT * FROM participants 
        WHERE id = ?
    ");
    $stmt->execute([$id]);
    $participant = $stmt->fetch();
    
    if (!$participant) {
        header("Location: participants.php");
        exit();
    }
} catch (PDOException $e) {
    die("Error fetching participant: " . $e->getMessage());
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
            margin-bottom: 20px;
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
            position: sticky;
            top: 0;
        }
        
        .badge-program {
            background-color: var(--primary-light);
            color: white;
        }
        
        .text-ellipsis {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
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
                width: calc(100% - 70px);
            }
        }
        
        .admin-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .action-btns .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <?php include 'header.php'; ?>
        
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-md-12">
                    <a href="participants.php" class="btn btn-secondary mb-3">
                        <i class="fas fa-arrow-left"></i> Back to Participants
                    </a>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="detail-card">
                        <div class="detail-header">
                            <h4 class="mb-0">Participant Details</h4>
                        </div>
                        <div class="detail-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="detail-value">
                                        <div class="detail-label">Full Name</div>
                                        <div><?= htmlspecialchars($participant['name']) ?></div>
                                    </div>
                                    
                                    <div class="detail-value">
                                        <div class="detail-label">Email</div>
                                        <div><?= htmlspecialchars($participant['email']) ?></div>
                                    </div>
                                    
                                    <div class="detail-value">
                                        <div class="detail-label">Phone</div>
                                        <div><?= htmlspecialchars($participant['phone']) ?></div>
                                    </div>
                                    
                                    <div class="detail-value">
                                        <div class="detail-label">Gender</div>
                                        <div><?= htmlspecialchars(ucfirst($participant['gender'])) ?></div>
                                    </div>
                                    
                                    <div class="detail-value">
                                        <div class="detail-label">Date of Birth</div>
                                        <div><?= date('F j, Y', strtotime($participant['dob'])) ?></div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="detail-value">
                                        <div class="detail-label">Location</div>
                                        <div><?= htmlspecialchars($participant['city']) ?>, <?= htmlspecialchars($participant['country']) ?></div>
                                    </div>
                                    
                                    <div class="detail-value">
                                        <div class="detail-label">Education Level</div>
                                        <div><?= htmlspecialchars($participant['education']) ?></div>
                                    </div>
                                    
                                    <div class="detail-value">
                                        <div class="detail-label">Organization</div>
                                        <div><?= $participant['organization'] ? htmlspecialchars($participant['organization']) : 'N/A' ?></div>
                                    </div>
                                    
                                    <div class="detail-value">
                                        <div class="detail-label">Job Title</div>
                                        <div><?= $participant['job_title'] ? htmlspecialchars($participant['job_title']) : 'N/A' ?></div>
                                    </div>
                                    
                                    <div class="detail-value">
                                        <div class="detail-label">Program</div>
                                        <span class="program-badge"><?= htmlspecialchars($participant['program']) ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="detail-value">
                                        <div class="detail-label">Goals</div>
                                        <div><?= nl2br(htmlspecialchars($participant['goals'])) ?></div>
                                    </div>
                                    
                                    <div class="detail-value">
                                        <div class="detail-label">Motivation</div>
                                        <div><?= nl2br(htmlspecialchars($participant['motivation'])) ?></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <span class="text-muted">Joined: <?= date('F j, Y, g:i a', strtotime($participant['created_at'])) ?></span>
                                        </div>
                                        <div>
                                            <a href="edit_participant.php?id=<?= $participant['id'] ?>" class="btn btn-primary">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>