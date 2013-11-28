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
	
	public function certTree()
	{
		include("model/dbconnect.php");
		$stmt = $dbh->prepare("SELECT * FROM `groups`");
		$stmt->execute();
		$model = $stmt->fetchAll();
		$page = 'view/certtree.php';
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
		header('Location: certTree.php');
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
		header('Location: certTree.php');
		exit();
	}
}

?>