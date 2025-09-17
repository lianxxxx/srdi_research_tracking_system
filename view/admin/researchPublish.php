<?php
session_start();
require_once "../../controller/Main.php";

if (!isset($_SESSION['user_id']) || strtolower($_SESSION['role']) !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$db = new db();

// Handle update action
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

    header("Location: researchPublish.php");
    exit;
}

// Fetch published research papers
$publishedPapers = $db->getPublishedResearchPapers();
?>

<?php include('../../assets/partials/partial/header.php'); ?>
<?php include('../../assets/partials/partial/navbar.php'); ?>
<?php include('../../assets/partials/partial/sidebar.php'); ?>

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
                        <h5 class="card-title text-center mb-4">Published Research Papers</h5>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="datatable">
                                <thead class="table-success">
                                    <tr>
                                        <th>Title</th>
                                        <th>Abstract</th>
                                        <th>Objective</th>
                                        <th>Members</th>
                                        <th>Created By</th>
                                        <th>Published At</th>
                                        <th>Research Paper</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($publishedPapers)): ?>
                                        <?php foreach ($publishedPapers as $paper): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($paper['research_title']); ?></td>
                                                <td><?= htmlspecialchars($paper['research_abstract']); ?></td>
                                                <td><?= htmlspecialchars($paper['research_objective']); ?></td>
                                                <td><?= htmlspecialchars($paper['research_members']); ?></td>
                                                <td><?= htmlspecialchars($paper['research_created_by']); ?></td>
                                                <td><?= date('F j, Y g:i A', strtotime($paper['created_at'])); ?></td>
                                                <td>
                                                    <?php if (!empty($paper['pdf_filename'])): ?>
                                                        <a href="/srdi_system/assets/researchPaper/<?= urlencode($paper['pdf_filename']); ?>"
                                                            target="_blank" class="btn btn-sm btn-primary">
                                                            View PDF
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-muted">No file</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <form method="POST" class="d-flex gap-1">
                                                        <input type="hidden" name="id" value="<?= $paper['id']; ?>">
                                                        <select name="research_status" class="form-select form-select-sm"
                                                            required>
                                                            <option value="Pending">Mark as Pending</option>
                                                            <option value="Approved">Approve</option>
                                                            <option value="Declined">Decline</option>
                                                            <option value="Cancelled">Cancel</option>
                                                            <option value="Revised">Mark as Revised</option>
                                                        </select>
                                                        <button type="submit" name="update_status"
                                                            class="btn btn-sm btn-warning">Update</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">No published research papers
                                                found.</td>
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

<?php include('../../assets/partials/partial/footer.php'); ?>