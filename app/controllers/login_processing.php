<?php
    $servername = "localhost"; // Replace with your MySQL server name
    $username = "root"; // Replace with your MySQL username
    $password = ""; // Replace with your MySQL password
    $dbname = "ConvenientAppointment";

    // Create connection to choose database OnlineStore
    $mydb = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($mydb->connect_error) {
        die("Connection failed: " . $mydb->connect_error);
    }

    $email = $password = "";
    $email_err = $password_err = $login_err = "";

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];
        // Query to check if the username and password match
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $mydb->query($sql);

        // Check if the query returned a row
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stored_password = $row["pwd"];

            // Verify the password
            // if (password_verify($password, $stored_password)) {
            //     // Authentication successful, redirect to index.php
            //     // $_SESSION["loggedin"] = true;
            //     $_SESSION['currentUser']['id'] = $row["id"];
            //     $_SESSION['currentUser']['name'] = $row["name"];
            //     $_SESSION['currentUser']['email'] = $row["email"];
            //     $_SESSION['currentUser']['role'] = $row["role"];
                
            //     header("Location: index.php");
            //     exit;
            // }
            if (password_verify($password, $stored_password)) {
                // Authentication successful, redirect to index.php
                // $_SESSION["loggedin"] = true;
                $_SESSION['currentUser']['id'] = $row["id"];
                $_SESSION['currentUser']['name'] = $row["name"];
                $_SESSION['currentUser']['email'] = $row["email"];
                $_SESSION['currentUser']['role'] = $row["role"];
                
                if ($row["role"] == 'patient')  header("Location: http://localhost/?page=patientHome");
                else header("Location: doctor_homepage.php");
                
                exit;
            }
        }

        // Incorrect username or password
        // $_SESSION["loggedin"] = false;
        echo "Incorrect email or password!";
    }

    $mydb->close();
?>