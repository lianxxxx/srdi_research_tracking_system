<?php
session_start();
require_once "../../controller/Main.php";

if (!isset($_SESSION['user_id']) || strtolower($_SESSION['role']) !== 'researcher') {
    header("Location: ../auth/login.php");
    exit;
}

$db = new db();

// ✅ Validate paper ID from URL
if (!isset($_GET['id'])) {
    $_SESSION['message'] = "Invalid request. No paper selected.";
    $_SESSION['message_type'] = "danger";
    header("Location: researchPending.php");
    exit;
}

$id = (int) $_GET['id'];

// ✅ Fetch the paper owned by this user
$paper = $db->getResearchPaperByIdAndUser($id, $_SESSION['user_id']);

if (!$paper || $paper['research_status'] !== 'Pending') {
    $_SESSION['message'] = "Unauthorized access or paper not found.";
    $_SESSION['message_type'] = "danger";
    header("Location: researchPending.php");
    exit;
}

// ✅ Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['research_title'];
    $abstract = $_POST['research_abstract'];
    $objective = $_POST['research_objective'];
    $members = $_POST['research_members'];

    // Keep current PDF unless replaced
    $pdf_filename = $paper['pdf_filename'];
    if (!empty($_FILES['pdf_file']['name'])) {
        $targetDir = "../../assets/researchPaper/";
        $pdf_filename = time() . "_" . basename($_FILES['pdf_file']['name']);
        move_uploaded_file($_FILES['pdf_file']['tmp_name'], $targetDir . $pdf_filename);
    }

    if ($db->updatePendingResearchPaper($id, $title, $abstract, $objective, $members, $pdf_filename)) {
        $_SESSION['message'] = "Research paper updated successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Failed to update research paper.";
        $_SESSION['message_type'] = "danger";
    }

    header("Location: researchPending.php");
    exit;
}
?>

<?php include('../../assets/partials/researcherpartial/header.php'); ?>
<?php include('../../assets/partials/researcherpartial/navbar.php'); ?>
<div class="container-fluid">
    <div class="row">
        <?php include('../../assets/partials/researcherpartial/sidebar.php'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
            <h3 class="mb-3">Edit Pending Research Paper</h3>

            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-<?= $_SESSION['message_type'] ?? 'info' ?>">
                    <?= $_SESSION['message']; ?>
                </div>
                <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Research Title</label>
                    <input type="text" name="research_title" class="form-control"
                           value="<?= htmlspecialchars($paper['research_title']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Abstract</label>
                    <textarea name="research_abstract" class="form-control" required><?= htmlspecialchars($paper['research_abstract']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Objective</label>
                    <textarea name="research_objective" class="form-control" required><?= htmlspecialchars($paper['research_objective']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Research Members</label>
                    <input type="text" name="research_members" class="form-control"
                           value="<?= htmlspecialchars($paper['research_members']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload New PDF</label>
                    <input type="file" name="pdf_file" class="form-control" accept="application/pdf">
                    <?php if (!empty($paper['pdf_filename'])): ?>
                        <small class="text-muted">Current file: <?= htmlspecialchars($paper['pdf_filename']); ?></small>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-success">Update Paper</button>
                <a href="researchPending.php" class="btn btn-secondary">Cancel</a>
            </form>
        </main>
    </div>
</div>

<?php include('../../assets/partials/researcherpartial/footer.php'); ?>
