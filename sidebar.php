<div class="sidebar">
    <div class="sidebar-brand">
        <img src="image/website-logo.png" alt="<?= htmlspecialchars(SITE_NAME) ?> Logo">
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