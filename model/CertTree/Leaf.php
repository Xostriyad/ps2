<?php
class Leaf {

	public $name;
	public $item_id;
	
	public function __construct($eqName, $item_id)  
    {  
		$this->name = $eqName;
		$this->item_id = $item_id;
    } 
}
?>