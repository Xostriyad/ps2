<?php
include_once("model/Members.php");
class Controller {

	public function __construct()  
    {
		//include_once("view/shared/header.php");
	}
	
	protected function view($page, $model)
	{
		include_once("view/shared/pagelayout.php");
		//might revisit this, wanted a view('view/memberlist.php'); call to make things look cleaner
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
			//include("view/shared/pagelayout.php");
		}
		else
		{
			include_once("model/dbconnect.php");
			include_once("model/Player.php");
			$id = $_GET['id'];
			if(empty($id))
			{
				exit();
			}
			$player = Player::withID($id);
			$query = $dbh->prepare("
			SELECT b.group_name, p.name, cb.item_id, pa.name AS base_name
			FROM groups b
			JOIN group_items cb ON cb.group_id = b.group_id
			JOIN items p ON p.item_id = cb.item_id
			LEFT JOIN wattachments a ON cb.item_id = a.attachment_item_id
			LEFT JOIN items pa ON pa.item_id = a.item_id
			");
			$query->execute();
			$rows = $query->fetchAll();
			$groupA = array();
			foreach ($rows as $row) 
			{
				if (!isset($groupA[$row["group_name"]]))
				{
					$groupA[$row["group_name"]] = array();
				}
				array_push($groupA[$row["group_name"]], $row);
			}
			$model = $groupA;
			$page = 'view/viewmember.php';
			
			//$this->view($page, $groupA);
			//enable this later, currently viewmember is not fully MVC compliant
			include("view/shared/pagelayout.php"); //disable this when above is corrected
		}
	}
}

?>