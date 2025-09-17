<?php
session_start();
require_once '../../controller/Main.php';

$db = new db();

// Check if user is logged in and is executive director
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'executive_director') {
    header("Location: ../auth/login.php");
    exit;
}

// Get user full name if not already stored
if (!isset($_SESSION['user_fullname'])) {
    $user = $db->getUserById($_SESSION['user_id']);
    $_SESSION['user_fullname'] = $user['first_name'] . ' ' . $user['last_name'];
}

// $creatorId = $_SESSION['user_id'];
// $researchPapers = $db->getResearchPapersByCreatorId($creatorId);
?>

<?php include('../../assets/partials/executivepartial/header.php'); ?>
<?php include('../../assets/partials/executivepartial/navbar.php'); ?>
<?php include('../../assets/partials/executivepartial/sidebar.php'); ?>
<?php include('../../assets/partials/executivepartial/footer.php'); ?>
<div id="main" class="main">
    <div class="main-container">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="rounded-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Executive Director</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Research Papers</li>
                    </ol>
                </nav>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title py-2 text-center">My Submitted Research Papers</h5>

                            <div class="table-responsive">
                                <table class="table datatable table-striped table-hover w-100" id="datatable">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Status</th>
                                            <th>Members</th>
                                            <th>Submitted At</th>
                                            <th>Research Paper</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($researchPapers)): ?>
                                            <?php foreach ($researchPapers as $paper): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($paper['research_title']) ?></td>
                                                    <td><?= htmlspecialchars($paper['research_status']) ?></td>
                                                    <td><?= htmlspecialchars($paper['research_members']) ?></td>
                                                    <td><?= date('F j, Y g:i A', strtotime($paper['created_at'])) ?></td>
                                                    <td>
                                                        <a href="/srdi_system/assets/researchPaper/<?= urlencode($paper['pdf_filename']) ?>"
                                                            target="_blank">View Research</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center">No research papers found.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

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
