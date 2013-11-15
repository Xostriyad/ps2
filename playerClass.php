<?php
class Player
{
	private $items;
	private $skills;
	private $id;
	public function __construct()
	{	
	}
	public static function withID($id) 
	{
    	$instance = new self();
    	$instance->loadByID( $id );
    	return $instance;
    }
	public function getItems()
	{
		return $this->items;
	}
	public function getSkills()
	{
		return $this->skills;
	}
	public function getItemByID($id)
	{
		$targetItem = $this->findContentByIndex($this->items, $id, 0, count($this->items),'item_id');
		if($targetItem == -1)
		{
			return 0;
		}
		return 1;
	}
	public function getSkillByID($id)
	{
		$targetSkill = findContentByIndex($this->skills, $id, 0, count($this->skills),'skill_id');
		if($targetSkill == -1)
		{
			$targetSkill = array();
			$targetSkill["skill_id"] = "Not Found";
		}
		return $targetSkill;
	}
	protected function loadByID( $id ) 
	{
		$this->$id = $id;
    	$this->loadItemsByID($id);
		//$this->loadSkillsByID($id);
    }
	protected function loadItemsByID( $id ) 
	{
    	$url = "http://census.soe.com/get/ps2:v2/characters_item?character_id=".$id."&c:show=item_id"; //returning all items, I don't know why, seems broken on SOE census side.
		$response = file_get_contents($url);
		$json = json_decode($response, true);
		$this->items = $json["characters_item_list"];
    }
	protected function loadSkillsByID( $id ) 
	{
		//$skillFilter = "&skill_id=728,729,730,731,732,733,734,735,736,737";//maybe use these filters later
    	$url = "http://census.soe.com/get/ps2:v2/characters_skill?character_id=".$id."&c:limit=9001&c:sort=skill_id:1&c:show=skill_id";
		$response = file_get_contents($url);
		$json = json_decode($response, true);
		$this->skills = $json["characters_skill_list"];
    }
	protected function findContentByIndex($sortedArray, $target, $low, $high,$targetField) 
	{
		//this is basically a binary search
		if ($high < $low) return -1; //match not found
		$mid = $low + (($high-$low) / 2);
		$mid = intval($mid); //without intval to force this to an int the search will drift on a double or float value and will miss the target.
		//print_r($mid);
		//echo "<br/>";//in case you want the search to occur
		if ($sortedArray[$mid][$targetField] > $target) 
			return $this->findContentByIndex($sortedArray, $target, $low, $mid - 1,$targetField);
		else if ($sortedArray[$mid][$targetField] < $target)
			return $this->findContentByIndex($sortedArray, $target, $mid + 1, $high,$targetField);
		else
			return $sortedArray[$mid];
	}
}
?>