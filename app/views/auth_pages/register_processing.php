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

    $name = $email = $password = "";
    $email_err = $password_err = $login_err = "";

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $name = $_POST["name"];
        $role = $_POST["role"];

        // Query to check if the username and password match
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $mydb->query($sql);

        // Check if the query returned a row
        if ($result->num_rows > 0) {
            header("Location: register.php");
            exit;
        }

        function insert_user($name, $email, $password, $role){
            global $mydb;
    
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT IGNORE INTO users (name, email, pwd, role)
            VALUES  ('$name', '$email', '$hashed_password', '$role')";
        
            $mydb->query($sql);
        }
    
        insert_user($name, $email, $password, $role);

        header("Location: login.php");
    }

    $mydb->close();
?>