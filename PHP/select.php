<?php
    $mysqli = mysqli_connect("localhost", "calove", "VXvsjr71!", "create_a_db");

    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    } else {
        $searchLastName = isset($_GET['lastName']) ? mysqli_real_escape_string($mysqli, $_GET['lastName']) : null;

        $sql = "SELECT first_name, last_name, email FROM Person";
        if ($searchLastName) {
            $sql .= " WHERE LOWER(last_name) = LOWER('$searchLastName')";
        }
        $sql .= " ORDER BY last_name";

        $result = mysqli_query($mysqli, $sql);

        $names = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $names[] = $row;
                //'lastName' => $row['last_name'],
                //'firstName' => $row['first_name'],
                //'email'=> $row['email']
        }

        mysqli_free_result($result);
        mysqli_close($mysqli);

        header('Content-Type: application/json');
        echo json_encode($names);
    }
?>