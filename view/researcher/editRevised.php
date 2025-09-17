<?php
session_start();
require_once "../../controller/Main.php";

if (!isset($_SESSION['user_id']) || strtolower($_SESSION['role']) !== 'researcher') {
    header("Location: ../auth/login.php");
    exit;
}

$db = new db();

// ✅ Validate paper ID
if (!isset($_GET['id'])) {
    header("Location: researchRevised.php");
    exit;
}

$id = (int) $_GET['id'];
$paper = $db->getResearchPaperById($id);

// ✅ Check ownership with user_id (cast to int to avoid type issues)
if (!$paper || (int)$paper['research_created_by_user_id'] !== (int)$_SESSION['user_id']) {
    $_SESSION['message'] = "Unauthorized access or paper not found.";
    $_SESSION['message_type'] = "danger";
    header("Location: researchRevised.php");
    exit;
}

// ✅ Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['research_title']);
    $abstract = trim($_POST['research_abstract']);
    $objective = trim($_POST['research_objective']);
    $members = trim($_POST['research_members']);

    // Handle PDF upload
    $pdf_filename = $paper['pdf_filename']; // keep existing by default
    if (!empty($_FILES['pdf_file']['name'])) {
        $targetDir = "../../assets/researchPaper/";
        $pdf_filename = time() . "_" . basename($_FILES['pdf_file']['name']);
        move_uploaded_file($_FILES['pdf_file']['tmp_name'], $targetDir . $pdf_filename);
    }

    if ($db->updateRevisedResearchPaper($id, $title, $abstract, $objective, $members, $pdf_filename, $_SESSION['user_id'])) {
        $_SESSION['message'] = "Research paper updated successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Failed to update research paper.";
        $_SESSION['message_type'] = "danger";
    }

    header("Location: researchRevised.php");
    exit;
}
?>

<?php include('../../assets/partials/researcherpartial/header.php'); ?>
<?php include('../../assets/partials/researcherpartial/navbar.php'); ?>
<div class="container-fluid">
    <div class="row">
        <?php include('../../assets/partials/researcherpartial/sidebar.php'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
            <h3 class="mb-4">Edit Revised Research Paper</h3>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Title</label>
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
                    <label class="form-label">Members</label>
                    <input type="text" name="research_members" class="form-control"
                        value="<?= htmlspecialchars($paper['research_members']); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Upload Revised PDF</label>
                    <input type="file" name="pdf_file" class="form-control">
                    <?php if (!empty($paper['pdf_filename'])): ?>
                        <small>Current file: <?= htmlspecialchars($paper['pdf_filename']); ?></small>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-success">Update Paper</button>
                <a href="researchRevised.php" class="btn btn-secondary">Cancel</a>
            </form>
        </main>
    </div>
</div>

<?php include('../../assets/partials/researcherpartial/footer.php'); ?>
