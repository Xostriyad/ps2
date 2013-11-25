<?php

	include_once("model/Tree.php");
	include_once("model/Player.php");
	Class Forest
	{
		public $trees;
		public $player;
		
		public function __construct($id)  
		{  
			$this->trees = array();
			$this->player = Player::withID($id);
			$this->populate(); //Eventually this will take an array of Certification Trees, for now it will return all
		}

		protected function populate()
		{
			$weapons = '
			SELECT b.group_name, p.name, cb.item_id, pa.name AS base_name
			FROM groups b
			JOIN group_items cb ON cb.group_id = b.group_id
			JOIN items p ON p.item_id = cb.item_id
			LEFT JOIN wattachments a ON cb.item_id = a.attachment_item_id
			LEFT JOIN items pa ON pa.item_id = a.item_id
			WHERE cb.item_tag = "W"
			';
			$suitUpgrades = '
			SELECT b.group_name, p.name, cb.item_id, pa.name AS base_name
			FROM groups b
			JOIN group_items cb ON cb.group_id = b.group_id
			JOIN items p ON p.item_id = cb.item_id
			LEFT JOIN item_profile a ON cb.item_id = a.item_id
			LEFT JOIN profile pa ON pa.profile_id = a.profile_id
			WHERE cb.item_tag =  "S"
			';
			//make this smarter when I finish vehicle attachments
			$this->runQ($weapons);
			$this->runQ($suitUpgrades);
		}
		protected function runQ($query)
		{
			include("model/dbconnect.php");
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
				$haveEq = $this->player->getItemByID($row["item_id"]);
				
				if (!isset($this->trees[$treeName]))
				{
					$this->trees[$treeName] = new Tree($treeName);
				}
				$this->trees[$treeName]->addBranch($branchName, $eqName, $haveEq);
			}
		}
	}
?>