var hour = document.getElementById('patient-new-hour');
var minute = document.getElementById('patient-new-minute');

hour.addEventListener('change', function () {
	if (minute.value !== 'Min') {
		checkTimeSlot()
	}
});

minute.addEventListener('change', function () {
	if (hour.value !== 'Hour') {
		checkTimeSlot()
	}
});

function checkTimeSlot(){
	const date = document.getElementById('patient-new-date').value;
	const start = moment(date).format('YYYY-MM-DD') + " " + moment({ hour: hour.value, minute: minute.value }).format('HH:mm');
	const end = moment(start, 'YYYY-MM-DD HH:mm').clone().add(30, 'minutes').format('YYYY-MM-DD HH:mm');

	isAvailableTimeSlot(start, end).then(available => {
		if (available) {
			document.getElementById('danger-alert-time-slot').style = "display: none";
			document.getElementById('patient-new-submit-button').disabled = false;
		}
		else {
			document.getElementById('danger-alert-time-slot').style = "display: block";
		}
	})
}

function isAvailableTimeSlot(start, end) {
		return fetch('index.php?page=calendar/checkTimeSlot/' +start+ "/" +end, {
		method: 'GET',
	}).then(response => {
		if (!response.ok) {
			throw new Error('Network response was not ok');
		}
		return response.json();
	}).then(data => {
		console.log('checkTimeSlot: ' + data);
		return data;
	}).catch(error => {
		console.error('Error checking if time slot is available:', error);
	});
}