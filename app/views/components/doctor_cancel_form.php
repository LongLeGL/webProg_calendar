<div class="modal fade edit-form" id="doctor-cancel-modal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog" role="document">
		<div class="modal-content">
			<div class="card card-5">
				<div class="card-heading-cancel">
					<h2 class="title">Cancel Confirmation</h2>
				</div>
				<div class="card-body">
					<form id="doctor-cancel-form" method="POST" action="">
						<div class="form-row">
							<div class="name">Patient Name</div>
							<div class="value">
								<div class="input-group">
								<input class="input--style-5" type="text" class="form-control" id="doctor-cancel-name" name="doctor-cancel-name" value="<?php echo $_SESSION['currentUser']['name'] ?>" disabled>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="name">Date</div>
							<div class="value">
								<div class="input-group">
									<input class="input--style-5" type="text" id="doctor-cancel-date" name="cancel-date" disabled>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="name">Start From</div>
							<div class="value">
								<div class="input-group">
									<div class="col-sm-4">
										<input class="input--style-5" type="text" id="doctor-cancel-start" name="cancel-date" disabled>
									</div>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="name">To</div>
							<div class="value">
								<div class="input-group">
									<div class="col-sm-4">
									<input class="input--style-5" type="text" id="doctor-cancel-end" name="cancel-date" disabled>
									</div>
								</div>
							</div>
						</div>

						<div class="form-btn">
							<button class="cancel-btn" id="doctor-cancel-button">Cancel</button>
						</div>
					</div>	

					</form>
				</div>
			</div>
		</div>
	</div>
</div>