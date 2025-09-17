<?php
session_start();
require_once "../../controller/Main.php";

if (!isset($_SESSION['user_id']) || strtolower($_SESSION['role']) !== 'researcher') {
    header("Location: ../auth/login.php");
    exit;
}

$db = new db();

// Handle update action (Cancel)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $id = (int) $_POST['id'];
    $status = $_POST['research_status'];

    if ($db->updateResearchStatus($id, $status, $_SESSION['user_id'])) {
        $_SESSION['message'] = "Research status updated to <b>$status</b>!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Failed to update research paper.";
        $_SESSION['message_type'] = "danger";
    }

    header("Location: researchPending.php");
    exit;
}

// ✅ Fetch only papers created by this researcher using user_id
$pendingPapers = $db->getPendingResearchPapersByUserId($_SESSION['user_id']);
?>

<?php include('../../assets/partials/researcherpartial/navbar.php'); ?>
<?php include('../../assets/partials/researcherpartial/header.php'); ?>
<?php include('../../assets/partials/researcherpartial/sidebar.php'); ?>
<?php include('../../assets/partials/researcherpartial/footer.php'); ?>

<div class="main-content" style="margin-left: 250px; min-height: 100vh; padding-bottom: 80px;">
    <div class="container py-5">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['message_type'] ?? 'info'; ?> alert-dismissible fade show text-center"
                 role="alert">
                <?= $_SESSION['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-center mb-4">My Pending Research Papers</h5>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="datatable">
                                <thead class="table-warning">
                                <tr>
                                    <th>Title</th>
                                    <th>Abstract</th>
                                    <th>Objective</th>
                                    <th>Members</th>
                                    <th>Submitted At</th>
                                    <th>Research Paper</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($pendingPapers)): ?>
                                    <?php foreach ($pendingPapers as $paper): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($paper['research_title']); ?></td>
                                            <td><?= htmlspecialchars($paper['research_abstract']); ?></td>
                                            <td><?= htmlspecialchars($paper['research_objective']); ?></td>
                                            <td><?= htmlspecialchars($paper['research_members']); ?></td>
                                            <td><?= date('F j, Y g:i A', strtotime($paper['created_at'])); ?></td>
                                            <td>
                                                <?php if (!empty($paper['pdf_filename'])): ?>
                                                    <a href="/srdi_system/assets/researchPaper/<?= urlencode($paper['pdf_filename']); ?>"
                                                       target="_blank" class="btn btn-sm btn-primary">View PDF</a>
                                                <?php else: ?>
                                                    <span class="text-muted">No file</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <!-- Cancel Form -->
                                                <form action="" method="POST" style="display:inline-block;">
                                                    <input type="hidden" name="id" value="<?= $paper['id']; ?>">
                                                    <input type="hidden" name="research_status" value="Cancelled">
                                                    <button type="submit" name="update_status" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to cancel this research paper?');">
                                                        Cancel
                                                    </button>
                                                </form>

                                                <!-- Edit -->
                                                <a href="editPending.php?id=<?= $paper['id']; ?>"
                                                   class="btn btn-sm btn-warning">Edit</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No pending research papers found.</td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery + DataTables -->
<script>
    $(document).ready(function () {
        $('#datatable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthChange: true,
            pageLength: 10
        });
    });
</script>
