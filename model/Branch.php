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
	public function addLeaf($eqName, $haveEq)
	{
		$temp = new Leaf($eqName, $haveEq);
		array_push($this->leaves, $temp);
		
	}
}
?>