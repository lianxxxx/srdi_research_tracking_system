<?php
session_start();
require_once '../../controller/Main.php';

$db = new db();

// Check if logged in
if (!isset($_SESSION['user_id']) || strtolower($_SESSION['role']) !== 'researcher') {
    header("Location: ../auth/login.php");
    exit;
}

// Get creator name
if (!isset($_SESSION['user_fullname'])) {
    $user = $db->getUserById($_SESSION['user_id']); // Make sure this method exists and returns user info
    $_SESSION['user_fullname'] = $user['first_name'] . ' ' . $user['last_name'];
}
$created_by = $_SESSION['user_fullname'];
$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['research_title'];
    $abstract = $_POST['research_abstract'];
    $objective = $_POST['research_objective'];
    $members = $_POST['research_members'];
    $file = $_FILES['research_pdf'];

    $result = $db->submitResearch(
        $title,
        $abstract,
        $objective,
        $members,
        $created_by,         
        $file,
        $_SESSION['user_id'] 
    );
    
    $message = $result['message'];
}
?>

<?php include('../../assets/partials/researcherpartial/header.php'); ?>
<?php include('../../assets/partials/researcherpartial/navbar.php'); ?>
<div class="container-fluid">
    <div class="row">
        <?php include('../../assets/partials/researcherpartial/sidebar.php'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
            <h3 class="mb-3">Submit Research Paper</h3>

            <?php if ($message): ?>
                <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Research Title</label>
                    <input type="text" name="research_title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Abstract</label>
                    <textarea name="research_abstract" class="form-control" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Objective</label>
                    <textarea name="research_objective" class="form-control" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Research Members</label>
                    <input type="text" name="research_members" class="form-control" >
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload PDF</label>
                    <input type="file" name="research_pdf" class="form-control" accept="application/pdf" required>
                </div>

                <button type="submit" class="btn btn-primary">Submit Research</button>
            </form>
        </main>
    </div>
</div>

<?php include('../../assets/partials/researcherpartial/footer.php'); ?>
