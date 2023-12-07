<?php
function isActive($currentPage, $buttonName){
	return ($currentPage === $buttonName) ? 'active' : '';
} 
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="WD-group-5">
		<link rel="shortcut icon" href="">
		<title> Convenient Appointment </title>
		<!-- Style CSS -->
		<link rel="stylesheet" href="./public/css/style.css">
		<link rel="stylesheet" href="./public/css/form.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
		<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css'>
		<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/@fullcalendar/core@4.2.0/main.min.css'>
		<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@4.3.0/main.min.css'>
	</head>

	<body>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

		<script>
			document.addEventListener('DOMContentLoaded', function () {
				const toggleButtons = document.querySelectorAll('.toggle-button');
				toggleButtons.forEach(button => {
					button.addEventListener('click', () => {
						toggleButtons.forEach(btn => {
							btn.classList.remove('selected');
						});
						button.classList.toggle('selected');
					});
				});
			});
  		</script>
		

		<?php require_once "./app/views/pages/" . $data["page"] . ".php" ?>
	</body>

</html>