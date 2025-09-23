<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

class db
{
    private $con;

    public function __construct()
    {
        $this->con = mysqli_connect('localhost', 'root', '', 'srdi');
        if (!$this->con) {
            die("Database connection failed: " . mysqli_connect_error());
        }
    }

    // Get database connection
    public function getConnection()
    {
        return $this->con;
    }

    // Check if email exists in employees table
    public function isEmailExists($email)
    {
        $email = $this->con->real_escape_string($email);
        $query = "SELECT email FROM employees WHERE email = '$email' LIMIT 1";
        $result = $this->con->query($query);
        if (!$result) {
            die("Query Failed: " . $this->con->error);
        }
        return $result->num_rows > 0;
    }

    // Register new user
    public function registerUser($first_name, $middle_name, $last_name, $email, $password, $role, $permanent_address)
    {
        $first_name = $this->con->real_escape_string($first_name);
        $middle_name = $this->con->real_escape_string($middle_name);
        $last_name = $this->con->real_escape_string($last_name);
        $email = $this->con->real_escape_string($email);
        $role = $this->con->real_escape_string($role);
        $permanent_address = $this->con->real_escape_string($permanent_address);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->con->prepare("INSERT INTO employees (first_name, middle_name, last_name, permanent_address, email, password, role, status) VALUES (?, ?, ?, ?, ?, ?, ?, 1)");
        $stmt->bind_param("sssssss", $first_name, $middle_name, $last_name, $permanent_address, $email, $hashedPassword, $role);

        $success = $stmt->execute();

        // Log registration if successful
        if ($success) {
            $userId = $this->con->insert_id;
            $this->insertLog($userId, 'User registered');
        }

        return $success;
    }


