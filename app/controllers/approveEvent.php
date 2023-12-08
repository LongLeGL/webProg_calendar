<?php
    include('email.php');

    session_start();
    // $_SESSION['role'] = "doctor";                                                       // test
    // $_SESSION['uId'] = 4;                                                               // test

    if (!isset($_SESSION['role']) || $_SESSION['role']!='doctor'){
        echo("Must be signed in as a doctor to approve an appointment !");
        session_abort();
        echo("<br><a href='/index'>Back to home page</a>");
        exit();
    }

    $appointment_id = $_GET['eid'];
    if (!$appointment_id){
        echo("No appointment id provided !");
        session_abort();
        // header("Location: index.php");
        exit();
    }


	$serverName = 'localhost';
	$username = 'root';
	$password = '';
	$dbname = 'ConvenientAppointment';

    $conn = new mysqli($serverName, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


// Check if provided event id is valid
    $result = $conn->query("SELECT * FROM events WHERE id = '$appointment_id'");

    if (!$result || $result->num_rows <= 0){
        echo("Cannot find appointment $appointment_id !");
    }
    else{
// Check of the logged in doctor is the owner of the event
        $targetEvent = $result->fetch_assoc();
        $event_docId = $targetEvent['doctorId'];
        if ($_SESSION['uId'] != $event_docId){
            echo("You are not authorized to approve this appointment !");
            session_abort();
            exit();
        }

        // Update status to approved
        $stmt = $conn->prepare("UPDATE `events` SET `status`='confirmed' WHERE id=?");
        if ($stmt == false) {
            echo("!! stmt prepare failed: ");
            echo($conn->error);
            session_abort();
            exit();
        }
        $stmt->bind_param("i", $appointment_id);
        $res = $stmt->execute();

        // Get full info for notification mail
        $patientID = $targetEvent['patientId'];
        $patientEmail = $conn->query("SELECT email FROM users WHERE id=$patientID AND role='patient'");
        $patientEmail = $patientEmail->fetch_assoc()['email'];
        

        $doctorName = $conn->query("SELECT `name`  FROM users WHERE id=$event_docId");
        $doctorName = $doctorName->fetch_assoc()['name'];
        

        $appointment_date = date_parse($targetEvent['start']);
        $appointment_date_string = $appointment_date['day'] . "/" . $appointment_date['month'] . "/" . $appointment_date['year'];

        $appointment_time = $targetEvent['start'];
        $appointment_time_string = substr($appointment_time, 11, 5);

        echo("<br>patientEmail: ".$patientEmail);                           //test
        echo("<br>doctorFullName: ".$doctorName);                           //test
        echo("<br>appointment_date: ".$appointment_date_string);            //test
        echo("<br>appointment_time: ".$appointment_time_string);            //test

        // sendmail_acceptedAppointment($patientEmail, $doctorName, $appointment_date_string, $appointment_time_string, $appointment_id);
        echo("<br>Approved event: $appointment_id !");
    }

    session_abort();
    // redirect back to details page ?
    exit();
?>