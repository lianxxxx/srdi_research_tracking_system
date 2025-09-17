<!-- Sidebar toggle button (visible on small screens) -->
<button class="btn btn-primary d-md-none mb-3" type="button" id="sidebarToggle">
    <i class="bx bx-menu"></i> Menu
</button>

<!-- Sidebar -->
<aside id="sidebar" class="left-sidebar bg-light border-end vh-100 position-fixed"
    style="width: 250px; top: 0; left: 0; overflow-y: auto; z-index: 1030; transition: transform 0.3s ease;">
    <div class="d-flex flex-column h-100">
        <div class="brand-logo d-flex align-items-center justify-content-between p-3">
            <h4 class="mb-0" style="color: #28a745;"><i class=""></i>DMMMSU-SRDI</h4>
            <button class="btn btn-sm btn-outline-secondary d-md-none" id="sidebarClose"><i
                    class="bx bx-x"></i></button>
        </div>
        <nav class="sidebar-nav flex-grow-1 px-3 py-2">
            <ul id="sidebarnav" class="nav flex-column">
                <!-- Section: Main -->
                <li class="nav-small-cap text-uppercase text-muted mt-4 mb-2">Main</li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="../admin/dashboard.php">
                        <i class="fa-solid fa-gauge me-2"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="../admin/report.php">
                        <i class="fa fa-bar-chart me-2"></i> Research Publish Report
                    </a>
                </li>

                <!-- Research Dropdown -->
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" data-bs-toggle="collapse" href="#researchCollapse"
                        role="button" aria-expanded="false" aria-controls="researchCollapse">
                        <i class="fa fa-flask me-2"></i> Research
                        <i class="fa fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="researchCollapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="../admin/researchPending.php" class="nav-link ps-4"><i
                                        class="fa fa-hourglass-start me-2"></i> Research Pending</a></li>
                            <li><a href="../admin/researchApproved.php" class="nav-link ps-4"><i
                                        class="fa fa-check-circle me-2"></i> Research Approved</a></li>
                            <li><a href="../admin/researchCancelled.php" class="nav-link ps-4"><i
                                        class="fa fa-upload me-2"></i>
                                    Research Cancelled</a></li>
                            <li><a href="../admin/researchRejected.php" class="nav-link ps-4"><i
                                        class="fa fa-times-circle me-2"></i> Research Rejected</a></li>
                            <li><a href="../admin/researchRevised.php" class="nav-link ps-4"><i
                                        class="fa fa-edit me-2"></i>
                                    Research Revised</a></li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="../admin/history.php">
                        <i class="fa fa-history me-2"></i> Research Audit
                    </a>
                </li>

                <!-- Section: Others -->
                <li class="nav-small-cap text-uppercase text-muted mt-4 mb-2">Others</li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="../admin/backup.php">
                        <i class="fa fa-database me-2"></i> Backup & Restore
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="../admin/activityLog.php">
                        <i class="fas fa-clipboard-list me-2"></i> Activity Logs
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="../admin/createUser.php">
                        <i class="fa fa-bar-chart me-2"></i>Create New User
                    </a>
                </li>
                <!-- Section: Admin Settings -->
                <li class="nav-small-cap text-uppercase text-muted mt-4 mb-2">Admin Settings</li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="../admin/profile.php">
                        <i class="fa fa-user-circle me-2"></i> Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="/srdi_system/view/auth/logout.php"
                        onclick="return confirm('Are you sure you want to logout?');">
                        <i class="fa fa-sign-out me-2"></i> Log Out
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>

<!-- Sidebar overlay for mobile -->
<div id="sidebarOverlay" class="d-md-none position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50"
    style="z-index: 1020; display:none;"></div>

<!-- JavaScript (toggle & responsiveness) -->
<script>
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarClose = document.getElementById('sidebarClose');

    document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(el => {
        el.addEventListener('click', () => {
            const icon = el.querySelector('.fa-chevron-down');
            if (icon) icon.classList.toggle('rotate');
        });
    });

    function openSidebar() {
        sidebar.style.transform = 'translateX(0)';
        sidebarOverlay.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.style.transform = 'translateX(-100%)';
        sidebarOverlay.style.display = 'none';
        document.body.style.overflow = '';
    }

    if (window.innerWidth < 768) {
        sidebar.style.transform = 'translateX(-100%)';
    }

    sidebarToggle.addEventListener('click', openSidebar);
    sidebarClose.addEventListener('click', closeSidebar);
    sidebarOverlay.addEventListener('click', closeSidebar);

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            sidebar.style.transform = 'translateX(0)';
            sidebarOverlay.style.display = 'none';
            document.body.style.overflow = '';
        } else {
            sidebar.style.transform = 'translateX(-100%)';
        }
    });
</script>

<!-- Sidebar Chevron Animation (Optional) -->
<style>
    .fa-chevron-down.rotate {
        transform: rotate(180deg);
        transition: transform 0.3s ease;
    }

    @media (min-width: 768px) {
        #mainContent {
            margin-left: 250px !important;
        }
    }
</style>