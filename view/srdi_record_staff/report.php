<?php
session_start();
require_once "../../controller/Main.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$db = new db();

// Always refresh identity from DB to avoid stale/wrong session data
$me = $db->getUserById((int)$_SESSION['user_id']);
if (!$me) {
    // user id no longer valid
    session_unset();
    session_destroy();
    header("Location: ../auth/login.php");
    exit;
}

// Normalize/refresh session from DB (authoritative)
$_SESSION['role']          = strtolower($me['role']);
$_SESSION['user_fullname'] = trim($me['first_name'].' '.$me['last_name']);

if ($_SESSION['role'] !== 'srdi_record_staff') {
    header("Location: ../auth/login.php");
    exit;
}
// Get research papers by creator
$researchPapers = $db->getResearchPapersByCreator($creatorName);
?>

<?php include('../../assets/partials/srdirecordpartial/header.php'); ?>
<?php include('../../assets/partials/srdirecordpartial/navbar.php'); ?>
<?php include('../../assets/partials/srdirecordpartial/sidebar.php'); ?>

<div id="main" class="main">
    <div class="main-container">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="rounded-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Researcher</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Published Reports</li>
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

                            <div class="table-responsive" style="max-width: 1000px; margin-left: auto; margin-right: 150px;">
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
                                        <?php if (!empty($researchPapers)) : ?>
                                            <?php foreach ($researchPapers as $paper) : ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($paper['research_title']) ?></td>
                                                    <td><?= htmlspecialchars($paper['research_status']) ?></td>
                                                    <td><?= htmlspecialchars($paper['research_members']) ?></td>
                                                    <td><?= date('F j, Y g:i A', strtotime($paper['created_at'])) ?></td>
                                                    <td>
                                                    <a href="/srdi_system/assets/researchPaper/<?= urlencode($paper['pdf_filename']) ?>" target="_blank">View Research</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
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

<!-- Include jQuery and DataTables -->

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

<?php include('../../assets/partials/srdirecordpartial/footer.php'); ?>
