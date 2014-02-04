<?php
class Equipment {

	public $name;
	public $isOwned;
	
	public function __construct($name, $isOwned)  
    {  
        $this->name = $name;
	    $this->isOwned = $isOwned;
    } 
}

?>