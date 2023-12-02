<div class="modal fade edit-form" id="patient-cancel-modal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog" role="document">
		<div class="modal-content">
			<div class="card card-5">
				<div class="card-heading-cancel">
					<h2 class="title">Cancel Confirmation</h2>
				</div>
				<div class="card-body">
					<form id="patient-cancel-form" method="POST" action="">
						<div class="form-row">
							<div class="name">Doctor Name</div>
							<div class="value">
								<div class="input-group">
								<input class="input--style-5" type="text" class="form-control" id="patient-cancel-doctor-name" name="patient-cancel-doctor-name" value="<?php echo $_SESSION['currentUser']['name'] ?>" disabled>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="name">Your Name</div>
							<div class="value">
								<div class="input-group">
								<input class="input--style-5" type="text" class="form-control" id="patient-cancel-patient-name" name="patient-cancel-patient-name" value="<?php echo $_SESSION['currentUser']['name'] ?>" disabled>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="name">Date</div>
							<div class="value">
								<div class="input-group">
									<input class="input--style-5" type="text" id="patient-cancel-date" name="cancel-date" disabled>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="name">Start From</div>
							<div class="value">
								<div class="input-group">
									<div class="col-sm-4">
										<input class="input--style-5" type="text" id="patient-cancel-start" name="cancel-date" disabled>
									</div>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="name">To</div>
							<div class="value">
								<div class="input-group">
									<div class="col-sm-4">
									<input class="input--style-5" type="text" id="patient-cancel-end" name="cancel-date" disabled>
									</div>
								</div>
							</div>
						</div>

						<div class="form-btn">
							<button class="cancel-btn" id="patient-cancel-button">Cancel</button>
						</div>
					</div>	

					</form>
				</div>
			</div>
		</div>
	</div>
</div>