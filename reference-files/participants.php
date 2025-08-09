<?php
require_once 'auth_check.php';
require_once 'db_connect.php';

$pageTitle = "Participants Management";
$activePage = "participants";

// Get all participants from the participants table
try {
    $stmt = $pdo->prepare("
        SELECT id, name, email, phone, gender, dob, country, city, 
               education, organization, job_title, program, goals, 
               motivation, created_at
        FROM participants
        ORDER BY created_at DESC
    ");
    $stmt->execute();
    $participants = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error fetching participants: " . $e->getMessage());
}

// Get program statistics
try {
    $programStats = $pdo->query("
        SELECT program, COUNT(*) as count 
        FROM participants 
        GROUP BY program
    ")->fetchAll();
} catch (PDOException $e) {
    $programStats = [];
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
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
                <div class="col-md-4">
                    <div class="stat-card">
                        <h6>Total Participants</h6>
                        <div class="value"><?= count($participants) ?></div>
                    </div>
                </div>
                <?php foreach ($programStats as $stat): ?>
                <div class="col-md-4">
                    <div class="stat-card">
                        <h6><?= htmlspecialchars($stat['program']) ?> Participants</h6>
                        <div class="value"><?= $stat['count'] ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Participants List</h5>
                    <div>
                        <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Search participants...">
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="participantsTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Program</th>
                                    <th>Location</th>
                                    <th>Joined</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($participants as $participant): ?>
                                <tr>
                                    <td><?= htmlspecialchars($participant['name']) ?></td>
                                    <td><?= htmlspecialchars($participant['email']) ?></td>
                                    <td><?= htmlspecialchars($participant['phone']) ?></td>
                                    <td>
                                        <span class="badge badge-program"><?= htmlspecialchars($participant['program']) ?></span>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($participant['city']) ?>, <?= htmlspecialchars($participant['country']) ?>
                                    </td>
                                    <td><?= date('M j, Y', strtotime($participant['created_at'])) ?></td>
                                    <td class="action-btns">
                                        <a href="view_participant.php?id=<?= $participant['id'] ?>" 
                                           class="btn btn-sm btn-primary" 
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="edit_participant.php?id=<?= $participant['id'] ?>" 
                                           class="btn btn-sm btn-secondary" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="delete_participant.php?id=<?= $participant['id'] ?>" 
                                           class="btn btn-sm btn-danger" 
                                           title="Delete"
                                           onclick="return confirm('Are you sure you want to delete this participant?')">
                                            <i class="fas fa-trash-alt"></i>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple table search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#participantsTable tbody tr');
            
            rows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                row.style.display = rowText.includes(searchValue) ? '' : 'none';
            });
        });
        
        // Make table rows clickable
        document.querySelectorAll('#participantsTable tbody tr').forEach(row => {
            row.addEventListener('click', (e) => {
                // Don't navigate if user clicked on an action button
                if (!e.target.closest('.action-btns')) {
                    const viewLink = row.querySelector('.btn-primary');
                    if (viewLink) {
                        window.location.href = viewLink.href;
                    }
                }
            });
            
            // Add hover effect
            row.style.cursor = 'pointer';
            row.addEventListener('mouseenter', () => {
                row.style.backgroundColor = 'rgba(0, 0, 0, 0.03)';
            });
            row.addEventListener('mouseleave', () => {
                row.style.backgroundColor = '';
            });
        });
    </script>
</body>
</html>