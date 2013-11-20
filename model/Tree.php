<?php
include_once("model/Branch.php");
class Tree {

	public $name;
	public $branches;
	
	public function __construct($name)  
    {  
        $this->name = $name;
		$this->branches = array();
    }
	public function addBranch($branchName, $eqName, $haveEq)
	{
		if (!isset($this->branches[$branchName]))
		{
			$this->branches[$branchName] = new Branch($branchName);
		}
		$this->branches[$branchName]->addLeaf($eqName, $haveEq);
	}
}
?>