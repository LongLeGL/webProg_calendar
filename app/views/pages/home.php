<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="WD-group-5">
		<title> Doctor Appointment </title>
		<!-- Style CSS -->
		<link rel="stylesheet" href="./public/css/style.css">
		<!-- Demo CSS (No need to include it into your project) -->
		<!-- <link rel="stylesheet" href="./public/css/demo.css"> -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
		<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css'>
		<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/@fullcalendar/core@4.2.0/main.min.css'>
		<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@4.3.0/main.min.css'>
	</head>

	<body>
      <!--$%adsense%$-->
		<main class="cd__main">
		<input type="text" id="session-user-level" name="session-user-level" value="<?php echo $_SESSION['userLevel']?>" hidden disabled>
			<input type="text" id="session-username" name="session-username" value="<?php echo $_SESSION['username']?>" hidden disabled>
			<div id='calendar'></div>

			<!-- New event form for user -->
			<div class="modal fade edit-form" id="user-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header border-bottom-0">
							<h5 class="modal-title" id="modal-title">Add Event</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<form id="user-form" method="POST" action="index.php?page=home/insert">
							<div class="modal-body">
								<div class="alert alert-danger " role="alert" id="danger-alert-time-slot" style="display: none">
									This time slot is not available!
								</div>
								<div class="form-group">
									<label for="full-name">Patient name</label>
									<input type="text" class="form-control" id="full-name" name="full-name" value="<?php echo $_SESSION['fullName']?>" disabled>
								</div>
								<div class="form-group">
									<label for="date">Date</label>
									<input type="text" class="form-control" id="date" name="date" disabled>
								</div>
								<div class="form-group">
									<label for="start-time">Start time (Time slot is 30 minutes)<span class="text-danger">*</span></label>
									<input type="time" class="form-control" id="start-time" name="start-time" required>
								</div>
							</div>
							<div class="modal-footer border-top-0 d-flex justify-content-center">
								<button type="submit" class="btn btn-success" id="submit-button" name="submit-button">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>

			<!-- New event form for doctor -->
			<div class="modal fade edit-form" id="doctor-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header border-bottom-0">
							<h5 class="modal-title" id="doctor-modal-title">Add Event</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<form id="doctor-form" method="POST" action="index.php?page=home/insert">
							<div class="modal-body">
								<div class="alert alert-danger " role="alert" id="doctor-danger-alert-time-slot" style="display: none">
									This time slot is not available!
								</div>
								<div class="form-group">
									<label for="date">Date</label>
									<input type="text" class="form-control" id="doctor-date" name="date" disabled>
								</div>
								<div class="form-group">
									<label for="start-time">Start time<span class="text-danger">*</span></label>
									<input type="time" class="form-control" id="doctor-start-time" required>
								</div>
								<div class="form-group">
									<label for="start-time">End time<span class="text-danger">*</span></label>
									<input type="time" class="form-control" id="doctor-end-time" required>
								</div>
							</div>
							<div class="modal-footer border-top-0 d-flex justify-content-center">
								<button type="submit" class="btn btn-success" id="doctor-submit-button" name="submit-button">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			
			<!-- Delete Modal -->
			<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="delete-modal-title" aria-hidden="true">
				<div class="modal-dialog modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="delete-modal-title"></h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body text-center" id="delete-modal-body"></div>
						<div class="modal-body">
							<div class="form-group">
								<label for="full-name">Patient name</label>
								<input type="text" class="form-control" id="delete-full-name" name="delete-full-name" value="<?php echo $_SESSION['fullName']?>" disabled>
							</div>
							<div class="form-group">
								<label for="date">Scheduled date and time</label>
								<input type="text" class="form-control" id="delete-date-time" name="delete-date-time" disabled>
							</div>
							<div class="modal-footer border-0">
								<button type="button" class="btn btn-secondary rounded-sm" data-dismiss="modal" id="cancel-button">Cancel</button>
								<button type="button" class="btn btn-danger rounded-lg" id="delete-button">Delete</button>
							</div>
						</div>
					</div>
				</div>
			</div>

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
		<!--$%analytics%$-->
   	</body>
</html>