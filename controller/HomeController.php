<?php
include_once("model/shared/dbconnect.php");
class Controller {

	public function __construct()  
    {
	}
	
	protected function view($page, $model = null)
	{
		$title = 'VCO Web Apps';
		$menu = '
			<li><a href="CertTree/">Certification Trees</a></li>
			<li><a href="LeaderBoard/">LeaderBoards</a></li>
		';
		$pathToRoot = '';
		include_once("view/shared/pagelayout.php");
	}
	
	public function index()
	{
		$page = 'view/Home/index.php';
		$this->view($page);
	}
	
}

?>