document.addEventListener('DOMContentLoaded', function () {
	const calendarEl = document.getElementById('calendar');
	const myModal = new bootstrap.Modal(document.getElementById('form'));
	const close = document.querySelector('.btn-close');
	var eventsData = []

	function fetchAndLoadEvents() {
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
				start: new Date(event.date + " " + event.startTime),
				end: new Date(new Date(event.date + " " + event.startTime).getTime() + 30 * 60000),
				backgroundColor: '#3788d8',
				allDay: false,
				editable: false,
			}));
			console.log(data);
			console.log(eventsData);

			calendar.removeAllEvents();
            calendar.addEventSource(eventsData);
        }).catch(error => {
            console.error('Error during fetch operation:', error);
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
		displayEventTime: false,
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
				const modalTitle = document.getElementById('modal-title');
				const submitButton = document.getElementById('submit-button');
				modalTitle.innerHTML = 'New appointment';
				submitButton.innerHTML = 'Submit';
				submitButton.classList.remove('btn-primary');
				submitButton.classList.add('btn-success');

				document.getElementById('date').value = info.dateStr;

				// Show the modal
				myModal.show();

				close.addEventListener('click', () => {
					myModal.hide();
				});
			}
		},
		eventRender: function(info) {
			// Set background color based on the creator
			if (info.event.extendedProps.creator === 'doctor') {
				info.el.style.backgroundColor = 'red';
				info.el.style.color = 'white'; // Optional: Set text color to white
				info.el.innerHTML = ''; // Optional: Clear event title
			}

			// info.el.addEventListener('contextmenu', function(e) {
			// 	e.preventDefault();
			// 	let existingMenu = document.querySelector('.context-menu');
			// 	existingMenu && existingMenu.remove();
			// 	let menu = document.createElement('div');
			// 	menu.className = 'context-menu';
			// 	menu.innerHTML = `<ul>
			// 	<li><i class="fas fa-edit"></i>Edit</li>
			// 	<li><i class="fas fa-trash-alt"></i>Delete</li>
			// 	</ul>`;

			// 	const eventIndex = myEvents.findIndex(event => event.id === info.event.id);
				
			// 	document.body.appendChild(menu);
			// 	menu.style.top = e.pageY + 'px';
			// 	menu.style.left = e.pageX + 'px';

			// 	// Edit context menu
			// 	menu.querySelector('li:first-child').addEventListener('click', function() {
			// 		menu.remove();

			// 		const editModal = new bootstrap.Modal(document.getElementById('form'));
			// 		const modalTitle = document.getElementById('modal-title');
			// 		const titleInput = document.getElementById('full-name');
			// 		const dateInput = document.getElementById('date');
			// 		const startTimeInput = document.getElementById('start-time');
			// 		const submitButton = document.getElementById('submit-button');
			// 		modalTitle.innerHTML = 'Edit Appointment';
			// 		titleInput.value = info.event.title;
			// 		dateInput.value = moment(info.event.start).format('YYYY-MM-DD');
			// 		startTimeInput.value = moment(info.event.start).format('HH:mm');
			// 		submitButton.innerHTML = 'Save Changes';

			// 		editModal.show();

			// 		submitButton.classList.remove('btn-success')
			// 		submitButton.classList.add('btn-primary')

			// 		// Edit button
			// 		submitButton.addEventListener('click', function() {
			// 			const updatedEvents = {
			// 				id: info.event.id,
			// 				title: titleInput.value,
			// 				start: moment(`${dateInput.value} ${startTimeInput.value}`, 'YYYY-MM-DD HH:mm'),
			// 				end: start.clone().add(30, 'minutes'),
			// 				backgroundColor: '#3788d8'
			// 			}
						
			// 			const eventIndex = myEvents.findIndex(event => event.id === updatedEvents.id);
			// 			myEvents.splice(eventIndex, 1, updatedEvents);
						
			// 			localStorage.setItem('events', JSON.stringify(myEvents));
						
			// 			// Update the event in the calendar
			// 			const calendarEvent = calendar.getEventById(info.event.id);
			// 			calendarEvent.setProp('title', updatedEvents.title);
			// 			calendarEvent.setStart(updatedEvents.start);
			// 			calendarEvent.setEnd(updatedEvents.end);
			// 			calendarEvent.setProp('backgroundColor', updatedEvents.backgroundColor);

			// 			editModal.hide();
			// 		})
			// 	});

			// 	// Delete menu
			// 	menu.querySelector('li:last-child').addEventListener('click', function() {
			// 		const deleteModal = new bootstrap.Modal(document.getElementById('delete-modal'));
			// 		const modalBody = document.getElementById('delete-modal-body');
			// 		const cancelModal = document.getElementById('cancel-button');
			// 		modalBody.innerHTML = `Are you sure you want to delete <b>"${info.event.title}"</b>`
			// 		deleteModal.show();

			// 		const deleteButton = document.getElementById('delete-button');
			// 		deleteButton.addEventListener('click', function () {
			// 			myEvents.splice(eventIndex, 1);
			// 			localStorage.setItem('events', JSON.stringify(myEvents));
			// 			calendar.getEventById(info.event.id).remove();
			// 			deleteModal.hide();
			// 			menu.remove();
			// 		});

			// 		cancelModal.addEventListener('click', function () { 
			// 			deleteModal.hide();
			// 		})
			// 	});

			// 	document.addEventListener('click', function() {
			// 		menu.remove();
			// 	});
			// });
		},
  
		// eventDrop: function(info) { 
		// 	let myEvents = JSON.parse(localStorage.getItem('events')) || [];
		// 	const eventIndex = myEvents.findIndex(event => event.id === info.event.id);
		// 	const updatedEvent = {
		// 		...myEvents[eventIndex],
		// 		id: info.event.id, 
		// 		title: info.event.title,
		// 		start: moment(info.event.start).format('YYYY-MM-DD'),
		// 		end: moment(info.event.end).format('YYYY-MM-DD'),
		// 		backgroundColor: info.event.backgroundColor
		// 	};
		// 	myEvents.splice(eventIndex, 1, updatedEvent); // Replace old event data with updated event data
		// 	localStorage.setItem('events', JSON.stringify(myEvents));
		// 	console.log(updatedEvent);
		// }
	});

	calendar.render();
	fetchAndLoadEvents();
	const form = document.querySelector('form');
  
	form.addEventListener('submit', function(event) {
		event.preventDefault(); // prevent default form submission
	
		// retrieve the form input values
		const fullName = document.querySelector('#full-name').value;
		const date = document.querySelector('#date').value;
		const startTime = document.querySelector('#start-time').value;
		const eventId = uuidv4();

		fetch('index.php?page=home/insert/'+eventId+'/'+fullName+'/'+date+'/'+startTime, {
			method: 'POST',
		}).then(response => {
			if (!response.ok) {
				throw new Error('Network response was not ok');
			}
			return response.text();
		}).then(data => {
			// Handle the response from the server if needed
			console.log('Data sent to server:', data);
		}).catch(error => {
			console.error('Error during fetch operation:', error);
		});

		fetchAndLoadEvents();
		myModal.hide();
		form.reset();
	});
  
	myModal._element.addEventListener('hide.bs.modal', function () {
		form.reset(); 
	});
});

// $(document).ready(function () {
// 	$("#start-time").on("change", function () {
// 		isAvailableTimeSlot();
// 	});

// 	function isAvailableTimeSlot() {
// 		$.ajax({
// 			type: "POST",
// 			url: "index.php?page=home/checkTimeSlot",
// 			data: {date: $("#date").val(), time: $("#start-time").val()},
// 			dataType: "json",
// 			success: function (data) {
// 				if (!data) {
// 					$("#danger-alert-time-slot").show();
// 				}
// 				else {
// 					$("#available-time-slot").show();
// 				}
// 			},
// 			error: function (xhr, status, error) {
// 				console.error("Error checking time slot availability:", status, error);
// 			}
// 		});
// 	}
// });