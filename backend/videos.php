<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importanceleadership.com - Video Library</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #212529;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        .main-content {
            padding: 20px;
            max-width: 1600px;
            margin: 0 auto;
        }

        h1, h3 {
            color: #343a40;
            font-weight: 600;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }

        .dropdown-menu .dropdown-item.active {
            background-color: #007bff;
            color: #fff;
        }

        .video-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease;
            background: white;
            height: 100%;
        }

        .video-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .video-container {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
            height: 0;
            overflow: hidden;
        }

        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        .video-card .card-body {
            padding: 15px;
        }

        .video-title {
            font-weight: 600;
            margin-bottom: 8px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 48px;
        }

        .video-meta {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .section-title {
            position: relative;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .section-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 3px;
            background-color: #007bff;
        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
        }

        .pagination .page-link {
            color: #007bff;
            padding: 8px 16px;
            border-radius: 4px;
        }

        .pagination .page-link:hover {
            color: #0056b3;
            background-color: #e9ecef;
        }

        @media (max-width: 768px) {
            .d-flex {
                flex-direction: column;
            }

            .gap-2 {
                gap: 10px !important;
            }
        }

        /* Header styles */
        .site-header {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
            margin-bottom: 30px;
        }

        .site-header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .site-logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: #007bff;
            text-decoration: none;
        }

        /* Search modal styles */
        .search-modal .modal-content {
            border-radius: 10px;
        }

        .search-modal .modal-header {
            border-bottom: none;
            padding-bottom: 0;
        }

        .search-modal .form-control {
            padding: 12px 15px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="site-header">
        <div class="container">
            <a href="#" class="site-logo">ImportanceLeadership</a>
            <nav>
                <ul class="nav">
                    <li class="nav-item"><a href="#" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Videos</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Categories</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">About</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <div class="main-content">
        <div class="container-fluid mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h2"><i class="fas fa-video me-2"></i> Video Library</h1>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#searchModal">
                    <i class="fas fa-search me-1"></i> Search Videos
                </button>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-filter me-1"></i> Categories
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item active" href="#">All Categories</a></li>
                        <li><a class="dropdown-item" href="#">Leadership</a></li>
                        <li><a class="dropdown-item" href="#">Management</a></li>
                        <li><a class="dropdown-item" href="#">Communication</a></li>
                        <li><a class="dropdown-item" href="#">Team Building</a></li>
                        <li><a class="dropdown-item" href="#">Motivation</a></li>
                    </ul>
                </div>

                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-sort me-1"></i> Sort By
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item active" href="#">Newest First</a></li>
                        <li><a class="dropdown-item" href="#">Most Popular</a></li>
                        <li><a class="dropdown-item" href="#">A-Z</a></li>
                        <li><a class="dropdown-item" href="#">Z-A</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Recently Watched Section -->
        <div class="container-fluid mb-5">
            <h3 class="h4 section-title">Continue Watching</h3>
            <div class="row">
                <!-- Video Card 1 -->
                <div class="col-md-4 mb-4">
                    <div class="video-card">
                        <div class="video-container">
                            <iframe src="https://www.youtube.com/embed/-ds7EyJf6Ak" title="The Keys to Becoming a True Leader" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                        <div class="card-body">
                            <h5 class="video-title">The Keys to Becoming a True Leader</h5>
                            <div class="video-meta d-flex justify-content-between">
                                <span><i class="fas fa-clock me-1"></i> 8:42</span>
                                <span><i class="fas fa-eye me-1"></i> 1.2M views</span>
                            </div>
                            <div class="progress mt-2" style="height: 5px;">
                                <div class="progress-bar" role="progressbar" style="width: 65%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Video Card 2 -->
                <div class="col-md-4 mb-4">
                    <div class="video-card">
                        <div class="video-container">
                            <iframe src="https://www.youtube.com/embed/7OqwKfgVagM" title="How to Build Trust as a Leader" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                        <div class="card-body">
                            <h5 class="video-title">How to Build Trust as a Leader</h5>
                            <div class="video-meta d-flex justify-content-between">
                                <span><i class="fas fa-clock me-1"></i> 12:18</span>
                                <span><i class="fas fa-eye me-1"></i> 890K views</span>
                            </div>
                            <div class="progress mt-2" style="height: 5px;">
                                <div class="progress-bar" role="progressbar" style="width: 30%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Video Card 3 -->
                <div class="col-md-4 mb-4">
                    <div class="video-card">
                        <div class="video-container">
                            <iframe src="https://www.youtube.com/embed/ad9jZ4qL0L0" title="5 Essential Leadership Skills" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                        <div class="card-body">
                            <h5 class="video-title">5 Essential Leadership Skills</h5>
                            <div class="video-meta d-flex justify-content-between">
                                <span><i class="fas fa-clock me-1"></i> 15:22</span>
                                <span><i class="fas fa-eye me-1"></i> 1.5M views</span>
                            </div>
                            <div class="progress mt-2" style="height: 5px;">
                                <div class="progress-bar" role="progressbar" style="width: 80%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Featured Videos Section -->
        <div class="container-fluid mb-5">
            <h3 class="h4 section-title">Featured Videos</h3>
            <div class="row">
                <!-- Video Card 1 - Your sample video -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="video-card">
                        <div class="video-container">
                            <iframe src="https://www.youtube.com/embed/-ds7EyJf6Ak" title="The Keys to Becoming a True Leader" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                        <div class="card-body">
                            <h5 class="video-title">The Keys to Becoming a True Leader</h5>
                            <div class="video-meta d-flex justify-content-between">
                                <span><i class="fas fa-clock me-1"></i> 8:42</span>
                                <span><i class="fas fa-eye me-1"></i> 1.2M views</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Video Card 2 -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="video-card">
                        <div class="video-container">
                            <iframe src="https://www.youtube.com/embed/XKUPDUDOBVo" title="Simon Sinek on Leadership" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                        <div class="card-body">
                            <h5 class="video-title">Simon Sinek on Leadership</h5>
                            <div class="video-meta d-flex justify-content-between">
                                <span><i class="fas fa-clock me-1"></i> 12:35</span>
                                <span><i class="fas fa-eye me-1"></i> 3.1M views</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Video Card 3 -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="video-card">
                        <div class="video-container">
                            <iframe src="https://www.youtube.com/embed/lmyZMtPVodo" title="How Great Leaders Inspire Action" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                        <div class="card-body">
                            <h5 class="video-title">How Great Leaders Inspire Action</h5>
                            <div class="video-meta d-flex justify-content-between">
                                <span><i class="fas fa-clock me-1"></i> 18:25</span>
                                <span><i class="fas fa-eye me-1"></i> 2.7M views</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Video Card 4 -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="video-card">
                        <div class="video-container">
                            <iframe src="https://www.youtube.com/embed/nBdYqfdrg6w" title="The Power of Emotional Intelligence" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                        <div class="card-body">
                            <h5 class="video-title">The Power of Emotional Intelligence</h5>
                            <div class="video-meta d-flex justify-content-between">
                                <span><i class="fas fa-clock me-1"></i> 15:45</span>
                                <span><i class="fas fa-eye me-1"></i> 1.8M views</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- All Videos Section -->
        <div class="container-fluid mb-5">
            <h3 class="h4 section-title">All Videos</h3>
            <div class="row">
                <!-- Video Card 1 -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="video-card">
                        <div class="video-container">
                            <iframe src="https://www.youtube.com/embed/UQrPVmcgJJk" title="Visionary Leadership" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                        <div class="card-body">
                            <h5 class="video-title">Visionary Leadership</h5>
                            <div class="video-meta d-flex justify-content-between">
                                <span><i class="fas fa-clock me-1"></i> 14:30</span>
                                <span><i class="fas fa-eye me-1"></i> 1.1M views</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Video Card 2 -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="video-card">
                        <div class="video-container">
                            <iframe src="https://www.youtube.com/embed/2kEkpS6WAv4" title="Delegation Strategies" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                        <div class="card-body">
                            <h5 class="video-title">Delegation Strategies</h5>
                            <div class="video-meta d-flex justify-content-between">
                                <span><i class="fas fa-clock me-1"></i> 16:20</span>
                                <span><i class="fas fa-eye me-1"></i> 950K views</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Video Card 3 -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="video-card">
                        <div class="video-container">
                            <iframe src="https://www.youtube.com/embed/8NPzLBSBzPI" title="Crisis Management" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                        <div class="card-body">
                            <h5 class="video-title">Crisis Management</h5>
                            <div class="video-meta d-flex justify-content-between">
                                <span><i class="fas fa-clock me-1"></i> 22:10</span>
                                <span><i class="fas fa-eye me-1"></i> 1.4M views</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Video Card 4 -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="video-card">
                        <div class="video-container">
                            <iframe src="https://www.youtube.com/embed/2kEkpS6WAv4" title="Innovation in Leadership" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                        <div class="card-body">
                            <h5 class="video-title">Innovation in Leadership</h5>
                            <div class="video-meta d-flex justify-content-between">
                                <span><i class="fas fa-clock me-1"></i> 19:25</span>
                                <span><i class="fas fa-eye me-1"></i> 1.3M views</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <nav>
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Search Modal -->
    <div class="modal fade search-modal" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="searchModalLabel">Search Videos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search for videos..." aria-label="Search for videos">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div class="d-flex gap-2">
                        <select class="form-select">
                            <option selected>All Categories</option>
                            <option>Leadership</option>
                            <option>Management</option>
                            <option>Communication</option>
                            <option>Team Building</option>
                        </select>
                        <select class="form-select">
                            <option selected>Any Duration</option>
                            <option>Under 5 minutes</option>
                            <option>5-15 minutes</option>
                            <option>15-30 minutes</option>
                            <option>Over 30 minutes</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple script to handle video card clicks
        document.addEventListener('DOMContentLoaded', function() {
            const videoCards = document.querySelectorAll('.video-card');
            
            videoCards.forEach(card => {
                card.addEventListener('click', function(e) {
                    // Don't trigger if clicking on a link or button inside the card
                    if (e.target.tagName === 'A' || e.target.tagName === 'BUTTON' || e.target.closest('a') || e.target.closest('button')) {
                        return;
                    }
                    
                    // In a real application, this would open the video player
                    const videoTitle = this.querySelector('.video-title').textContent;
                    console.log('Opening video: ' + videoTitle);
                });
            });
        });
    </script>
</body>
</html>