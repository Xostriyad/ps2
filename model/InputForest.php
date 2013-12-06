<?php

	include_once("model/Tree.php");
	include_once("model/Player.php");
	Class Forest
	{
		public $vehicles;
		public $suitUpgrades;
		public $weapons;
		
		public function __construct()  
		{  
			//$this->vehicles = array();
			//$this->suits = array();
			$this->weapons = array();
			$this->populate(); //Eventually this will take an array of Certification Trees, for now it will return all
		}
		//REDO weaponattachment, looking for item_category_id existing
		protected function populate() //This whole function will need to be reworked when I start specifying cert trees.
		{
			//$this->vehicles = $this->popVehicles();
			//$this->suits = $this->popsuits();
			//$this->weapons = $this->popWeapons();
			
			$weaponBases = '
			SELECT p.name, pa.name AS base_name
			FROM (
			SELECT name, item_id, item_category_id, item_type_id FROM items 
			WHERE 
			(item_type_id = 26 OR item_type_id = 27) 
			AND 
			(faction_id = 2 OR faction_id = 0)
			) cb
			JOIN items p ON p.item_id = cb.item_id
			LEFT JOIN wattachments a ON cb.item_id = a.attachment_item_id
			LEFT JOIN items pa ON pa.item_id = a.item_id
			ORDER BY pa.name ASC 
			';
			//--work in progress
			/*


			SELECT name, item_id, item_category_id, item_type_id FROM items 
WHERE 
(item_type_id = 26 OR item_type_id = 27) 
AND 
(faction_id = 2 OR faction_id = 0)
			
			$weaponAttachments = '
			SELECT p.name, p.item_id, pa.name AS base_name
			FROM items p
			JOIN wattachments a ON p.item_id = a.attachment_item_id
			JOIN items pa ON pa.item_id = a.item_id
			AND pa.faction_id =2
			ORDER BY p.item_id ASC
			';
			//--work in progress
			$suitUpgrades = '
			SELECT b.group_name, p.name, cb.item_id, pa.name AS base_name
			FROM groups b
			JOIN group_items cb ON cb.group_id = b.group_id
			JOIN items p ON p.item_id = cb.item_id
			LEFT JOIN item_profile a ON cb.item_id = a.item_id
			LEFT JOIN profile pa ON pa.profile_id = a.profile_id
			WHERE cb.item_tag =  "S"
			ORDER BY p.name ASC 
			';
			$vehicle = '
			SELECT b.group_name, p.name, cb.item_id, a.description AS base_name
			FROM groups b
			JOIN group_items cb ON cb.group_id = b.group_id
			JOIN items p ON p.item_id = cb.item_id
			LEFT JOIN vehicle_attachment a ON cb.item_id = a.item_id
			WHERE cb.item_tag =  "V"
			ORDER BY p.name ASC
			';
			*/
			$this->runQ($weaponBases);
			//$this->runQ($weapons);
			//$this->runQ($suitUpgrades);
			
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
				//$eqName = $row["name"];
				//$haveEq = $this->player->getItemByID($row["item_id"]);
				
				if (!isset($this->trees[$treeName]))
				{
					$this->trees[$treeName] = new Tree($treeName);
				}
				$this->trees[$treeName]->addBranch($branchName, $eqName, $haveEq);
			}
		}
	}
?>