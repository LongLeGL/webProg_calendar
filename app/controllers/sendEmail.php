<?php 
include("./email.php");

class SendEmail extends Controller
{
	private $model;

    public function __construct()
	{
		// $this->model = $this->model("loginModel");
    }

	public function send($doctorMail, $pname, $adate, $atime, $pmail, $aid)
	{
		sendmail_newAppointment($doctorMail, $pname, $adate, $atime, $pmail, $aid);
	}
}
?>