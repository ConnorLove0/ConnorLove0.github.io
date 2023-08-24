<?php
    $mysqli = mysqli_connect("localhost", "calove", "VXvsjr71!", "create_a_db");

    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    } else {
        if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['email-input'])) {
            $first_name = mysqli_real_escape_string($mysqli, $_POST['firstName']);
            $last_name = mysqli_real_escape_string($mysqli, $_POST['lastName']);
            $email = mysqli_real_escape_string($mysqli, $_POST['email-input']);

            // Using prepared statements to prevent SQL injection
            $stmt = $mysqli->prepare("INSERT INTO Person (first_name, last_name, email) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $first_name, $last_name, $email);

            if ($stmt->execute()) {
                echo '<script>alert("A record has been inserted successfully");</script>';
            }
            else {
                printf("Could not insert record: %s\n", $mysqli->error);
            }

            $stmt->close();

        } else {
            echo 'First Name, Last Name, and Email are required fields.';
        }
        mysqli_close($mysqli);
    }
?>