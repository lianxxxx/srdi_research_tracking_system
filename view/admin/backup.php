<?php
session_start();
require_once "../../controller/Main.php";

// ------------------- AUTH CHECK -------------------
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$db = new db();
$me = $db->getUserById((int)$_SESSION['user_id']);
if (!$me) {
    // Invalid user in DB, clear session
    session_unset();
    session_destroy();
    header("Location: ../auth/login.php");
    exit;
}

// Refresh session values from DB
$_SESSION['role']          = strtolower($me['role']);
$_SESSION['user_fullname'] = trim($me['first_name'] . ' ' . $me['last_name']);

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// ------------------- BACKUP/RESTORE LOGIC -------------------
$message    = '';
$message1   = '';
$messageRed = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['backup'])) {
        // TODO: implement actual backup logic
        $backupSuccess = true; // <-- Replace with real logic

        if ($backupSuccess) {
            $message = "Backup completed successfully!";
        } else {
            $messageRed = "Backup failed! Please try again.";
        }
    }

    if (isset($_POST['restore'])) {
        // TODO: implement actual restore logic
        $restoreSuccess = true; // <-- Replace with real logic

        if ($restoreSuccess) {
            $message1 = "Database restored successfully!";
        } else {
            $messageRed = "Restore failed! Please try again.";
        }
    }
}
?>

<?php include('../../assets/partials/partial/header.php'); ?>
<?php include('../../assets/partials/partial/navbar.php'); ?>
<?php include('../../assets/partials/partial/sidebar.php'); ?>

<div class="main-content" style="margin-left: 250px; min-height: 100vh; padding-bottom: 80px;">
  <div class="container py-5">
    <div class="row justify-content-center gy-4">

      <!-- Backup -->
      <div class="col-lg-5 col-md-7 col-12">
        <div class="card shadow-sm">
          <div class="card-header bg-success text-white">
            <h5 class="mb-0">Backup Database</h5>
          </div>
          <div class="card-body">
            <?php if (!empty($message)) : ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($message) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>
            <?php if (!empty($messageRed)) : ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($messageRed) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>
            <p>Save your current database state to a backup file.</p>
            <form method="POST" class="d-grid">
              <button type="submit" name="backup" class="btn btn-success btn-lg">Backup Now</button>
            </form>
          </div>
        </div>
      </div>

      <!-- Restore -->
      <div class="col-lg-5 col-md-7 col-12">
        <div class="card shadow-sm">
          <div class="card-header bg-warning text-dark">
            <h5 class="mb-0">Restore Database</h5>
          </div>
          <div class="card-body">
            <?php if (!empty($message1)) : ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($message1) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>
            <?php if (!empty($messageRed)) : ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($messageRed) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>
            <p>This will restore the database from the most recent backup. This operation cannot be undone.</p>
            <form method="POST">
              <button
                type="button"
                class="btn btn-warning btn-lg w-100"
                data-bs-toggle="modal"
                data-bs-target="#restoreModal"
              >
                Restore Now
              </button>

              <!-- Modal -->
              <div class="modal fade" id="restoreModal" tabindex="-1" aria-labelledby="restoreModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header bg-warning">
                      <h5 class="modal-title" id="restoreModalLabel">Confirm Restore</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      Are you sure you want to restore the database? This will overwrite existing data.
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                      <button type="submit" name="restore" class="btn btn-primary">Yes, Restore</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Modal -->
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<?php include('../../assets/partials/partial/footer.php'); ?>
