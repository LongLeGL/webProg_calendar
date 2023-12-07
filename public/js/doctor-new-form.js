$(document).ready(function () {
	var endHour = document.getElementById('doctor-new-end-hour');
	$('#doctor-new-start-hour').on('change', function () {
		endHour.innerHTML = '';
		endHour.innerHTML = '<option selected>Hour</option>';
		for (var i = parseInt(document.getElementById('doctor-new-start-hour').value); i <= 21; i++) {
			var option = document.createElement('option');
			option.value = i < 10 ? '0' + i : '' + i;
			option.textContent = option.value;
			endHour.appendChild(option);
		}
	});

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