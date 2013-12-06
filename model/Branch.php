<?php
include_once("model/Leaf.php");
class Branch {

	public $name;
	public $leaves;
	
	public function __construct($name)  
    {  
        $this->name = $name;
		$this->leaves = array();
    }
	public function addLeaf($eqName, $item_id)
	{
		$temp = new Leaf($eqName, $item_id);
		array_push($this->leaves, $temp);
	}
}
?>