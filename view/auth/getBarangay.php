<?php
include '../../controller/connection.db.php';

if (isset($_POST['citymunCode'])) {
    $citymunCode = $_POST['citymunCode'];
    $query = "SELECT * FROM refbrgy WHERE citymunCode = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $citymunCode);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $options = "<option value=''>Select Barangay</option>";
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='".$row['brgyCode']."'>".$row['brgyDesc']."</option>";
    }   
    echo $options;
}
?>
