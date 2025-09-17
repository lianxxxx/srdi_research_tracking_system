<?php
session_start();
require_once "../../controller/Main.php";

if (!isset($_SESSION['user_id']) || strtolower($_SESSION['role']) !== 'section_head') {
    header("Location: ../auth/login.php");
    exit;
}

$db = new db();

// Fetch approved research papers
$approvedPapers = $db->getApprovedResearchPapers();
?>

<?php include('../../assets/partials/sectionpartial/header.php'); ?>
<?php include('../../assets/partials/sectionpartial/navbar.php'); ?>
<?php include('../../assets/partials/sectionpartial/sidebar.php'); ?>

<!-- Main page content goes here -->

<?php include('../../assets/partials/sectionpartial/footer.php'); ?>

<div class="main-content" style="margin-left: 250px; min-height: 100vh; padding-bottom: 80px;">
  <div class="container py-5">
    <div class="row">
      <div class="col-lg-12">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title text-center mb-4">Approved Research Papers</h5>

            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover" id="datatable">
                <thead class="table-dark">
                  <tr>
                    <th>Title</th>
                    <th>Abstract</th>
                    <th>Objective</th>
                    <th>Members</th>
                    <th>Created By</th>
                    <th>Approved By</th>
                    <th>Approved At</th>
                    <th>Research Paper</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($approvedPapers)) : ?>
                    <?php foreach ($approvedPapers as $paper) : ?>
                      <tr>
                        <td><?= htmlspecialchars($paper['research_title']); ?></td>
                        <td><?= htmlspecialchars($paper['research_abstract']); ?></td>
                        <td><?= htmlspecialchars($paper['research_objective']); ?></td>
                        <td><?= htmlspecialchars($paper['research_members']); ?></td>
                        <td><?= htmlspecialchars($paper['research_created_by']); ?></td>
                        <td><?= htmlspecialchars($paper['approved_by'] ?: 'System'); ?></td>
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
                          <?php if ($paper['research_status'] !== 'Publish'): ?>
                            <a href="researchApproved.php?id=<?= $paper['id']; ?>" 
                               class="btn btn-sm btn-success"
                               onclick="return confirm('Are you sure you want to approve/publish this research paper?');">
                               Approve
                            </a>
                          <?php else: ?>
                            <span class="badge bg-success">Approved</span>
                          <?php endif; ?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="9" class="text-center text-muted">No approved research papers found.</td>
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


