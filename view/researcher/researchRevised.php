<?php
session_start();
require_once "../../controller/Main.php";

if (!isset($_SESSION['user_id']) || strtolower($_SESSION['role']) !== 'researcher') {
    header("Location: ../auth/login.php");
    exit;
}

$db = new db();

// ✅ Fetch revised research papers only by this user (using user_id)
$revisedPapers = $db->getRevisedResearchPapersByUser($_SESSION['user_id']);
?>

<?php include('../../assets/partials/researcherpartial/header.php'); ?>
<?php include('../../assets/partials/researcherpartial/navbar.php'); ?>
<div class="container-fluid">
    <div class="row">
        <?php include('../../assets/partials/researcherpartial/sidebar.php'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-<?= $_SESSION['message_type'] ?? 'info'; ?> alert-dismissible fade show text-center" role="alert">
                    <?= $_SESSION['message']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
            <?php endif; ?>

            <h3 class="mb-3 text-info">Revised Research Papers</h3>

            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="datatable">
                            <thead class="table-info">
                                <tr>
                                    <th>Title</th>
                                    <th>Abstract</th>
                                    <th>Objective</th>
                                    <th>Members</th>
                                    <th>Revised At</th>
                                    <th>Research Paper</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($revisedPapers)): ?>
                                    <?php foreach ($revisedPapers as $paper): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($paper['research_title']); ?></td>
                                            <td><?= htmlspecialchars($paper['research_abstract']); ?></td>
                                            <td><?= htmlspecialchars($paper['research_objective']); ?></td>
                                            <td><?= htmlspecialchars($paper['research_members']); ?></td>
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
                                            <td>
                                                <a href="editRevised.php?id=<?= $paper['id']; ?>" 
                                                   class="btn btn-sm btn-warning">Edit</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No revised research papers found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include('../../assets/partials/researcherpartial/footer.php'); ?>

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
