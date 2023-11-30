document.addEventListener('DOMContentLoaded', function () {
	const sessionUserlevel = document.querySelector('#session-user-level').value;
	const sessionUsername = document.querySelector('#session-username').value;
	const calendarEl = document.getElementById('calendar');
	const userModal = new bootstrap.Modal(document.getElementById('user-modal'));
	const doctorModal = new bootstrap.Modal(document.getElementById('doctor-modal'));
	const close = document.querySelector('.btn-close');
	var eventsData = []

	function fetchEventsFromDB() {
        // Fetch events from the server
        fetch('index.php?page=home/fetchEvents', {
            method: 'GET',
        }).then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        }).then(data => {
			eventsData = data.map(event => ({
				id: event.id,
				title: event.fullName,
				start: new Date(event.start),
				end: new Date(event.end),
				backgroundColor: event.backgroundColor,
				allDay: false,
				editable: false,
				creatorId: event.creatorId,
			}));
			console.log(data);
			console.log(eventsData);

			calendar.removeAllEvents();
            calendar.addEventSource(eventsData);
        }).catch(error => {
            console.error('Error during fetch operation:', error);
        });
    }

	function insertEventIntoDB(id, fullName, start, end) {
		fetch('index.php?page=home/insert/' +id+ '/' +fullName +'/'+ start +'/'+ end, {
			method: 'POST',
		}).then(response => {
			if (!response.ok) {
				throw new Error('Network response was not ok');
			}
			return response.json();
		}).then(data => {
			// Handle the response from the server if needed
			console.log('Data sent to server to insert:', data);
		}).catch(error => {
			console.error('Error during insert operation:', error);
		});
	}

	function havePendingEvent() {
        return fetch('index.php?page=home/havePendingEvent', {
            method: 'GET',
        }).then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        }).then(data => {
			console.log('havePendingEvent: ' + data);
			return data;
        }).catch(error => {
            console.error('Error checking if current user have any pending event:', error);
        });
    }

	function timeSlotIsAvailable(start, end) {
        return fetch('index.php?page=home/timeSlotIsAvailable/' +start+ "/" +end, {
            method: 'GET',
        }).then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        }).then(data => {
			console.log('timeSlotIsAvailable: ' + data);
			return data;
        }).catch(error => {
            console.error('Error checking if time slot is available:', error);
        });
    }

	function havePendingEvent() {
        return fetch('index.php?page=home/havePendingEvent', {
            method: 'GET',
        }).then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        }).then(data => {
			console.log('havePendingEvent: ' + data);
			return data;
        }).catch(error => {
            console.error('Error checking if current user have any pending event:', error);
        });
    }

	function showNewEventForm(selectedDate) {
		if (sessionUserlevel == 'doctor') {
			document.getElementById('doctor-modal-title').innerHTML = 'Hi doctor!';
			const submitButton = document.getElementById('doctor-submit-button');
			submitButton.innerHTML = 'Submit';
			submitButton.classList.remove('btn-primary');
			submitButton.classList.add('btn-success');

			document.getElementById('doctor-date').value = moment(selectedDate).format('MMMM D, YYYY');
			// Show the modal
			doctorModal.show();

			close.addEventListener('click', () => {
				doctorModal.hide();
			});
		}
		else {
			const submitButton = document.getElementById('submit-button');
			document.getElementById('modal-title').innerHTML = 'New appointment';
			submitButton.innerHTML = 'Submit';
			submitButton.classList.remove('btn-primary');
			submitButton.classList.add('btn-success');

			document.getElementById('date').value = moment(selectedDate).format('MMMM D, YYYY');

			// Show the modal
			userModal.show();

			close.addEventListener('click', () => {
				userModal.hide();
			});
		}
	}

	function deleteEventFromDB(id) {
		fetch('index.php?page=home/delete/' + id, {
			method: 'POST',
		}).then(response => {
			if (!response.ok) {
				throw new Error('Network response was not ok');
			}
			return response.json();
		}).then(data => {
			// Handle the response from the server if needed
			console.log('Data sent to server for deleting:', data);
			return data;
		}).catch(error => {
			console.error('Error during delete operation:', error);
		});
	}

	const calendar = new FullCalendar.Calendar(calendarEl, {
		header: {
			right: 'today, prev, next'
		},
		plugins: ['dayGrid', 'interaction'],
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
				if (sessionUserlevel == 'doctor') {
					showNewEventForm(selectedDate);
				}
				else {
					havePendingEvent().then(have => {
						if (have) {
							const deleteModal = new bootstrap.Modal(document.getElementById('delete-modal'));
							document.getElementById('delete-modal-title').innerHTML = "Already have a pending appointment!";
							document.getElementById('delete-modal-body').innerHTML = "Do you want to delete it before making a new one?";
	
							const eventIndex = eventsData.findIndex(event => event.creatorId == sessionUsername);
							document.getElementById('delete-full-name').value = eventsData[eventIndex].title
							document.getElementById('delete-date-time').value = moment(eventsData[eventIndex].start).clone().format('MMMM D, YYYY   HH:mm');
	
							deleteModal.show();
							
							document.getElementById('delete-button').addEventListener('click', function () {
								deleteEventFromDB(eventsData[eventIndex].id);
								calendar.getEventById(eventsData[eventIndex].id).remove();
								deleteModal.hide();
								menu.remove();
							});
	
							document.getElementById('cancel-button').addEventListener('click', function () { 
								deleteModal.hide();
							})
	
							close.addEventListener('click', () => {
								deleteModal.hide();
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

				if (eventsData[eventIndex].creatorId == sessionUsername) {
					let existingMenu = document.querySelector('.context-menu');
					existingMenu && existingMenu.remove();
					let menu = document.createElement('div');
					menu.className = 'context-menu';
					menu.innerHTML = `<ul>
					<li><i class="fas fa-trash-alt"></i>Delete</li>
					</ul>`;
					
					document.body.appendChild(menu);
					menu.style.top = e.pageY + 'px';
					menu.style.left = e.pageX + 'px';

					// Delete menu
					menu.querySelector('li:first-child').addEventListener('click', function() {
						const deleteModal = new bootstrap.Modal(document.getElementById('delete-modal'));

						document.getElementById('delete-modal-title').innerHTML = `Hi patient <b>${info.event.title}</b>`;
						document.getElementById('delete-modal-body').innerHTML = ` Are you sure to delete your appointment?`
						deleteModal.show();

						document.getElementById('delete-button').addEventListener('click', function () {
							deleteEventFromDB(info.event.id);
							calendar.getEventById(info.event.id).remove();
							deleteModal.hide();
							menu.remove();
						});

						document.getElementById('cancel-button').addEventListener('click', function () { 
							deleteModal.hide();
						})
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

	const userForm = document.querySelector('#user-form');
	userForm.addEventListener('submit', function(event) {
		event.preventDefault(); // prevent default form submission
	
		const date = document.querySelector('#date').value;
		const startTime = document.querySelector('#start-time').value;

		const start = moment(date).format('YYYY-MM-DD') + " " + moment(startTime, 'HH:mm').format('HH:mm');
		const end = moment(start, 'YYYY-MM-DD HH:mm').clone().add(30, 'minutes').format('YYYY-MM-DD HH:mm');

		timeSlotIsAvailable(start, end).then(available => {
			if (available) {
				const id = uuidv4();
				const fullName = document.querySelector('#full-name').value;

				insertEventIntoDB(id, fullName, start, end);
				fetchEventsFromDB();

				userModal.hide();
				userForm.reset();
			}
			else {
				document.getElementById('danger-alert-time-slot').style = "display: block";
			}
		})
	});
  
	userModal._element.addEventListener('hide.bs.modal', function () {
		userForm.reset(); 
	});

	const doctorForm = document.querySelector('#doctor-form');
	doctorForm.addEventListener('submit', function(event) {
		event.preventDefault(); // prevent default form submission
	
		const date = document.getElementById('doctor-date').value;
		const startTime = document.getElementById('doctor-start-time').value;
		const endTime = document.getElementById('doctor-end-time').value;

		const start = moment(date).format('YYYY-MM-DD') + " " + moment(startTime, 'HH:mm').format('HH:mm');
		const end = moment(date).format('YYYY-MM-DD') + " " + moment(endTime, 'HH:mm').format('HH:mm');

		timeSlotIsAvailable(start, end).then(available => {
			if (available) {
				const id = uuidv4();

				insertEventIntoDB(id, '', start, end);
				fetchEventsFromDB();

				doctorModal.hide();
				doctorForm.reset();
			}
			else {
				document.getElementById('doctor-danger-alert-time-slot').style = "display: block";
			}
		})
	});
  
	doctorModal._element.addEventListener('hide.bs.modal', function () {
		doctorForm.reset(); 
	});
});