<div class="modal fade edit-form" id="doctor-new-modal" tabindex="-1" aria-labelledby="doctorNewModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog" role="document">
		<div class="modal-content">
			<div class="card card-5">
				<div class="card-heading">
					<h2 class="title">Busy Period</h2>
				</div>
				<div class="card-body">
					<form id="doctor-new-form" method="POST" action="">
						<div class="alert alert-danger " role="alert" id="danger-alert-time-slot" style="display: none">
							This time slot is not available!
						</div>
						<div class="form-row">
							<div class="name">Your Name</div>
							<div class="value">
								<div class="input-group">
								<input class="input--style-5" type="text" class="form-control" id="doctor-new-name" name="doctor-new-name" value="<?php echo $_SESSION['currentUser']['name'] ?>" disabled>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="name">Date</div>
							<div class="value">
								<div class="input-group">
									<input class="input--style-5" type="text" id="doctor-new-date" name="doctor-new-date" disabled>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="name">Start From</div>
							<div class="value">
								<div class="input-group">
									<div class="col-sm-3">
										<select class="form-control" id="doctor-new-start-hour">
											<option selected>Hour</option>
											<option>08</option>
											<option>09</option>
											<option>10</option>
											<option>11</option>
											<option>12</option>
											<option>13</option>
											<option>14</option>
											<option>15</option>
											<option>16</option>
											<option>17</option>
											<option>18</option>
											<option>19</option>
											<option>20</option>
											<option>21</option>
										</select>
									</div>
									<div class="col-sm-1"></div>
									<div class="col-sm-3">
										<select class="form-control" id="doctor-new-start-minute">
											<option selected>Min</option>
											<option>00</option>
											<option>05</option>
											<option>10</option>
											<option>15</option>
											<option>20</option>
											<option>25</option>
											<option>30</option>
											<option>35</option>
											<option>40</option>
											<option>45</option>
											<option>50</option>
											<option>55</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="name">To</div>
							<div class="value">
								<div class="input-group">
									<div class="col-sm-3">
										<select class="form-control" id="doctor-new-end-hour">
											<option selected>Hour</option>
										</select>
									</div>
									<div class="col-sm-1"></div>
									<div class="col-sm-3">
										<select class="form-control" id="doctor-new-end-minute">
											<option selected>Min</option>
										</select>
									</div>
								</div>
							</div>
						</div>

						<div class="form-btn">
							<button class="submit-btn" id="doctor-new-submit-button">Confirm</button>
						</div>
					</div>	

					</form>
				</div>
			</div>
		</div>
	</div>
</div>