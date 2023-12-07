<?php
    include('email.php');

    session_start();
    // $_SESSION['role'] = "doctor";                                                       // test
    // $_SESSION['uId'] = 4;                                                               // test
    // $_SESSION['role'] = "patient";                                                      // test
    // $_SESSION['uId'] = 1;                                                              // test

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

    $connection = 'home';
	$serverName = 'localhost';
	$username = 'root';
	$password = '';
	$dbname = 'ConvenientAppointment';

    $conn = new mysqli($serverName, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if provided event id is valid
    $event = $conn->query("SELECT * FROM `events` WHERE id='$event_id'");

    if (!$event || $event->num_rows <= 0){
        echo("Cannot find Event $event_id !");
    }
    else{
        $event = $event->fetch_assoc();
        // Check if the appointment belong to the doctor/patient
        if (
                ($userID != $event['patientId'] || $userRole != 'patient')  &&
                ($userID != $event['doctorId'] || $userRole != 'doctor')
            ){
            echo("You do not belong to the event !");
            session_abort();
            exit();
        }
        else{   // remove the appointment
            // Get full info for notification mail
            $event_status = $event['status'];
            $patientID = $event['patientId'];
            $patientEmail = $conn->query("SELECT email FROM users WHERE id=$patientID AND role='patient'");
            $patientEmail = $patientEmail->fetch_assoc()['email'];
            
            $docId = $event['doctorId'];
            $doctorName = $conn->query("SELECT `name`, email  FROM users WHERE id=$docId");
            $doctorName = $doctorName->fetch_assoc()['name'];
            

            $appointment_date = date_parse($event['start']);
            $appointment_date_string = $appointment_date['day'] . "/" . $appointment_date['month'] . "/" . $appointment_date['year'];

            $appointment_time = $event['start'];
            $appointment_time_string = substr($appointment_time, 11, 5);

            echo("<br>patientEmail: ".$patientEmail);                           //test
            echo("<br>doctorFullName: ".$doctorName);                           //test
            echo("<br>appointment_date: ".$appointment_date_string);            //test
            echo("<br>appointment_time: ".$appointment_time_string);            //test


            // Delete event
            $res = $conn->query("DELETE FROM `events` WHERE ID='$event_id'");


            // Mail content hanlding
            if ($event_status == "pending"){
                // reject, cancel un-approved appointment
                if ($userRole == 'patient'){
                    echo("<br> Appointment $event_id is cancelled by patient (b4 approve) !");
                }
                else{
                    // sendmail_rejectedAppointment($patientEmail, $doctorName, $appointment_date_string, $appointment_time_string);
                    echo("<br> Appointment $event_id is rejected by Doctor !");
                }
            }
            else{
                if ($userRole != 'patient'){
                    // sendmail_canceledAppointment($patientEmail, $doctorName, $appointment_date_string, $appointment_time_string);
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