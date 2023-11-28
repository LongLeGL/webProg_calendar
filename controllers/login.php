<?php
    include("utilities.php");

    $servername = "localhost";
    $username = "admin";
    $password = "adminbk2053186";
    $dbname = "OnlineStore";

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if (isset($_POST['uname']) && isset($_POST['password'])) {
        PHPconsole_log('Login processor Received: '.$_POST['uname'].' '.$_POST['password']);
        session_start();
        $_SESSION['user_name'] = $_POST['uname'];
        $uname = validate($_POST['uname']);
        $pass = validate($_POST['password']);

        if (empty($uname)) {
            header("Location: ../index.php?page=login&error=User Name is required");
            exit('Login processor: no uName');
        }else if(empty($pass)){
            header("Location: ../index.php?page=login&error=Password is required");
            exit('Login processor: no password');
        }else{
            // Connect to db and validate user:
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            }
            PHPconsole_log("Database connected successfully");

            $sql = "SELECT * FROM users WHERE usrname='$uname' AND passhash=password('$pass')";
            $result = mysqli_query($conn, $sql);
    
            if (mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);
                if ($row['usrname'] === $uname) {
                    // session_start();
                    $_SESSION['user_name'] = $row['usrname'];
                    $_SESSION['fname'] = $row['fname'];
                    $_SESSION['lname'] = $row['lname'];
                    $_SESSION['id'] = $row['userID'];
                    $_SESSION['role'] = $row['uRole'];  
                    echo 'Saved session:'.implode($_SESSION);

                    $cookie_name = "saved_user";
                    $cookie_value = $row['userID'].'-'.$row['fname'].' '.$row['lname'].'-'.$row['usrname'].'-'.$row['uRole'];
                    setcookie($cookie_name, $cookie_value, time() + 30, "/"); // 86400s = 1 day
                    echo 'Saved Cookie:'.$cookie_value;

                    header("Location: ../index.php?page=home");
                }
                else{
                    echo('found but not match');
                    header("Location: ../index.php?page=login&error=Incorrect username or password");
                }
            }
            else{
                echo('nothing found');
                header("Location: ../index.php?page=login&error=Incorrect username or password");
            }
            $conn->close();
            PHPconsole_log("Connection closed");
        }
    }
    
?>