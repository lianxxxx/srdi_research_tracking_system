<?php
session_start();
require_once "../../controller/Main.php";

$db = new db();

// Redirect if not admin
if (!isset($_SESSION['user_id']) || strtolower($_SESSION['role']) !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
?>

<?php include('../../assets/partials/partial/header.php'); ?>
<?php include('../../assets/partials/partial/sidebar.php'); ?>
<?php include('../../assets/partials/partial/navbar.php'); ?>

<div id="main" class="main">
    <div class="main-container">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="rounded-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Activity Log</li>
                    </ol>
                </nav>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title py-2 text-center">Employees Activity Logs</h5>

                            <!-- Responsive table shifted right -->
                            <div class="table-responsive" style="max-width: 1000px; margin-left: auto; margin-right: 150px;">
                                <table class="table datatable table-striped table-hover w-100" id="datatable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Activities</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $logs = $db->getLogs();
                                        if ($logs && $logs->num_rows > 0) {
                                            while ($row = $logs->fetch_assoc()) {
                                                $name = htmlspecialchars(($row['first_name'] ?? '') . ' ' . ($row['last_name'] ?? ''));
                                                $activity = htmlspecialchars($row['activities'] ?? 'No Data');
                                                $created_at = isset($row['created_at']) ? date('F j, Y g:i A', strtotime($row['created_at'])) : 'No Date';
                                                echo "
                                                    <tr>
                                                        <td>{$name}</td>
                                                        <td>{$activity}</td>
                                                        <td>{$created_at}</td>
                                                    </tr>
                                                ";
                                            }
                                        } else {
                                            echo "<tr><td colspan='3' class='text-center'>No logs found</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- End table -->

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Include jQuery and DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
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
