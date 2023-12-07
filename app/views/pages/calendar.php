<main class="cd__main">
	<input type="text" id="ssRole" name="ssRole" value="<?php echo $_SESSION['currentUser']['role'] ?>" hidden disabled>
	<input type="text" id="ssId" name="ssId" value="<?php echo $_SESSION['currentUser']['id'] ?>" hidden disabled>
	<input type="text" id="ssDoctorId" name="ssId" value="<?php echo $_SESSION['currentUser']['doctorId'] ?>" hidden disabled>

	<div id='calendar'></div>
	<?php require_once "./app/views/components/patient_new_form.php" ?>
	<?php require_once "./app/views/components/doctor_new_form.php" ?>
	<?php require_once "./app/views/components/doctor_cancel_form.php" ?>
	<?php require_once "./app/views/components/patient_cancel_form.php" ?>
	<?php require_once "./app/views/components/email_modal.php" ?>
	<?php require_once "./app/views/components/doctor_occupied_events_list.php" ?>
</main>


<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@4.2.0/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@4.2.0/main.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@4.2.0/main.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/uuid@8.3.2/dist/umd/uuidv4.min.js'></script>
<!-- Script JS -->
<script src="./public/js/calendar.js"></script>
<script src="./public/js/patient-new-form.js"></script>
<script src="./public/js/doctor-new-form.js"></script>