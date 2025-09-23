<?php
include '../../controller/connection.db.php';

if (isset($_POST['provCode'])) {
    $provCode = $_POST['provCode'];

    $sql = "SELECT * FROM refcitymun WHERE provCode = '$provCode' ORDER BY citymunDesc ASC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        echo "<option value='' disabled selected>Select Municipality</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='".$row['citymunCode']."'>".$row['citymunDesc']."</option>";
        }
    } else {
        echo "<option value=''>No municipalities found</option>";
    }
}
?>
