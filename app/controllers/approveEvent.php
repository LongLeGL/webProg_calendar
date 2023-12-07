<?php
    include('email.php');

    session_start();
    $_SESSION['role'] = "doctor";                                                       // test
    $_SESSION['uId'] = 1;                                                               // test

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


    $connection = 'home';
	$serverName = 'localhost';
	$username = 'root';
	$password = '';
	$dbname = 'convenientappointment';

    $conn = new mysqli($serverName, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


// Check if provided event id is valid
    $result = $conn->query("SELECT * FROM appointment WHERE eventID=$appointment_id");


    if (!$result || $result->num_rows <= 0){
        echo("Cannot find appointment $appointment_id !");
    }
    else{
// Check of the logged in doctor is the owner of the event
        $targetEvent = $result->fetch_assoc();
        $event_docId = $targetEvent['doctorID'];
        if ($_SESSION['uId'] != $event_docId){
            echo("You are not authorized to approve this appointment !");
            session_abort();
            exit();
        }

        // Update status to approved
        $stmt = $conn->prepare("UPDATE `event` SET `status`='approved' WHERE id=?");
        if ($stmt == false) {
            echo("!! stmt prepare failed: ");
            echo($conn->error);
            session_abort();
            exit();
        }
        $stmt->bind_param("i", $appointment_id);
        $res = $stmt->execute();

        // Get full info for notification mail
        $patientID = $targetEvent['patientID'];
        $patientEmail = $conn->query("SELECT email FROM patient WHERE ID=$patientID");
        $patientEmail = $patientEmail->fetch_assoc()['email'];
        

        $doctorName = $conn->query("SELECT firstName, lastName  FROM doctor WHERE ID=$event_docId");
        $doctorName = $doctorName->fetch_assoc();
        $doctorFullName = $doctorName['firstName'] . " " . $doctorName['lastName'];
        
        $event = $conn->query("SELECT * FROM event WHERE id=$appointment_id");
        $event = $event->fetch_assoc();

        $appointment_date = $event['eventDate'];
        $appointment_date_stringArr = explode("-", $event['eventDate']);
        $appointment_date_string = $appointment_date_stringArr[2] . "/" . $appointment_date_stringArr[1] . "/" . $appointment_date_stringArr[0];
        
        $appointment_time = $event['startTime'];
        $appointment_time_string = substr($appointment_time, 0, 5);

        echo("<br>patientEmail: ".$patientEmail);                           //test
        echo("<br>doctorFullName: ".$doctorFullName);                       //test
        echo("<br>appointment_date: ".$appointment_date_string);            //test
        echo("<br>appointment_time: ".$appointment_time_string);            //test

        // sendmail_acceptedAppointment($patientEmail, $doctorFullName, $appointment_date_string, $appointment_time_string, $appointment_id);
        echo("<br>Approved $appointment_id !");
    }

    session_abort();
    // redirect back to details page ?
    exit();
?>