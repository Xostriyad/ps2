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
		if (!isset($_GET['book']))
		{
			// no special book is requested, we'll show a list of all available books
			$players = $this->members->getMembers();
			include 'view/memberlist.php';
		}
		else
		{
			// show the requested book
			//$book = $this->model->getBook($_GET['book']);
			//include 'view/viewbook.php';
		}
	}
}

?>