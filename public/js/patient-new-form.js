// document.addEventListener('DOMContentLoaded', function () {
//     const toggleButtonsContainer = document.getElementById('patient-new-time-slot');

//     const startTime = new Date('1970-01-01T08:00:00Z');
//     const endTime = new Date('1970-01-01T18:00:00Z');
//     const interval = 30 * 60 * 1000; // 30 minutes in milliseconds

//     // Replace 'yourDoctorId' and 'yourDate' with actual values
//     getOccupiedTimeSlotsByDoctorAndDate('yourDoctorId', 'yourDate')
//         .then(occupiedTimeSlots => {
// 			console.log(occupiedTimeSlots)
//             for (let time = startTime.getTime(), i = 0; time < endTime.getTime(); time += interval, i++) {
//                 const formattedTime = new Date(time).toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'});
//                 const button = document.createElement('div');
//                 button.id = formattedTime;
//                 button.textContent = formattedTime;
//                 button.classList.add('col-auto', 'toggle-button');

//                 // Check if the formattedTime is in the occupiedTimeSlots
//                 if (occupiedTimeSlots.includes(formattedTime)) {
//                     button.classList.add('disabled');
//                 }

//                 button.addEventListener('click', function () {
//                     if (!this.classList.contains('disabled')) {
//                         toggleButtonsContainer.querySelectorAll('.toggle-button').forEach(btn => {
//                             btn.classList.remove('selected');
//                         });
//                         this.classList.toggle('selected');
//                     }
//                 });

//                 toggleButtonsContainer.appendChild(button);
//             }
//         });
// });

// function getOccupiedTimeSlotsByDoctorAndDate(doctorId, date) {
//     return fetch('index.php?page=calendar/getOccupiedTimeSlotsByDoctorAndDate', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//         },
//         body: JSON.stringify({
//             doctorId: doctorId,
//             date: date,
//         }),
//     }).then(response => {
//         if (!response.ok) {
//             throw new Error('Network response was not ok');
//         }
//         return response.text(); 
//     }).catch(error => {
//         console.error('Error during getOccupiedTimeSlotsByDoctorAndDate operation:', error);
//     });
// }


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