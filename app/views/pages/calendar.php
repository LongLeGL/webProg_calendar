<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="WD-group-5">
		<link rel="shortcut icon" href="">
		<title> Convenient Appointment </title>
		<!-- Style CSS -->
		<link rel="stylesheet" href="./public/css/style.css">
		<link rel="stylesheet" href="./public/css/form.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
		<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css'>
		<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/@fullcalendar/core@4.2.0/main.min.css'>
		<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@4.3.0/main.min.css'>
	</head>

	<body>
      <!--$%adsense%$-->
		<main class="cd__main">
			<input type="text" id="ssRole" name="ssRole" value="<?php echo $_SESSION['currentUser']['role'] ?>" hidden disabled>
			<input type="text" id="ssId" name="ssId" value="<?php echo $_SESSION['currentUser']['id'] ?>" hidden disabled>

			<div id='calendar'></div>
			<?php require_once "./app/views/components/patient_new_form.php" ?>
			<?php require_once "./app/views/components/doctor_new_form.php" ?>
			<?php require_once "./app/views/components/doctor_cancel_form.php" ?>
			<?php require_once "./app/views/components/patient_cancel_form.php" ?>
			<?php require_once "./app/views/components/email_modal.php" ?>

		</main>

		<!-- <footer class="cd__credit">Author: Mick Nixon M. Manuit - Distributed By: <a title="Free web design code & scripts" href="https://www.codehim.com?source=demo-page" target="_blank">CodeHim</a></footer> -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
		<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@4.2.0/main.min.js'></script>
		<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@4.2.0/main.js'></script>
		<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@4.2.0/main.js'></script>
		<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
		<script src='https://cdn.jsdelivr.net/npm/uuid@8.3.2/dist/umd/uuidv4.min.js'></script>
		<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
		<!-- Script JS -->
		<script src="./public/js/calendar.js"></script>
		<script src="./public/js/patient-new-form.js"></script>
		<script src="./public/js/doctor-new-form.js"></script>
		<!--$%analytics%$-->
   	</body>
</html>