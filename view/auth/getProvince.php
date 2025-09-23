<?php
include '../../controller/connection.db.php';

if (isset($_POST['regCode'])) {
    $regCode = $_POST['regCode'];
    $query = "SELECT * FROM refprovince WHERE regCode = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $regCode);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $options = "<option value=''>Select Province</option>";
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='".$row['provCode']."'>".$row['provDesc']."</option>";
    }
    echo $options;
}
?>
