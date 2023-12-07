<?php
    include('email.php');

    session_start();
    $_SESSION['role'] = "doctor";                                                       // test
    $_SESSION['uId'] = 1;                                                               // test
    // $_SESSION['role'] = "patient";                                                      // test
    // $_SESSION['uId'] = 99;                                                              // test

    if (!isset($_SESSION['role'])){
        echo("Must be signed in as a doctor or patient to remove an event !");
        session_abort();
        echo("<br><a href='/index'>Back to home page</a>");
        exit();
    }

    $userRole = $_SESSION['role'];
    $userID = $_SESSION['uId'];

    
    if (!isset($_GET['eid'])){
        echo("No eid param provided !");
        session_abort();
        // header("Location: index.php");
        exit();
    }
    $event_id = $_GET['eid'];
    // if (!isset($_GET['action'])){
    //     echo("No action param(reject/cancel) provided !");
    //     session_abort();
    //     // header("Location: index.php");
    //     exit();
    // }
    // $action = $_GET['action'];

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
    $event = $conn->query("SELECT * FROM `event` WHERE ID=$event_id");

    if (!$event || $event->num_rows <= 0){
        echo("Cannot find Event $event_id !");
    }
    else{
        // Check if the appointment belong to the doctor/patient
        $appointment = $conn->query("SELECT * FROM `appointment` WHERE eventID=$event_id");
        if (!$appointment || $appointment->num_rows <= 0){
            echo("Cannot find appointment for Event $event_id !");
            session_abort();
            exit();
        }

        $appointment_row = $appointment->fetch_assoc();
        if ($userID != $appointment_row['patientID'] && $userID != $appointment_row['doctorID']){
            echo("You do not belong to the event !");
            session_abort();
            exit();
        }
        else{   // remove the appointment
            // Get full info for notification mail
            $patientID = $appointment_row['patientID'];
            $patientEmail = $conn->query("SELECT email FROM patient WHERE ID=$patientID");
            $patientEmail = $patientEmail->fetch_assoc()['email'];
            
            $doctorID = $appointment_row['doctorID'];
            $doctorName = $conn->query("SELECT firstName, lastName  FROM doctor WHERE ID=$doctorID");
            $doctorName = $doctorName->fetch_assoc();
            $doctorFullName = $doctorName['firstName'] . " " . $doctorName['lastName'];
            
            $event = $event->fetch_assoc();
            $event_status = $event['status'];

            $appointment_date = $event['eventDate'];
            $appointment_date_stringArr = explode("-", $event['eventDate']);
            $appointment_date_string = $appointment_date_stringArr[2] . "/" . $appointment_date_stringArr[1] . "/" . $appointment_date_stringArr[0];
            
            $appointment_time = $event['startTime'];
            $appointment_time_string = substr($appointment_time, 0, 5);

            echo("<br>patientEmail: ".$patientEmail);                           //test
            echo("<br>doctorFullName: ".$doctorFullName);                       //test
            echo("<br>appointment_date: ".$appointment_date_string);            //test
            echo("<br>appointment_time: ".$appointment_time_string);            //test


            // Delete and send notification to patient when doctor cancelled their appointment
            $res = $conn->query("DELETE FROM `event` WHERE ID=$event_id");
            if ($event_status == "pending"){
                // sendmail_rejectedAppointment($patientEmail, $doctorFullName, $appointment_date_string, $appointment_time_string);
                echo("<br> Appointment $event_id is rejected by $userRole !");
            }
            else{
                if ($userRole != 'patient'){
                    // sendmail_canceledAppointment($patientEmail, $doctorFullName, $appointment_date_string, $appointment_time_string);
                    echo("<br> Appointment $event_id is cancelled by Doctor !");
                }
                else{
                    echo("<br> Appointment $event_id is cancelled by patient !");
                }
                
            }
        }  
            
    }

    session_abort();
    // redirect back to details page ?
    exit();
?>