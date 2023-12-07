<?php
    // to be able to send mail, customize the 2 config files:
    // \xampp\sendmail\sendmail.ini
    // \xampp\php\php.ini

    function sendmail_newAppointment($doctorMail, $pname, $adate, $atime, $pmail, $aid){
        $msg = "
        <html>
            <head>
                <style type='text/css'>
                    body{
                        background-color: aliceblue;
                        border-radius: 5em;
                    }

                    h2{
                        text-align: center;
                        color: darkgray;
                        font-family: sans-serif;
                    }

                    table{
                        width: fit-content;
                        margin: auto;
                    }

                    th, td{
                        text-align: start;
                        width: 8em;
                    }
                    
                    #actionBtns{
                        display: flex;
                        justify-content: center;
                        gap: 2em;
                        font-family: monospace;
                        margin: 2em 0;
                    }
                    #actionBtns a{
                        text-decoration: none;
                    }
                    .actionBtn{
                        font-size: 1.2em;
                        font-weight: bold;
                        width: 6em;
                        height: 2.5em;
                        text-align: center;
                        color: white;
                        line-height: 2.5em;
                        border: 1px solid orange;
                        border-radius: 5px;
                        margin: 0em 1em
                    }

                    #viewLink{
                        color: rgb(120, 120, 120);
                        font-style: italic;
                        display: block;
                        margin: auto;
                        text-align: center;
                    }
                </style>
            </head>

            <body>
                <h2>New appointment is pending your approval!</h2>
                
                <table>
                    <tr>
                    <th>Patient's name:</th>
                    <td>$pname</td>
                    </tr>
                    <tr>
                    <th>Date:</th>
                    <td>$adate</td>
                    </tr>
                    <tr>
                    <th>Time:</th>
                    <td>$atime</td>
                    </tr>
                    <tr>
                        <th>Contact Email:</th>
                        <td>$pmail</td>
                    </tr>
                </table>

                <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                    <tr>
                        <td align='center'>
                            <div id='actionBtns'>
                                <a href='http://localhost/webProg_calendar/app/controllers/approveEvent.php?eid=$aid'><div class='actionBtn'   style='background-color: #04AA6D;'>Approve</div></a>
                                <a href='http://localhost/webProg_calendar/app/controllers/deleteEvent.php?eid=$aid'><div class='actionBtn'    style='background-color: red;'>Reject</div></a>
                            </div>
                        </td>
                    </tr>
                </table>

                <a href='http://localhost/viewDetails?id=$aid' id='viewLink'>View appointment in calendar</a>
            </body>
        </html>
        ";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: lhlong1542002@gmail.com" . "\r\n";

        // send email
        $res = mail($doctorMail, '[Calendar] New appointment',$msg, $headers);
        if ($res) echo('Server accepted email to doctor '.$doctorMail);
    }

    function sendmail_acceptedAppointment($patientMail, $dname, $adate, $atime, $aid){
        $msg = "
        <html>
            <head>
                <style type='text/css'>
                    body{
                        background-color: aliceblue;
                        border-radius: 5em;
                    }

                    h2{
                        text-align: center;
                        color: darkgray;
                        font-family: sans-serif;
                    }

                    table{
                        width: fit-content;
                        margin: auto;
                    }

                    th, td{
                        text-align: start;
                        width: 8em;
                    }
                    
                    #actionBtns{
                        display: flex;
                        justify-content: center;
                        gap: 2em;
                        font-family: monospace;
                        margin: 2em 0;
                    }
                    #actionBtns a{
                        text-decoration: none;
                    }
                    .actionBtn{
                        font-size: 1.2em;
                        font-weight: bold;
                        width: 6em;
                        height: 2.5em;
                        text-align: center;
                        color: white;
                        line-height: 2.5em;
                        border: 1px solid orange;
                        border-radius: 5px;
                        margin: 0em 1em
                    }

                    #viewLink{
                        color: rgb(120, 120, 120);
                        font-style: italic;
                        display: block;
                        margin: auto;
                        text-align: center;
                    }
                </style>
            </head>

            <body>
                <h2>Your appointment has been accepted!</h2>
                
                <table>
                    <tr>
                    <th>Doctor's name:</th>
                    <td>$dname</td>
                    </tr>
                    <tr>
                    <th>Date:</th>
                    <td>$adate</td>
                    </tr>
                    <tr>
                    <th>Time:</th>
                    <td>$atime</td>
                    </tr>
                </table>

                <a href='http://localhost/dashboard?id=$aid' id='viewLink'>View appointment in calendar</a>
            </body>
        </html>
        ";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: lhlong1542002@gmail.com" . "\r\n";

        // send email
        $res = mail($patientMail, '[Hospital] Accepted appointment',$msg, $headers);
        if ($res) echo('Server accepted Approval mail to patient '.$patientMail);
    }

    function sendmail_rejectedAppointment($patientMail, $dname, $adate, $atime){
        $msg = "
        <html>
            <head>
                <style type='text/css'>
                    body{
                        background-color: aliceblue;
                        border-radius: 5em;
                    }

                    h2{
                        text-align: center;
                        color: darkgray;
                        font-family: sans-serif;
                    }

                    table{
                        width: fit-content;
                        margin: auto;
                    }

                    th, td{
                        text-align: start;
                        width: 8em;
                    }
                    
                    #actionBtns{
                        display: flex;
                        justify-content: center;
                        gap: 2em;
                        font-family: monospace;
                        margin: 2em 0;
                    }
                    #actionBtns a{
                        text-decoration: none;
                    }
                    .actionBtn{
                        font-size: 1.2em;
                        font-weight: bold;
                        width: 6em;
                        height: 2.5em;
                        text-align: center;
                        color: white;
                        line-height: 2.5em;
                        border: 1px solid orange;
                        border-radius: 5px;
                        margin: 0em 1em
                    }

                    #viewLink{
                        color: rgb(120, 120, 120);
                        font-style: italic;
                        display: block;
                        margin: auto;
                        text-align: center;
                    }
                </style>
            </head>

            <body>
                <h2>A doctor turned down your appointment!</h2>
                
                <table>
                    <tr>
                    <th>Doctor's name:</th>
                    <td>$dname</td>
                    </tr>
                    <tr>
                    <th>Date:</th>
                    <td>$adate</td>
                    </tr>
                    <tr>
                    <th>Time:</th>
                    <td>$atime</td>
                    </tr>
                </table>

                <a href='http://localhost/dashboard' id='viewLink'>Make a new appointment</a>
            </body>
        </html>
        ";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: lhlong1542002@gmail.com" . "\r\n";

        // send email
        $res = mail($patientMail, '[Hospital] Appointment rejected',$msg, $headers);
        if ($res) echo('Server accepted Rejection mail to patient '.$patientMail);
    }

    function sendmail_canceledAppointment($patientMail, $dname, $adate, $atime){
        $msg = "
        <html>
            <head>
                <style type='text/css'>
                    body{
                        background-color: aliceblue;
                        border-radius: 5em;
                    }

                    h2{
                        text-align: center;
                        color: darkgray;
                        font-family: sans-serif;
                    }

                    table{
                        width: fit-content;
                        margin: auto;
                    }

                    th, td{
                        text-align: start;
                        width: 8em;
                    }
                    
                    #actionBtns{
                        display: flex;
                        justify-content: center;
                        gap: 2em;
                        font-family: monospace;
                        margin: 2em 0;
                    }
                    #actionBtns a{
                        text-decoration: none;
                    }
                    .actionBtn{
                        font-size: 1.2em;
                        font-weight: bold;
                        width: 6em;
                        height: 2.5em;
                        text-align: center;
                        color: white;
                        line-height: 2.5em;
                        border: 1px solid orange;
                        border-radius: 5px;
                        margin: 0em 1em
                    }

                    #viewLink{
                        color: rgb(120, 120, 120);
                        font-style: italic;
                        display: block;
                        margin: auto;
                        text-align: center;
                    }
                </style>
            </head>

            <body>
                <h2>Your appointment has been cancelled!</h2>
                
                <table>
                    <tr>
                    <th>Doctor's name:</th>
                    <td>$dname</td>
                    </tr>
                    <tr>
                    <th>Date:</th>
                    <td>$adate</td>
                    </tr>
                    <tr>
                    <th>Time:</th>
                    <td>$atime</td>
                    </tr>
                </table>

                <a href='http://localhost/dashboard' id='viewLink'>Make a new appointment</a>
            </body>
        </html>
        ";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: lhlong1542002@gmail.com" . "\r\n";

        // send email
        $res = mail($patientMail, '[Hospital] Appointment cancelled',$msg, $headers);
        if ($res) echo('Server accepted Cancellation mail to patient '.$patientMail);
    }

    // sendmail_newAppointment('lhlong1542002@gmail.com', 'Linh', '11/11/2023', '10:00', "linh@gmail.com", 99);
    // sendmail_acceptedAppointment('lhlong1542002@gmail.com', 'Khoa', '11/11/2023', '10:00', 12);
    // sendmail_rejectedAppointment('lhlong1542002@gmail.com', 'Phung', '11/11/2023', '10:00');
    // sendmail_canceledAppointment('lhlong1542002@gmail.com', 'Phung', '11/11/2023', '10:00');
    
?>