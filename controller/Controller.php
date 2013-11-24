<?php
include_once("model/Members.php");
class Controller {

	public function __construct()  
    {
	}
	
	protected function view($page, $model)
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
			include_once("model/dbconnect.php");
			include_once("model/Player.php");
			include_once("model/Tree.php");
			$id = $_GET['id'];
			if(empty($id))
			{
				exit();
			}
			$player = Player::withID($id);
			//Need a query items, skills and vehicles
			$queryItems = $dbh->prepare('
			SELECT b.group_name, p.name, cb.item_id, pa.name AS base_name
			FROM groups b
			JOIN group_items cb ON cb.group_id = b.group_id
			JOIN items p ON p.item_id = cb.item_id
			LEFT JOIN wattachments a ON cb.item_id = a.attachment_item_id
			LEFT JOIN items pa ON pa.item_id = a.item_id
			WHERE cb.item_tag = "W"
			');
			/*
			SELECT b.group_name, p.name, cb.item_id, pa.name AS base_name
			FROM groups b
			JOIN group_items cb ON cb.group_id = b.group_id
			JOIN items p ON p.item_id = cb.item_id
			LEFT JOIN item_profile a ON cb.item_id = a.item_id
			LEFT JOIN profile pa ON pa.profile_id = a.profile_id
			WHERE cb.item_tag =  "S"
			*/
			$queryItems->execute();
			$rows = $queryItems->fetchAll();
			$forest = array();
			foreach ($rows as $row) 
			{
				$treeName = $row["group_name"];
				if ($row["base_name"]===NULL)
				{
					$branchName = $row["name"];
				}
				else
				{
					$branchName = $row["base_name"];
				}
				$eqName = $row["name"];
				$haveEq = $player->getItemByID($row["item_id"]);
				
				if (!isset($forest[$treeName]))
				{
					$forest[$treeName] = new Tree($treeName);
				}
				$forest[$treeName]->addBranch($branchName, $eqName, $haveEq);
			}
			$model = $forest;
			$page = 'view/viewmember.php';
			
			$this->view($page, $forest);
		}
	}
}

?>