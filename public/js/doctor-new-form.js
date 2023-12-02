var startHour = document.getElementById('doctor-new-start-hour');
var endHour = document.getElementById('doctor-new-end-hour');

startHour.addEventListener('doctor-new-change', function () {
	var selectedStartHour = startHour.value;

	for (var i = parseInt(selectedStartHour); i <= 21; i++) {
		var option = document.createElement('option');
		option.value = i < 10 ? '0' + i : '' + i;
		option.textContent = option.value;
		endHour.appendChild(option);
	}
});

$(document).ready(function () {
	$('#doctor-new-start-minute').on('change', function () {
		if ($(this).val() !== 'Min') {
			synchronizeEndMinute();
		} else {
			resetEndMinute();
		}
	});
});

function synchronizeEndMinute() {
	$('#doctor-new-end-minute').empty();
	$('#doctor-new-end-minute').append('<option selected>Min</option>');
	$('#doctor-new-end-minute').append(`<option>00</option>
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
							<option>55</option>`);
	$('#doctor-new-end-minute').trigger('change');
}

function resetEndMinute() {
	$('#doctor-new-end-minute').empty();
	$('#doctor-new-end-minute').append('<option selected>Min</option>');
}