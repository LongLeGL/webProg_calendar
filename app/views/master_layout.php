<?php
function isActive($currentPage, $buttonName){
	return ($currentPage === $buttonName) ? 'active' : '';
} 
?>

<?php require_once "./app/views/pages/" . $data["page"] . ".php" ?>