<?php
session_start();
require_once "../../controller/Main.php";

if (!isset($_SESSION['user_id']) || strtolower($_SESSION['role']) !== 'researcher') {
    header("Location: ../auth/login.php");
    exit;
}

$db = new db();

// ✅ Fetch only rejected research papers for the logged-in researcher (by name)
$rejectedPapers = $db->getRejectedResearchPapersByUser($_SESSION['user_fullname']);
?>

<?php include('../../assets/partials/researcherpartial/navbar.php'); ?>
<?php include('../../assets/partials/researcherpartial/header.php'); ?>
<?php include('../../assets/partials/researcherpartial/sidebar.php'); ?>
<?php include('../../assets/partials/researcherpartial/footer.php'); ?>

<div class="main-content" style="margin-left: 250px; min-height: 100vh; padding-bottom: 80px;">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-center mb-4 text-danger">Rejected Research Papers</h5>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="datatable">
                                <thead class="table-danger">
                                    <tr>
                                        <th>Title</th>
                                        <th>Abstract</th>
                                        <th>Objective</th>
                                        <th>Members</th>
                                        <th>Created By</th>
                                        <th>Rejected At</th>
                                        <th>Research Paper</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($rejectedPapers)): ?>
                                        <?php foreach ($rejectedPapers as $paper): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($paper['research_title']); ?></td>
                                                <td><?= htmlspecialchars($paper['research_abstract']); ?></td>
                                                <td><?= htmlspecialchars($paper['research_objective']); ?></td>
                                                <td><?= htmlspecialchars($paper['research_members']); ?></td>
                                                <td><?= htmlspecialchars($paper['research_created_by']); ?></td>
                                                <td><?= date('F j, Y g:i A', strtotime($paper['updated_at'])); ?></td>
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
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">
                                                No rejected research papers found.
                                            </td>
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
