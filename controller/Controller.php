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
			array_push($tempTrees, "1","2","3");
			$forest = new Forest($tempTrees); 
			$player = Player::withID($id);
			$model = array();
			$model["player"] = $player;
			$model["forest"] = $forest->trees;
			$page = 'view/viewmember.php';
			
			$this->view($page, $model);
		}
	}
	
	public function skillTable()
	{
		include("model/dbconnect.php");
		$stmt = $dbh->prepare("SELECT * FROM `skills`");
		$stmt->execute();
		$model = $stmt->fetchAll();
		$page = 'view/skilltable.php';
		$this->view($page, $model);
	}
	
	public function itemTable()
	{
		include("model/dbconnect.php");
		$stmt = $dbh->prepare("SELECT * FROM `items`");
		$stmt->execute();
		$model = $stmt->fetchAll();
		$page = 'view/itemtable.php';
		$this->view($page, $model);
	}
	
	public function certForest()
	{
		include("model/dbconnect.php");
		$stmt = $dbh->prepare("SELECT * FROM `groups`");
		$stmt->execute();
		$model = $stmt->fetchAll();
		$page = 'view/certforest.php';
		$this->view($page, $model);
	}
	
	public function insertTree()
	{
		include("model/dbconnect.php");
		if(isset($_POST["name"]))
		{
			$stmt = $dbh->prepare("INSERT INTO groups (group_name) VALUES (:name) ON DUPLICATE KEY UPDATE group_name=':name'");
			$stmt->bindParam(':name', $name);
			$name = $_POST['name'];
			$stmt->execute();
		}
		header('Location: certForest.php');
		exit();
	}
	
	public function deleteTree()
	{
		include("model/dbconnect.php");
		if(isset($_GET["id"]))
		{
			$stmt = $dbh->prepare("DELETE FROM groups WHERE group_id = :id");
			$stmt->bindParam(':id', $id);
			$id = $_GET['id'];
			$stmt->execute();
		}
		header('Location: certForest.php');
		exit();
	}
	
	public function viewTree()
	{
		if(!isset($_GET["id"])) //if no tree id is set, send the user back to the main menu.
		{
			header('Location: certForest.php');
			exit();
		}
		include("model/dbconnect.php");
		include_once("model/Forest.php");
		$tempTrees = array();
		array_push($tempTrees, $_GET["id"]);
		$forest = new Forest($tempTrees);
		$allItems = new Forest(-1);
		$model = array();
		$model["forest"] = $forest;
		$model["allItems"] = $allItems;
		$page = 'view/viewtree.php';
		$this->view($page, $model);
	}
	public function insertLeaf()
	{
		include("model/dbconnect.php");
		if(isset($_POST["weapons"]))
		{
			foreach ($_POST['weapons'] as $input)
			{
				$inputs = explode(",", $input);
				$group_id = $inputs[0];
				$item_id = $inputs[1];
				$stmt = $dbh->prepare("INSERT INTO group_items (group_id, item_id) VALUES (:group_id, :item_id) 
				ON DUPLICATE KEY UPDATE group_id=':group_id', item_id=':item_id'");
				$stmt->bindParam(':group_id', $group_id);
				$stmt->bindParam(':item_id', $item_id);
				$stmt->execute();
			}
		}
		header('Location: viewTree.php?id='.$group_id);
		exit();
	}
	public function deleteLeaf()
	{
		include("model/dbconnect.php");
		echo $_GET["group_id"];
		echo $_GET["item_id"];
		
		if(isset($_GET["group_id"]) && isset($_GET["item_id"]))
		{
			$stmt = $dbh->prepare("DELETE FROM group_items WHERE group_id = :group_id AND item_id = :item_id");
			$stmt->bindParam(':group_id', $group_id);
			$stmt->bindParam(':item_id', $item_id);
			$item_id = $_GET['item_id'];
			$group_id = $_GET['group_id'];
			$stmt->execute();
		}
		header('Location: viewTree.php?id='.$group_id);
		exit();
	}
}

?>