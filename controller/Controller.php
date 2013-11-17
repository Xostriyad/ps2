<?php
include_once("model/Members.php");
class Controller {
	/*
	public $model;
	public function __construct()  
    {  
        $this->model = new Model();

    } 
	*/
	
	public $members;
	public function __construct()  
    {
		$id = "37509488620610014";
		$this->members = Members::withID($id);
	}
	public function invoke()
	{
		if (!isset($_GET['id']))
		{
			$players = $this->members->getMembers();
			include 'view/memberlist.php';
		}
		else
		{
			include 'view/viewmember.php';
		}
	}
}

?>