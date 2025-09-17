<?php
session_start();
require_once "../../controller/Main.php";

// ✅ Check if logged in as researcher
if (!isset($_SESSION['user_id']) || strtolower($_SESSION['role']) !== 'researcher') {
    header("Location: ../auth/login.php");
    exit;
}

$db = new db();

// ✅ Get researcher full name (matches research_created_by column)
$me = $db->getUserById((int) $_SESSION['user_id']);
if (!$me) {
    session_unset();
    session_destroy();
    header("Location: ../auth/login.php");
    exit;
}

$researcherName = trim($me['first_name'] . ' ' . $me['last_name']);

// ✅ Fetch only this researcher’s approved research papers (with approver name)
$approvedPapers = $db->getApprovedCreatedby($researcherName);
?>

<?php include('../../assets/partials/researcherpartial/navbar.php'); ?>
<?php include('../../assets/partials/researcherpartial/header.php'); ?>
<?php include('../../assets/partials/researcherpartial/sidebar.php'); ?>

<div class="main-content" style="margin-left: 250px; min-height: 100vh; padding-bottom: 80px;">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-center mb-4">My Approved Research Papers</h5>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="datatable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Title</th>
                                        <th>Abstract</th>
                                        <th>Objective</th>
                                        <th>Members</th>
                                        <th>Approved By</th>
                                        <th>Approved At</th>
                                        <th>Research Paper</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($approvedPapers)): ?>
                                        <?php foreach ($approvedPapers as $paper): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($paper['research_title']); ?></td>
                                                <td><?= htmlspecialchars($paper['research_abstract']); ?></td>
                                                <td><?= htmlspecialchars($paper['research_objective']); ?></td>
                                                <td><?= htmlspecialchars($paper['research_members']); ?></td>
                                                <td><?= htmlspecialchars($paper['approved_by'] ?? 'Unknown'); ?></td>
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
                                            <td colspan="7" class="text-center text-muted">No approved research papers
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

<!-- ✅ jQuery + DataTables -->
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

<?php include('../../assets/partials/researcherpartial/footer.php'); ?>