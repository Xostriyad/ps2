<?php
include_once("model/Members.php");
include_once("model/dbconnect.php");
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
			//hard coding just one member group for the time being until phase 1 deployment is done
			$members = Members::withID($id);
			$players = $members->getMembers();
			$page = 'view/memberlist.php';
			$this->view($page, $players);
		}
		else
		{
			include_once("model/Player.php");
			include_once("model/Forest.php");
			$id = $_GET['id'];
			if(empty($id))
			{
				exit();
			}
			$tempTrees = array();
			array_push($tempTrees, "1","2","3","4","5","6");
			$forest = new Forest($tempTrees); 
			$player = Player::withID($id);
			$model = array();
			$model["player"] = $player;
			$model["forest"] = $forest->trees;
			$page = 'view/viewmember.php';
			
			$this->view($page, $model);
		}
	}
	
}

?>