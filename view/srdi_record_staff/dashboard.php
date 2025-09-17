<?php
session_start();
require_once "../../controller/Main.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$db = new db();
$me = $db->getUserById((int) $_SESSION['user_id']);
if (!$me) {
    session_unset();
    session_destroy();
    header("Location: ../auth/login.php");
    exit;
}

$_SESSION['role'] = strtolower($me['role']);
$_SESSION['user_fullname'] = trim($me['first_name'] . ' ' . $me['last_name']);

if ($_SESSION['role'] !== 'srdi_record_staff') {
    header("Location: ../auth/login.php");
    exit;
}
$selectedYear = isset($_GET['year']) ? (int) $_GET['year'] : date('Y');
$monthlyStats = $db->getResearchStatsByMonth($selectedYear);
$yearlyStats = $db->getAllResearchStatsByYear();
$topResearchers = $db->getAllTopResearchers($selectedYear);
$availableYears = $db->getAvailableYears();
?>

<?php include('../../assets/partials/srdirecordpartial/header.php'); ?>
<?php include('../../assets/partials/srdirecordpartial/navbar.php'); ?>
<?php include('../../assets/partials/srdirecordpartial/sidebar.php'); ?>

<div class="main-content" style="margin-left: 250px; min-height: 100vh; padding-bottom: 80px;">
    <div class="container py-5">
        <div class="row">

            <!-- Monthly Stats -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title">Publications Per Month (<?= $selectedYear; ?>)</h5>
                            <form method="get" id="yearFilterForm">
                                <select name="year" class="form-select form-select-sm"
                                    onchange="document.getElementById('yearFilterForm').submit();">
                                    <?php foreach ($availableYears as $year): ?>
                                        <option value="<?= $year; ?>" <?= ($year == $selectedYear) ? 'selected' : ''; ?>>
                                            <?= $year; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </form>
                        </div>
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Yearly Stats -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Publications Per Year</h5>
                        <canvas id="yearlyChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Top Researchers -->
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Researchers & Status</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="researcherTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Researcher</th>
                                        <th>Status</th>
                                        <th>Research Title</th>
                                        <th>Submitted At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $researchers = $db->getResearchersWithStatuses();
                                    if (!empty($researchers)):
                                        foreach ($researchers as $row): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row['research_created_by']); ?></td>
                                                <td><?= htmlspecialchars($row['research_status']); ?></td>
                                                <td><?= htmlspecialchars($row['research_title']); ?></td>
                                                <td><?= date('F j, Y g:i A', strtotime($row['created_at'])); ?></td>
                                            </tr>
                                        <?php endforeach;
                                    else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No research records found.</td>
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

<!-- Charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Monthly Stats
    const monthlyData = <?= json_encode(array_values($monthlyStats)); ?>;
    const monthlyChart = new Chart(document.getElementById('monthlyChart'), {
        type: 'bar',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "Publications",
                data: monthlyData,
                backgroundColor: "rgba(54, 162, 235, 0.7)"
            }]
        }
    });

    // Yearly Stats
    const yearlyData = <?= json_encode(array_values($yearlyStats)); ?>;
    const yearlyLabels = <?= json_encode(array_keys($yearlyStats)); ?>;
    const yearlyChart = new Chart(document.getElementById('yearlyChart'), {
        type: 'line',
        data: {
            labels: yearlyLabels,
            datasets: [{
                label: "Publications",
                data: yearlyData,
                fill: false,
                borderColor: "rgba(255, 99, 132, 0.8)",
                tension: 0.1
            }]
        }
    });
</script>

<?php include('../../assets/partials/srdirecordpartial/footer.php'); ?>
