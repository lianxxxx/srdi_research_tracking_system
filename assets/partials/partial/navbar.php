<?php

require_once '../../controller/Main.php';

$db = new db();

?>
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top border-bottom">
    <div class="container-fluid">
        <div class="d-flex align-items-center ms-auto">
            <div class="dropdown me-3">
                <a class="text-decoration-none text-dark position-relative" href="#" role="button"
                    data-bs-toggle="dropdown">
                    <i class="bi bi-bell fs-5"></i>
                    <span
                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">!</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">No new notifications</a></li>
                </ul>
            </div>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                    data-bs-toggle="dropdown">
                    <!-- <img src="/srdi_system/assets/images/profile.jpg" class="rounded-circle me-2" width="40" height="40" alt="User"> -->
                    <strong><?php echo htmlspecialchars($_SESSION['user_fullname']); ?></strong>
                </a>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item text-danger" href="/srdi_system/view/auth/login.php"
                            onclick="return confirmLogout();">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<script>
    function confirmLogout() {
        return confirm('Are you sure you want to logout?');
    }
</script>