    // Login check
    public function checkUsers($email, $password)
    {
        $email = $this->con->real_escape_string($email);
        $query = "SELECT * FROM employees WHERE email = '$email'";
        $result = $this->con->query($query);

        if (!$result) {
            die("Query Failed: " . $this->con->error);
        }

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                if ((int) $user['status'] === 1) {
                    $this->insertLog($user['id'], 'User logged in');
                    return $user;
                } else {
                    return 'Account is inactive.';
                }
            } else {
                return 'Incorrect password.';
            }
        } else {
            return 'User not found.';
        }
    }


    // Insert activity log
    public function insertLog($user_id, $activity)
    {
        $user_id = (int) $user_id;
        $activity = $this->con->real_escape_string($activity);

        $stmt = $this->con->prepare("INSERT INTO activity_logs (activities, user_id) VALUES (?, ?)");
        $stmt->bind_param("si", $activity, $user_id);
        return $stmt->execute();
    }

    // Update password
    public function updatePassword($email, $newPassword)
    {
        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);

        // Get user ID
        $stmtUser = $this->con->prepare("SELECT id FROM employees WHERE email = ?");
        $stmtUser->bind_param("s", $email);
        $stmtUser->execute();
        $result = $stmtUser->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $userId = $user['id'];

            // Update password
            $stmt = $this->con->prepare("UPDATE employees SET password = ? WHERE email = ?");
            $stmt->bind_param("ss", $hashed, $email);
            $success = $stmt->execute();

            // Log the password update
            if ($success) {
                $this->insertLog($userId, 'Password updated');
            }

            return $success;
        }

        return false;
    }

    // Get all activity logs
    public function getLogs()
    {
        $query = "
            SELECT 
                activity_logs.activities, 
                activity_logs.created_at, 
                employees.first_name, 
                employees.last_name
            FROM activity_logs
            LEFT JOIN employees ON activity_logs.user_id = employees.id
            ORDER BY activity_logs.created_at DESC
        ";

        $result = $this->con->query($query);
        if (!$result) {
            die("Query Failed: " . $this->con->error);
        }

        return $result;
    }
    // create research
    public function submitResearch($title, $abstract, $objective, $members, $created_by, $file, $user_id)
    {
        // Upload path
        $upload_dir = __DIR__ . '/../assets/researchPaper/';
        $filename = time() . "_" . basename($file['name']); // unique filename
        $target_file = $upload_dir . $filename;
        $filetype = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        // Validate file type
        if ($filetype !== 'pdf') {
            return ['success' => false, 'message' => 'Only PDF files are allowed.'];
        }

        // Create directory if not exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Upload file
        if (!move_uploaded_file($file['tmp_name'], $target_file)) {
            return ['success' => false, 'message' => 'File upload failed.'];
        }

        //  Insert record into database
        $stmt = $this->con->prepare("
            INSERT INTO research_papers (
                research_title, research_abstract, research_objective, research_members, 
                research_created_by, research_created_by_user_id, research_status, 
                pdf_filename, created_at, updated_at
            ) VALUES (?, ?, ?, ?, ?, ?, 'Pending', ?, NOW(), NOW())
        ");

        $stmt->bind_param(
            "sssssis",
            $title,
            $abstract,
            $objective,
            $members,
            $created_by,
            $user_id,
            $filename
        );

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Research submitted successfully!'];
        } else {
            return ['success' => false, 'message' => 'Database insertion failed: ' . $stmt->error];
        }
    }

    public function getUserById($id): ?array
    {
        $id = (int) $id;
        $sql = "SELECT id, first_name, middle_name, last_name, email, role, status, created_at, updated_at
                FROM employees
                WHERE id = ? LIMIT 1";
        $stmt = $this->con->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->con->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res && $res->num_rows ? $res->fetch_assoc() : null;
    }


    public function getResearchPapersByCreator($creatorName)
    {
        $creatorName = $this->con->real_escape_string($creatorName);

        $query = "SELECT * FROM research_papers WHERE research_created_by = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("s", $creatorName);
        $stmt->execute();

        $result = $stmt->get_result();
        $papers = [];

        while ($row = $result->fetch_assoc()) {
            $papers[] = $row;
        }

        return $papers;
    }
    public function getResearchPapersByCreatorId($userId)
    {
        $userId = (int) $userId;
        $query = "SELECT * FROM research_papers WHERE created_by = $userId ORDER BY created_at DESC";
        $result = $this->con->query($query);

        $papers = [];
        while ($row = $result->fetch_assoc()) {
            $papers[] = $row;
        }
        return $papers;
    }
    public function getApprovedResearchPapers()
    {
        $query = "
        SELECT rp.*, 
               u.first_name, u.middle_name, u.last_name, u.role 
        FROM research_papers rp
        LEFT JOIN employees u ON rp.research_recieved_by = u.id
        WHERE rp.research_status = 'Approved'
        ORDER BY rp.created_at DESC
    ";

        $result = $this->con->query($query);

        if (!$result) {
            die("Query Failed: " . $this->con->error);
        }

        $papers = [];
        while ($row = $result->fetch_assoc()) {
            // Build approver full name
            $row['approved_by'] = trim(
                $row['first_name'] . ' ' .
                ($row['middle_name'] ? $row['middle_name'] . ' ' : '') .
                $row['last_name']
            );

            $papers[] = $row;
        }

        return $papers;
    }


    public function getCancelledResearchPapers()
    {
        $query = "SELECT * FROM research_papers WHERE research_status = 'Cancelled' ORDER BY created_at DESC";
        $result = $this->con->query($query);

        if (!$result) {
            die("Query Failed: " . $this->con->error);
        }

        $papers = [];
        while ($row = $result->fetch_assoc()) {
            $papers[] = $row;
        }

        return $papers;
    }
    public function getPendingResearchPapers()
    {
        $query = "SELECT * FROM research_papers WHERE research_status = 'Pending' ORDER BY created_at DESC";
        $result = $this->con->query($query);

        if (!$result) {
            die("Query Failed: " . $this->con->error);
        }

        $papers = [];
        while ($row = $result->fetch_assoc()) {
            $papers[] = $row;
        }

        return $papers;
    }
    public function getRejectedResearchPapers()
    {
        $query = "SELECT * FROM research_papers WHERE research_status = 'Declined' ORDER BY created_at DESC";
        $result = $this->con->query($query);

        if (!$result) {
            die("Query Failed: " . $this->con->error);
        }

        $papers = [];
        while ($row = $result->fetch_assoc()) {
            $papers[] = $row;
        }

        return $papers;
    }
    public function getRevisedResearchPapers()
    {
        $query = "SELECT * FROM research_papers WHERE research_status = 'Revised' ORDER BY created_at DESC";
        $result = $this->con->query($query);

        if (!$result) {
            die("Query Failed: " . $this->con->error);
        }

        $papers = [];
        while ($row = $result->fetch_assoc()) {
            $papers[] = $row;
        }

        return $papers;
    }
    // Get all Published research papers
    public function getPublishedResearchPapers()
    {
        $query = "
        SELECT *
        FROM research_papers
        WHERE research_status = 'Publish'
        ORDER BY created_at DESC
    ";
        $result = $this->con->query($query);

        $papers = [];
        while ($row = $result->fetch_assoc()) {
            $papers[] = $row;
        }
        return $papers;
    }

    // Inside Main.php class
    public function updateResearchStatus($id, $status, $user_id)
    {
        $id = (int) $id;
        $status = $this->con->real_escape_string($status);
    
        // 🔹 Executive Director auto-publishes
        $user = $this->getUserById((int) $user_id);
        if ($user && strtolower($user['role']) === 'executive_director' && $status === 'Approved') {
            $status = 'Publish';
        }
    
        // 🔹 Fetch current approvers
        $stmt = $this->con->prepare("SELECT research_recieved_by FROM research_papers WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
    
        $current = $result ? $result['research_recieved_by'] : "";
        $approvers = array_filter(explode(",", $current)); // existing IDs
    
        if (!in_array($user_id, $approvers)) {
            $approvers[] = $user_id; // add new approver
        }
    
        $approversStr = implode(",", $approvers);
    
        // 🔹 Update with string (✅ FIXED: bind_param uses "ssi" → first is status(string), second is approversStr(string), third is id(int))
        $stmt = $this->con->prepare("
            UPDATE research_papers 
            SET research_status = ?, updated_at = NOW(), research_recieved_by = ? 
            WHERE id = ?
        ");
        $stmt->bind_param("ssi", $status, $approversStr, $id);
    
        $success = $stmt->execute();
    
        if ($success) {
            $this->insertLog($user_id, "Updated research paper #$id status to $status (approvers: $approversStr)");
        }
    
        return $success;
    }
    
    




    // Count research papers grouped by month (current year)
    // Publications grouped by month in a given year
    public function getResearchStatsByMonth($year = null)
    {
        $year = (int) ($year ?? date('Y'));
        $query = "
        SELECT MONTH(created_at) AS month, COUNT(*) AS total
        FROM research_papers
        WHERE research_status = 'Publish' 
          AND YEAR(created_at) = $year
        GROUP BY MONTH(created_at)
        ORDER BY MONTH(created_at)
    ";
        $result = $this->con->query($query);

        $stats = array_fill(1, 12, 0); // Jan–Dec
        while ($row = $result->fetch_assoc()) {
            $stats[(int) $row['month']] = (int) $row['total'];
        }
        return $stats;
    }

    // Publications grouped by year (filtered if year provided)
    public function getResearchStatsByYear($year = null)
    {
        if ($year) {
            // only return this year
            $query = "
            SELECT YEAR(created_at) AS year, COUNT(*) AS total
            FROM research_papers
            WHERE research_status = 'Publish' 
              AND YEAR(created_at) = $year
            GROUP BY YEAR(created_at)
        ";
        } else {
            // all years
            $query = "
            SELECT YEAR(created_at) AS year, COUNT(*) AS total
            FROM research_papers
            WHERE research_status = 'Approved'
            GROUP BY YEAR(created_at)
            ORDER BY YEAR(created_at) DESC
        ";
        }

        $result = $this->con->query($query);

        $stats = [];
        while ($row = $result->fetch_assoc()) {
            $stats[$row['year']] = (int) $row['total'];
        }
        return $stats;
    }

    // Top researchers (filtered by year if given)
    public function getTopResearchers($year = null)
    {
        $yearFilter = $year ? "AND YEAR(created_at) = " . (int) $year : "";

        $query = "
        SELECT research_created_by, COUNT(*) AS total
        FROM research_papers
        WHERE research_status = 'Publish' $yearFilter
        GROUP BY research_created_by
        ORDER BY total DESC
    ";
        $result = $this->con->query($query);

        $researchers = [];
        while ($row = $result->fetch_assoc()) {
            $researchers[] = $row;
        }
        return $researchers;
    }

    // Available years (min → max, +1 future year)
    public function getAvailableYears()
    {
        $query = "SELECT MIN(YEAR(created_at)) as min_year, MAX(YEAR(created_at)) as max_year FROM research_papers";
        $result = $this->con->query($query);

        $row = $result->fetch_assoc();
        $minYear = $row['min_year'] ?? date('Y');
        $maxYear = $row['max_year'] ?? date('Y');

        $currentYear = (int) date('Y');
        if ($maxYear < $currentYear) {
            $maxYear = $currentYear;
        }
        $maxYear++; // include one future year

        return range((int) $minYear, (int) $maxYear);
    }

    // For records staff: yearly stats (all statuses included)
    public function getAllResearchStatsByYear()
    {
        $query = "
        SELECT YEAR(created_at) as year, COUNT(*) as total
        FROM research_papers
        GROUP BY YEAR(created_at)
        ORDER BY year ASC
    ";
        $result = $this->con->query($query);

        $stats = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $stats[$row['year']] = (int) $row['total'];
            }
        }
        return $stats;
    }

    // For records staff: top researchers (all statuses included)
    public function getAllTopResearchers($year)
    {
        $stmt = $this->con->prepare("
        SELECT research_created_by, COUNT(*) as total
        FROM research_papers
        WHERE YEAR(created_at) = ?
        GROUP BY research_created_by
        ORDER BY total DESC
        LIMIT 10
    ");
        $stmt->bind_param("i", $year);
        $stmt->execute();
        $result = $stmt->get_result();

        $researchers = [];
        while ($row = $result->fetch_assoc()) {
            $researchers[] = $row;
        }
        return $researchers;
    }
    public function getResearchersWithStatuses()
    {
        $query = "
            SELECT research_created_by, research_status, research_title, created_at
            FROM research_papers
            ORDER BY research_created_by ASC, created_at DESC
        ";
        $result = $this->con->query($query);

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function getApprovedResearchPapersByUser($userId)
    {
        $stmt = $this->con->prepare("
            SELECT rp.*, 
                   CONCAT(u.first_name, ' ', u.last_name) AS approved_by
            FROM research_papers rp
            LEFT JOIN users u ON rp.research_recieved_by = u.id
            WHERE rp.research_status = 'Approved' 
              AND rp.research_created_by = ?
            ORDER BY rp.created_at DESC
        ");
        $stmt->bind_param("s", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $papers = [];
        while ($row = $result->fetch_assoc()) {
            $papers[] = $row;
        }
        return $papers;
    }
    public function getApprovedCreatedby($researcherName)
    {
        $query = "
            SELECT rp.*, 
                   CONCAT(u.first_name, ' ', u.last_name) AS approved_by
            FROM research_papers rp
            LEFT JOIN employees u ON rp.research_recieved_by = u.id
            WHERE rp.research_status = 'Approved'
              AND rp.research_created_by = ?
            ORDER BY rp.updated_at DESC
        ";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("s", $researcherName);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function getCancelledResearchPapersByUser($userName)
    {
        $stmt = $this->con->prepare("
        SELECT *
        FROM research_papers
        WHERE research_status = 'Cancelled'
          AND research_created_by = ?
        ORDER BY created_at DESC
    ");
        $stmt->bind_param("s", $userName);
        $stmt->execute();
        $result = $stmt->get_result();

        $papers = [];
        while ($row = $result->fetch_assoc()) {
            $papers[] = $row;
        }
        return $papers;
    }
    // ✅ Get all pending papers created by this user (by email)
    public function getPendingResearchPapersByUser($email)
    {
        $stmt = $this->con->prepare("
        SELECT *
        FROM research_papers
        WHERE research_created_by = ? AND research_status = 'Pending'
        ORDER BY created_at DESC
    ");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        $papers = [];
        while ($row = $result->fetch_assoc()) {
            $papers[] = $row;
        }
        return $papers;
    }

    public function getPendingResearchPapersByUserName($name)
    {
        $stmt = $this->con->prepare("
            SELECT * 
            FROM research_papers
            WHERE research_created_by = ? AND research_status = 'Pending'
            ORDER BY created_at DESC
        ");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();

        $papers = [];
        while ($row = $result->fetch_assoc()) {
            $papers[] = $row;
        }
        return $papers;
    }
    public function getPendingResearchPapersByUserId($userId)
    {
        $stmt = $this->con->prepare("
            SELECT *
            FROM research_papers
            WHERE research_created_by_user_id = ? 
              AND research_status = 'Pending'
            ORDER BY created_at DESC
        ");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $papers = [];
        while ($row = $result->fetch_assoc()) {
            $papers[] = $row;
        }
        return $papers;
    }


    public function getResearchPaperByIdAndUser($id, $userId)
    {
        $stmt = $this->con->prepare("
            SELECT *
            FROM research_papers
            WHERE id = ? AND research_created_by_user_id = ?
            LIMIT 1
        ");
        $stmt->bind_param("ii", $id, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }



    public function updatePendingResearchPaper($id, $title, $abstract, $objective, $members, $pdf_filename)
    {
        $stmt = $this->con->prepare("
        UPDATE research_papers
        SET research_title = ?, 
            research_abstract = ?, 
            research_objective = ?, 
            research_members = ?, 
            pdf_filename = ?, 
            updated_at = NOW()
        WHERE id = ? AND research_status = 'Pending'
    ");
        $stmt->bind_param("sssssi", $title, $abstract, $objective, $members, $pdf_filename, $id);
        return $stmt->execute();
    }
    public function getPublishedResearchPapersByUser($userName)
    {
        $stmt = $this->con->prepare("
        SELECT *
        FROM research_papers
        WHERE research_status = 'Publish'
          AND research_created_by = ?
        ORDER BY created_at DESC
    ");
        $stmt->bind_param("s", $userName);
        $stmt->execute();
        $result = $stmt->get_result();

        $papers = [];
        while ($row = $result->fetch_assoc()) {
            $papers[] = $row;
        }
        return $papers;
    }
    public function getRejectedResearchPapersByUser($researcherName)
    {
        $stmt = $this->con->prepare("
            SELECT *
            FROM research_papers
            WHERE research_status = 'Declined'
              AND research_created_by = ?
            ORDER BY updated_at DESC
        ");
        $stmt->bind_param("s", $researcherName);
        $stmt->execute();
        $result = $stmt->get_result();

        $papers = [];
        while ($row = $result->fetch_assoc()) {
            $papers[] = $row;
        }
        return $papers;
    }


    public function getRevisedResearchPapersByUser($user_id)
    {
        $stmt = $this->con->prepare("
            SELECT *
            FROM research_papers
            WHERE research_status = 'Revised'
            AND research_created_by_user_id = ?
            ORDER BY updated_at DESC
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $papers = [];
        while ($row = $result->fetch_assoc()) {
            $papers[] = $row;
        }
        return $papers;
    }


    public function getResearchPaperById($id)
    {
        $stmt = $this->con->prepare("SELECT * FROM research_papers WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // ✅ Get research paper by ID
    public function getResearchPaperByCreator($id, $creatorEmail)
    {
        $stmt = $this->con->prepare("
            SELECT * FROM research_papers 
            WHERE id = ? AND research_created_by = ?
        ");
        $stmt->bind_param("is", $id, $creatorEmail);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // ✅ Update revised research paper
    public function updateRevisedResearchPaper($id, $title, $abstract, $objective, $members, $pdf_filename)
    {
        $stmt = $this->con->prepare("
        UPDATE research_papers
        SET research_title = ?, 
            research_abstract = ?, 
            research_objective = ?, 
            research_members = ?, 
            pdf_filename = ?, 
            research_status = 'Revised',
            updated_at = NOW()
        WHERE id = ?
    ");
        $stmt->bind_param("sssssi", $title, $abstract, $objective, $members, $pdf_filename, $id);
        return $stmt->execute();
    }

}
?>