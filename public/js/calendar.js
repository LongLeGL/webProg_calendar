document.addEventListener('DOMContentLoaded', function () {
	const ssRole = document.getElementById('ssRole').value;
	const ssId = document.getElementById('ssId').value;
	const ssDoctorId = document.getElementById('ssDoctorId').value;


	const calendarEl = document.getElementById('calendar');
	const patientNewModal = new bootstrap.Modal(document.getElementById('patient-new-modal'));
	const doctorNewModal = new bootstrap.Modal(document.getElementById('doctor-new-modal'));

	var eventsData = []
	var doctorOccupiedEvents = []
	var doctorOccupiedNewEvent

	function fetchEventsFromDB() {
        // Fetch events from the server
        fetch('index.php?page=calendar/fetchEvents', {
            method: 'GET',
        }).then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        }).then(data => {
			console.log(data);
			eventsData = data.map(event => ({
				id: event.id,
				start: new Date(event.start),
				end: new Date(event.end),
				patientId: event.patientId,
				patientName: event.patientName,
				doctorId: event.doctorId,
				doctorName: event.doctorName,
				status: event.status,
				title: ssRole == 'doctor' ? event.patientId == null ? "" : event.patientName
										  : event.status,
				backgroundColor: ssRole == 'doctor' ? event.patientId == null 	? "#FF2c2c" //red
																				: event.status == 'pending' ? "#FFD700" //yellow
																											: "#3788d8" //blue
													: event.patientId == ssId ? "#3788d8" : "#FF2c2c",
				allDay: false,
				editable: false,
			}));
			console.log(eventsData);

			calendar.removeAllEvents();
            calendar.addEventSource(eventsData);
        }).catch(error => {
            console.error('Error during fetch operation:', error);
        });
    }

	function insertEventIntoDB(id, start, end) {
		fetch('index.php?page=calendar/insert', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
			},
			body: JSON.stringify({
				id: id,
				start: start,
				end: end
			}),
		}).then(response => {
			if (!response.ok) {
				throw new Error('Network response was not ok');
			}
			return response.text();
		}).then(data => {
			// Handle the response from the server if needed
			console.log('Data sent to server to insert:', data);
		}).catch(error => {
			console.error('Error during insert operation:', error);
		});
	}

	function getPendingEvent() {
        return fetch('index.php?page=calendar/getPendingEvent', {
            method: 'GET',
        }).then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        }).then(data => {
			console.log('getPendingEvent: ' + data);
			return data;
        }).catch(error => {
            console.error('Error checking if current user have any pending event:', error);
        });
    }

	function getEventByDateTime(start, end) {
		return fetch('index.php?page=calendar/getEventByDateTime/' +start+ "/" +end, {
			method: 'GET',
		}).then(response => {
			if (!response.ok) {
				throw new Error('Network response was not ok');
			}
			return response.json();
		}).catch(error => {
			console.error('Error checking:', error);
		});
	}


	// function generateTimeSlots(startTime, endTime, interval) {
	// 	const timeSlots = [];
	// 	for (let time = startTime.getTime(); time < endTime.getTime(); time += interval) {
	// 		const localTime = new Date(time);
	// 		const formattedTime = localTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: false });
	// 		timeSlots.push(formattedTime);
	// 	}
	// 	return timeSlots;
	// }

	// function getOccupiedTimeSlotsByDoctorAndDate(doctorId, date) {
	// 	return fetch('index.php?page=calendar/getOccupiedTimeSlotsByDoctorAndDate', {
	// 		method: 'POST',
	// 		headers: {
	// 			'Content-Type': 'application/json',
	// 		},
	// 		body: JSON.stringify({
	// 			doctorId: doctorId,
	// 			date: date,
	// 		}),
	// 	}).then(response => {
	// 		if (!response.ok) {
	// 			throw new Error('Network response was not ok');
	// 		}
	// 		return response.json(); 
	// 	}).then(data => {
	// 		// Handle the response from the server if needed
	// 		console.log('Data sent to server to getOccupiedTimeSlotsByDoctorAndDate:', data);
	// 	}).catch(error => {
	// 		console.error('Error during getOccupiedTimeSlotsByDoctorAndDate operation:', error);
	// 	});
	// }

	function showNewEventForm(selectedDate) {
		if (ssRole == 'doctor') {
			doctorNewForm.reset();
			document.getElementById('doctor-new-date').value = moment(selectedDate).format('MMMM D, YYYY');

			doctorNewModal.show();
		}
		else {
			patientNewForm.reset();
			document.getElementById('patient-new-date').value = moment(selectedDate).format('MMMM D, YYYY');

			// const toggleButtonsContainer = document.getElementById('patient-new-time-slot');
			// toggleButtonsContainer.innerHTML = '';
			// const startTime = new Date('1970-01-01T08:00:00Z');
			// const endTime = new Date('1970-01-01T18:00:00Z');
			// const interval = 30 * 60 * 1000; // 30 minutes in milliseconds

			// getOccupiedTimeSlotsByDoctorAndDate(ssDoctorId, selectedDate)
			// 	.then(occupiedTimeSlots => {
			// 		console.log(occupiedTimeSlots)
			// 		const timeSlots = generateTimeSlots(startTime, endTime, interval);
					
			// 		timeSlots.forEach(formattedTime => {
			// 			const button = document.createElement('div');
			// 			button.id = formattedTime;
			// 			button.textContent = formattedTime;
			// 			button.classList.add('col-auto', 'toggle-button');

			// 			// Check if the formattedTime is in the occupiedTimeSlots
			// 			if (occupiedTimeSlots.includes(formattedTime)) {
			// 				button.classList.add('disabled');
			// 			}

			// 			button.addEventListener('click', function () {
			// 				if (!this.classList.contains('disabled')) {
			// 					toggleButtonsContainer.querySelectorAll('.toggle-button').forEach(btn => {
			// 						btn.classList.remove('selected');
			// 					});
			// 					this.classList.toggle('selected');
			// 				}
			// 			});

			// 			toggleButtonsContainer.appendChild(button);
			// 		});
			// 	});

			// Show the modal
			patientNewModal.show();
		}
	}

	function deleteEventFromDB(id) {
		fetch('index.php?page=calendar/delete', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
			},
			body: JSON.stringify({
				id: id,
			}),
		}).then(response => {
			if (!response.ok) {
				throw new Error('Network response was not ok');
			}
			return response.text();
		}).then(data => {
			// Handle the response from the server if needed
			console.log('Data sent to server for deleting:', data);
		}).catch(error => {
			console.error('Error during delete operation:', error);
		});
	}

	function showEmailModal(email){
		const emailModal = new bootstrap.Modal(document.getElementById('email-modal'));
		document.getElementById('email').innerHTML = email;
		emailModal.show();
	}

	const calendar = new FullCalendar.Calendar(calendarEl, {
		header: {
			right: 'today, prev, next'
		},
		plugins: ['dayGrid', 'interaction'],
		eventTimeFormat: {
			hour: '2-digit',
			minute: '2-digit',
			hour12: false
		},		  
		allDay: false,
		editable: true,
		selectable: true,
		unselectAuto: false,
		displayEventTime: true,
		displayEventEnd: true,
		events: [],
		businessHours: {
			// days of week. an array of zero-based day of week integers (0=Sunday)
			daysOfWeek: [ 1, 2, 3, 4, 5, 6 ], // Monday - Saturday
			startTime: '9:00',
			endTime: '18:00',
		},
		dateClick: function (info) {
			const selectedDate = moment(info.dateStr).format('YYYY-MM-DD');
			const today = moment().format('YYYY-MM-DD');
			const businessDays = calendar.getOption('businessHours').daysOfWeek;
			if (selectedDate >= today && businessDays.includes(moment(info.dateStr).day())){
				if (ssRole == 'doctor') {
					showNewEventForm(selectedDate);
				}
				else {
					getPendingEvent().then(pendingEvent => {
						if (pendingEvent) {
							const patientCancelModel = new bootstrap.Modal(document.getElementById('patient-cancel-modal'));

							document.getElementById('patient-cancel-doctor-name').value = pendingEvent.doctorName;
							document.getElementById('patient-cancel-patient-name').value = pendingEvent.patientName;
							document.getElementById('patient-cancel-date').value = moment(pendingEvent.start).format('MMMM D, YYYY');
							document.getElementById('patient-cancel-start').value = moment(pendingEvent.start).format('HH:mm');
							document.getElementById('patient-cancel-end').value = moment(pendingEvent.end).format('HH:mm');

							patientCancelModel.show();
							
							document.getElementById('patient-cancel-button').addEventListener('click', function () {
								deleteEventFromDB(pendingEvent.id);
								calendar.getEventById(pendingEvent.id).remove();
								patientCancelModel.hide();
								showEmailModal(pendingEvent.doctorName);
							});
						}
						else {
							showNewEventForm(selectedDate);
						}
					})
				}
			}
		},
		eventRender: function(info) {
			info.el.addEventListener('contextmenu', function(e) {
				e.preventDefault();
				const eventIndex = eventsData.findIndex(event => event.id == info.event.id);

				if (ssRole == 'doctor' || (eventsData[eventIndex].patientId == ssId && ssRole == 'patient')) {
					let existingMenu = document.querySelector('.context-menu');
					existingMenu && existingMenu.remove();
					let menu = document.createElement('div');
					menu.className = 'context-menu';
					menu.innerHTML = `<ul>
										<li><i class="fas fa-trash-alt"></i>Cancel</li>
									</ul>`;
					
					document.body.appendChild(menu);
					menu.style.top = e.pageY + 'px';
					menu.style.left = e.pageX + 'px';

					// Delete menu
					menu.querySelector('li:first-child').addEventListener('click', function() {
						const role = ssRole == 'doctor' ? 'doctor' : 'patient';
						const modal = new bootstrap.Modal(document.getElementById(role + '-cancel-modal'));

						if (role == 'doctor'){
							document.getElementById('doctor-cancel-name').value = eventsData[eventIndex].patientName != null ? eventsData[eventIndex].patientName : eventsData[eventIndex].doctorName;
						}
						else if (role == 'patient'){
							document.getElementById('patient-cancel-doctor-name').value = eventsData[eventIndex].doctorName;
							document.getElementById('patient-cancel-patient-name').value = eventsData[eventIndex].patientName;
						}

						document.getElementById(role + '-cancel-date').value = moment(eventsData[eventIndex].start).format('MMMM D, YYYY');
						document.getElementById(role + '-cancel-start').value = moment(eventsData[eventIndex].start).format('HH:mm');
						document.getElementById(role + '-cancel-end').value = moment(eventsData[eventIndex].end).format('HH:mm');

						modal.show();

						document.getElementById(role + '-cancel-button').addEventListener('click', function () {
							deleteEventFromDB(info.event.id);
							calendar.getEventById(info.event.id).remove();
							modal.hide();
							menu.remove();
							if (eventsData[eventIndex].patientId != null){
								showEmailModal(role == 'doctor' ? eventsData[eventIndex].patientName : eventsData[eventIndex].doctorName);
							}
						});
					});

					document.addEventListener('click', function() {
						menu.remove();
					});
				}
			});
		},
	});

	calendar.render();
	fetchEventsFromDB();

	const patientNewForm = document.getElementById('patient-new-form');
	patientNewForm.addEventListener('submit', function(event) {
		event.preventDefault(); // prevent default form submission
	
		const id = uuidv4();
		const date = document.getElementById('patient-new-date').value;
		const hour = document.getElementById('patient-new-hour').value;
		const minute = document.getElementById('patient-new-minute').value;
		
		const start = moment(date).format('YYYY-MM-DD') + " " + moment({ hour: hour, minute: minute }).format('HH:mm');
		const end = moment(start, 'YYYY-MM-DD HH:mm').clone().add(30, 'minutes').format('YYYY-MM-DD HH:mm');

		insertEventIntoDB(id, start, end);
		fetchEventsFromDB();

		patientNewModal.hide();
		patientNewForm.reset();
		showEmailModal(document.getElementById('patient-new-doctor-name').value);
	});
  
	patientNewModal._element.addEventListener('hide.bs.modal', function () {
		patientNewForm.reset(); 
	});

	const doctorOccupiedModal = new bootstrap.Modal(document.getElementById('doctor-occupied-modal'));
	const doctorNewForm = document.getElementById('doctor-new-form');
	doctorNewForm.addEventListener('submit', function(event) {		
		event.preventDefault(); // prevent default form submission
		
		doctorOccupiedEvents = [];
		const id = uuidv4();
		const date = document.getElementById('doctor-new-date').value;
		const startHour = document.getElementById('doctor-new-start-hour').value;
		const startMinute = document.getElementById('doctor-new-start-minute').value;
		const endHour = document.getElementById('doctor-new-end-hour').value;
		const endMinute = document.getElementById('doctor-new-end-minute').value;

		const start = moment(date).format('YYYY-MM-DD') + " " + moment({ hour: startHour, minute: startMinute }).format('HH:mm');
		const end = moment(date).format('YYYY-MM-DD') + " " + moment({ hour: endHour, minute: endMinute }).format('HH:mm');

		doctorOccupiedNewEvent = {
			id: id,
			start: start,
			end: end,
		}

		getEventByDateTime(start, end).then(events => {
			if (!Array.isArray(events)) {
				events = [events];
			}

			if (events.length > 0) {
				events.forEach(event => {
					const startTime = new Date(event.start).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: false });
					const endTime = new Date(event.end).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: false });

					// Create a form-row
					const formRow = document.createElement('div');
					formRow.classList.add('form-row');
			
					// Create the name element
					const nameElement = document.createElement('div');
					nameElement.classList.add('name');
					nameElement.textContent = startTime + ' - ' + endTime; // Set the appropriate text
					formRow.appendChild(nameElement);
			
					// Create the value element with an input
					const valueElement = document.createElement('div');
					valueElement.classList.add('value');
					const inputGroup = document.createElement('div');
					inputGroup.classList.add('input-group');
			
					const input = document.createElement('input');
					input.classList.add('input--style-5', 'form-control');
					input.type = 'text';
					input.value = event.patientName; // Set the appropriate value
					input.disabled = true;
			
					inputGroup.appendChild(input);
					valueElement.appendChild(inputGroup);
					formRow.appendChild(valueElement);
			
					// Append the form-row to the container
					document.getElementById('doctor-occupied-form').appendChild(formRow);

					doctorOccupiedEvents.push(event);
				});

				// Append the "Cancel" button
				const cancelButton = document.createElement('div');
				cancelButton.classList.add('form-btn');
				cancelButton.innerHTML = '<button class="cancel-btn" id="doctor-occupied-button">Cancel All</button>';
				document.getElementById('doctor-occupied-form').appendChild(cancelButton);
				
				doctorNewModal.hide();
				doctorNewForm.reset();
				doctorOccupiedModal.show();

				doctorOccupiedModal._element.addEventListener('hide.bs.modal', function () {
					document.getElementById('doctor-occupied-form').reset(); 
					doctorOccupiedEvents = []
					doctorOccupiedNewEvent = {}
				});
			}
			else {
				insertEventIntoDB(id, start, end);
				fetchEventsFromDB();

				doctorNewModal.hide();
				doctorNewForm.reset();
			}
		})
	});
  
	doctorNewModal._element.addEventListener('hide.bs.modal', function () {
		doctorNewForm.reset(); 
	});

	const doctorOccupiedForm = document.getElementById('doctor-occupied-form');
	doctorOccupiedForm.addEventListener('submit', function(event) {		
		event.preventDefault(); // prevent default form submission
	
		if (doctorOccupiedEvents.length > 0) {
			doctorOccupiedEvents.forEach(event => {
				deleteEventFromDB(event.id)
				calendar.getEventById(event.id).remove();
			});
		}
		
		insertEventIntoDB(doctorOccupiedNewEvent.id, doctorOccupiedNewEvent.start, doctorOccupiedNewEvent.end);
		fetchEventsFromDB();

		doctorOccupiedModal.hide();
		doctorOccupiedForm.reset();
	});
  
	doctorNewModal._element.addEventListener('hide.bs.modal', function () {
		doctorOccupiedForm.reset(); 
	});
});