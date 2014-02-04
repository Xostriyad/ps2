<?php

	include_once("../model/CertTree/Tree.php");
	Class Forest
	{
		public $trees;
		public $treeList;
		/* 
		public function __construct()  
		{  
			$this->trees = array();
			$this->populateAll();
		}
		*/
		public function __construct($treeList) //will need to create overloaded constructors for class like Player class is set up
		{  
			$this->trees = array();
			if($treeList == -1) //temporary check, eventually will be handled in overloaded constructors. Or broken into another class
			{
				$this->populateAll();
			}
			else
			{
				$this->treeList = $treeList; //Takes an array of tree ids to pull
				$this->populate();
			}
		}
		protected function populate() 
		{
			//This function still needs work
			//database redesign or going back over the SQL statements may be required
			foreach($this->treeList as $tree) 
			{
				$weapons = '
				SELECT b.group_name, p.name, cb.item_id, pa.name AS base_name
				FROM (
				SELECT * 
				FROM groups
				WHERE group_id = '.$tree.'
				)b
				JOIN group_items cb ON cb.group_id = b.group_id
				JOIN (
				SELECT * FROM items 
				WHERE
				item_type_id = 27
				OR
				item_type_id = 26
				) p ON p.item_id = cb.item_id
				LEFT JOIN wattachments a ON cb.item_id = a.attachment_item_id
				LEFT JOIN items pa ON pa.item_id = a.item_id
				ORDER BY p.name ASC 
				';
				$suitUpgrades = '
				SELECT b.group_name, p.name, cb.item_id, pa.name AS base_name
				FROM (
				SELECT * 
				FROM groups
				WHERE group_id = '.$tree.'
				)b
				JOIN group_items cb ON cb.group_id = b.group_id
				JOIN (
				SELECT * FROM items 
				WHERE
				item_type_id = 36
				) p ON p.item_id = cb.item_id
				LEFT JOIN item_profile a ON cb.item_id = a.item_id
				LEFT JOIN profile pa ON pa.profile_id = a.profile_id
				ORDER BY p.name ASC 
				';
				$vehicle = '
				SELECT b.group_name, p.name, cb.item_id, a.description AS base_name
				FROM (
				SELECT * 
				FROM groups
				WHERE group_id = '.$tree.'
				)b
				JOIN group_items cb ON cb.group_id = b.group_id
				JOIN (
				SELECT * FROM items 
				WHERE
				item_type_id = 33
				) p ON p.item_id = cb.item_id
				LEFT JOIN vehicle_attachment a ON cb.item_id = a.item_id
				ORDER BY p.name ASC
				';
				$this->runQ($vehicle);
				$this->runQ($weapons);
				$this->runQ($suitUpgrades);
			}
		}
		protected function runQ($query)
		{
			include("../model/Shared/dbconnect.php");
			$queryItems = $dbh->prepare($query);
			$queryItems->execute();
			$rows = $queryItems->fetchAll();
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
				$item_id = $row["item_id"];
				
				if (!isset($this->trees[$treeName]))
				{
					$this->trees[$treeName] = new Tree($treeName);
				}
				$this->trees[$treeName]->addBranch($branchName, $eqName, $item_id);
			}
		}
		protected function populateAll() 
		{
			$weapons = 
			'
			SELECT * FROM ncweapondd
			';
			/*
			SELECT pa.name, a.attachment_item_id AS item_id, b.name AS base_name
			FROM ncwtable b
			JOIN wattachments a ON b.item_id = a.item_id
			JOIN items pa ON pa.item_id = a.attachment_item_id
			WHERE pa.name NOT LIKE  \'%Default%\'
			
			SELECT b.name, b.item_id, b.name AS base_name
			FROM ncwtable b
			WHERE item_type_id = 26
			*/
			$vehicles =
			'
			SELECT * FROM ncvehicledd
			';
			/*
			SELECT i.name, va.item_id, v.name AS base_name
			FROM (
			SELECT * FROM vehicle 
			WHERE (faction_id = 0 OR faction_id = 2)
			) v
			JOIN
			vehicle_attachment va ON v.vehicle_id = va.vehicle_id
			JOIN
			(
			SELECT * FROM items
			WHERE (item_type_id = 26 or item_type_id = 33)
			) 
			i ON i.item_id = va.item_id
			*/
			$suitUpgrades =
			'
			SELECT * FROM ncsuitupgradesdd
			';
			/*
			SELECT i.name, va.item_id, v.name AS base_name
			FROM (
			SELECT * FROM profile 
			WHERE faction_id = 2
			) v
			JOIN
			item_profile va ON v.profile_id = va.profile_id
			JOIN
			(
			SELECT * FROM items
			WHERE item_type_id = 36
			) 
			i ON i.item_id = va.item_id
			*/
			$this->runAll("vehicles", $vehicles);
			$this->runAll("weapons", $weapons);
			$this->runAll("suits", $suitUpgrades);
		}
		protected function runAll($name, $query)
		{
			include("model/dbconnect.php");
			$queryItems = $dbh->prepare($query);
			$queryItems->execute();
			$rows = $queryItems->fetchAll();
			foreach ($rows as $row) 
			{
				$treeName = $name;
				if ($row["base_name"]===NULL)
				{
					$branchName = $row["name"];
				}
				else
				{
					$branchName = $row["base_name"];
				}
				$eqName = $row["name"];
				$item_id = $row["item_id"];
				
				if (!isset($this->trees[$treeName]))
				{
					$this->trees[$treeName] = new Tree($treeName);
				}
				$this->trees[$treeName]->addBranch($branchName, $eqName, $item_id);
			}
		}
	}
?>