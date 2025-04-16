<style>
    .sidebar {
        background-color:rgb(5, 37, 69);
        color: #fff;
        height: 100vh;
        padding: 15px;
        position: fixed;
        top: 0;
        left: 0;
        width: 250px;
        transform: translateX(0);
        transition: transform 0.3s ease-in-out;
        z-index: 1000;
    }

    .sidebar.hidden {
        transform: translateX(-100%);
    }

    .sidebar-brand img {
        max-width: 100%;
        height: auto;
        margin-bottom: 20px;
    }

    .nav-link {
        color:#ffff;
        font-size: 17px;
        font-weight:bold;
        border-radius: 5px;
        padding: 10px 15px;
        display: flex;
        align-items: center;
        text-decoration: none;
        transition: background-color 0.3s, color 0.3s;
    }

    .nav-link i {
        margin-right: 10px;
    }

    .nav-link:hover {
        background-color: #495057;
        color: #fff;
    }

    .nav-link.active {
        background-color: #007bff;
        color: #fff;
    }

    .nav-item {
        margin-bottom: 10px;
    }

    .sidebar ul {
        padding-left: 0;
        list-style: none;
    }

    .toggle-btn {
        position: fixed;
        top: 15px;
        left: 15px;
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 15px;
        cursor: pointer;
        z-index: 1100;
        border-radius: 5px;
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 200px;
        }

        .toggle-btn {
            top: 10px;
            left: 10px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.querySelector('.sidebar');
        const toggleBtn = document.querySelector('.toggle-btn');

        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('hidden');
        });
    });
</script>

<button class="toggle-btn">☰</button>

<div class="sidebar">
    <div class="sidebar-brand">
        <img src="../image/website-logo.png" alt="<?= htmlspecialchars("Importance Leadership" ) ?> Logo">
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?= $activePage === 'dashboard' ? 'active' : '' ?>" href="dashboard.php">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $activePage === 'programs' ? 'active' : '' ?>" href="programs.php">
                <i class="fas fa-project-diagram"></i>
                <span>Programs</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $activePage === 'participants' ? 'active' : '' ?>" href="participants.php">
                <i class="fas fa-users"></i>
                <span>Participants</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $activePage === 'mentors' ? 'active' : '' ?>" href="mentors.php">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>Mentors</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $activePage === 'mentees' ? 'active' : '' ?>" href="mentees.php">
                <i class="fas fa-user-graduate"></i>
                <span>Mentees</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $activePage === 'events' ? 'active' : '' ?>" href="events.php">
                <i class="fas fa-calendar-alt"></i>
                <span>Events</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $activePage === 'donations' ? 'active' : '' ?>" href="donations.php">
                <i class="fas fa-donate"></i>
                <span>Donations</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $activePage === 'subscribers' ? 'active' : '' ?>" href="subscribers.php">
                <i class="fas fa-envelope"></i>
                <span>Subscribers</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $activePage === 'reports' ? 'active' : '' ?>" href="reports.php">
                <i class="fas fa-chart-bar"></i>
                <span>Reports</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $activePage === 'settings' ? 'active' : '' ?>" href="settings.php">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
        </li>
    </ul>
</div>