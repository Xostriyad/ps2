<?php
include_once("model/Members.php");
class Controller {

	public function __construct()  
    {
	}
	
	protected function view($page, $model = null)
	{
		include_once("view/shared/pagelayout.php");
	}
	
	public function index()
	{
		if (!isset($_GET['id']))
		{
			$id = "37509488620610014";
			$members = Members::withID($id);
			$players = $members->getMembers();
			$page = 'view/memberlist.php';
			$this->view($page, $players);
		}
		else
		{
			include_once("model/Forest.php");
			$id = $_GET['id'];
			if(empty($id))
			{
				exit();
			}
			$forest = new Forest($id); 
			//Pass the player id number to Forest to build out the certification trees based on player data
			$model = $forest->trees;
			$page = 'view/viewmember.php';
			
			$this->view($page, $model);
		}
	}
	public function skillTable()
	{
		$page = 'view/skilltable.php';
		$this->view($page);
	}
		public function itemTable()
	{
		$page = 'view/itemtable.php';
		$this->view($page);
	}
}

?>