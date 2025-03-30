<?php
session_start();
error_reporting(E_ALL); // Show errors
ini_set('display_errors', 1);

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Hardcoded admin credentials (change these to your own)
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD_HASH', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'); // hash of 'password'

// Redirect to login if not authenticated
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Logout functionality
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importance Leadership - Admin Dashboard</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        
        /* Sidebar *//* Sidebar */
.sidebar {
    background-color: #ffffff;
    height: 100vh;
    width: 250px; /* Set a fixed width */
    position: fixed;
    top: 0;
    left: 0;
    box-shadow: 2px 0 10px rgba(0,0,0,0.1);
    z-index: 1000;
}

/* Sidebar Brand */
.sidebar-brand {
    padding: 1.5rem 1rem;
    border-bottom: 1px solid #eee;
}

.sidebar-brand img {
    height: 80px;
    width:auto;
}

/* Main Content */
.main-content {
    margin-left: 250px; /* Matches sidebar width */
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
        
        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 20px;
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
        
        /* Cards */
        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid #eee;
            padding: 1rem 1.25rem;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        /* Stats Cards */
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
        
        .stat-card .label {
            font-size: 0.875rem;
            color: var(--light-text);
        }
        
        .stat-card .trend {
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }
        
        .trend.up {
            color: var(--success);
        }
        
        .trend.down {
            color: var(--danger);
        }
        
        /* Tables */
        .table-responsive {
            border-radius: 0.5rem;
            overflow: hidden;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table thead th {
            background-color: var(--primary);
            color: white;
            border: none;
        }
        
        .table tbody tr:hover {
            background-color: rgba(16, 62, 108, 0.05);
        }
        
        /* Buttons */
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-light);
            border-color: var(--primary-light);
        }
        
        .btn-warning {
            background-color: var(--secondary);
            border-color: var(--secondary);
            color: var(--dark-text);
        }
        
        /* Progress Bars */
        .progress {
            height: 8px;
            border-radius: 4px;
        }
        
        .progress-bar {
            background-color: var(--primary);
        }
        
        /* Responsive */
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
        
        @media (max-width: 768px) {
            .stat-card {
                margin-bottom: 15px;
            }
        }
        img{
            width: 10%;
            height: 10%;
            }
        
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar col-md-3 col-lg-2 d-md-block">
        <div class="sidebar-brand">
            <img src="image/website-logo.png" alt="Importance Leadership Logo">
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="#">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#programs">
                    <i class="fas fa-project-diagram"></i>
                    <span>Programs</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#participants">
                    <i class="fas fa-users"></i>
                    <span>Participants</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#mentors">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>Mentors</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#events">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Events</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#donations">
                    <i class="fas fa-donate"></i>
                    <span>Donations</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#reports">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reports</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#settings">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <h4>Admin Dashboard</h4>
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <i class="fas fa-bell"></i>
                    <span class="badge bg-danger">3</span>
                </div>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown">
                        <img src="image/shema.png" alt="Admin" class="rounded-circle me-2"> 
                        <span><?php echo htmlspecialchars(ADMIN_USERNAME); ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="?logout=1"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="label">Total Participants</div>
                    <div class="value">2,543</div>
                    <div class="trend up"><i class="fas fa-arrow-up"></i> 12% from last month</div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="label">Active Mentors</div>
                    <div class="value">24</div>
                    <div class="trend up"><i class="fas fa-arrow-up"></i> 2 new this month</div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" id="programs">
                <div class="stat-card">
                    <div class="label">Programs Running</div>
                    <div class="value">8</div>
                    <div class="trend up"><i class="fas fa-arrow-up"></i> 3 active now</div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" id="donations">
                <div class="stat-card">
                    <div class="label">Total Donations</div>
                    <div class="value">$48,250</div>
                    <div class="trend up"><i class="fas fa-arrow-up"></i> $5,200 this month</div>
                </div>
            </div>
        </div>

        <!-- Programs Overview -->
        <div class="row mt-4">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Program Performance</h5>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Last 30 Days
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Last 7 Days</a></li>
                                <li><a class="dropdown-item" href="#">Last 30 Days</a></li>
                                <li><a class="dropdown-item" href="#">Last 90 Days</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Program</th>
                                        <th>Participants</th>
                                        <th>Completion</th>
                                        <th>Rating</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Leadership Development</td>
                                        <td>1,240</td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar" style="width: 78%"></div>
                                            </div>
                                            <small>78% complete</small>
                                        </td>
                                        <td>
                                            <i class="fas fa-star text-warning"></i> 4.8
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-primary">View</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Mentorship Program</td>
                                        <td>850</td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar" style="width: 65%"></div>
                                            </div>
                                            <small>65% complete</small>
                                        </td>
                                        <td>
                                            <i class="fas fa-star text-warning"></i> 4.9
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-primary">View</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Community Impact</td>
                                        <td>453</td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar" style="width: 82%"></div>
                                            </div>
                                            <small>82% complete</small>
                                        </td>
                                        <td>
                                            <i class="fas fa-star text-warning"></i> 4.7
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-primary">View</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Recent Donations</h5>
                        <button class="btn btn-sm btn-outline-secondary">View All</button>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">John Smith</h6>
                                    <small class="text-muted">Today, 10:45 AM</small>
                                </div>
                                <span class="badge bg-success">$500</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Acme Corporation</h6>
                                    <small class="text-muted">Yesterday, 3:22 PM</small>
                                </div>
                                <span class="badge bg-success">$2,500</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Sarah Johnson</h6>
                                    <small class="text-muted">Yesterday, 11:15 AM</small>
                                </div>
                                <span class="badge bg-success">$100</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Community Fund</h6>
                                    <small class="text-muted">2 days ago</small>
                                </div>
                                <span class="badge bg-success">$1,000</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Upcoming Events</h5>
                        <button class="btn btn-sm btn-outline-secondary">Add Event</button>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-1">Leadership Workshop</h6>
                                    <small class="text-muted">May 15</small>
                                </div>
                                <small class="text-muted">10:00 AM - 2:00 PM</small>
                                <div class="mt-2">
                                    <span class="badge bg-primary">32 Registered</span>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-1">Mentor Training</h6>
                                    <small class="text-muted">May 18</small>
                                </div>
                                <small class="text-muted">9:00 AM - 12:00 PM</small>
                                <div class="mt-2">
                                    <span class="badge bg-primary">12 Registered</span>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-1">Community Impact Day</h6>
                                    <small class="text-muted">May 22</small>
                                </div>
                                <small class="text-muted">All Day</small>
                                <div class="mt-2">
                                    <span class="badge bg-primary">45 Registered</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">Recent Activity</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>User</th>
                                <th>Activity</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Today, 09:30</td>
                                <td>Jane Doe</td>
                                <td>New participant registration</td>
                                <td>Leadership Development Program</td>
                            </tr>
                            <tr>
                                <td>Today, 08:45</td>
                                <td>System</td>
                                <td>Donation received</td>
                                <td>$500 from John Smith</td>
                            </tr>
                            <tr>
                                <td>Yesterday, 16:20</td>
                                <td>Mark Johnson</td>
                                <td>Added new event</td>
                                <td>Leadership Workshop on May 15</td>
                            </tr>
                            <tr>
                                <td>Yesterday, 14:10</td>
                                <td>Sarah Williams</td>
                                <td>Updated program</td>
                                <td>Mentorship Program curriculum</td>
                            </tr>
                            <tr>
                                <td>Yesterday, 11:05</td>
                                <td>System</td>
                                <td>New mentor application</td>
                                <td>David Brown - Business Leadership</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Sample chart for program participation
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.createElement('canvas');
            ctx.id = 'programChart';
            document.querySelector('.card-body').prepend(ctx);
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Leadership', 'Mentorship', 'Community'],
                    datasets: [{
                        label: 'Current Participants',
                        data: [1240, 850, 453],
                        backgroundColor: [
                            'rgba(16, 62, 108, 0.7)',
                            'rgba(255, 204, 0, 0.7)',
                            'rgba(40, 167, 69, 0.7)'
                        ],
                        borderColor: [
                            'rgba(16, 62, 108, 1)',
                            'rgba(255, 204, 0, 1)',
                            'rgba(40, 167, 69, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            
            // Sample notification dropdown
            document.querySelector('.fa-bell').addEventListener('click', function(e) {
                e.preventDefault();
                // In a real app, this would toggle a notifications dropdown
                alert('You have 3 new notifications');
            });
        });
    </script>
</body>
</html>