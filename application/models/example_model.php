<?php

class Example_model extends Model {
	
	public function getCategory()
	{
		$result = $this->query('SELECT * FROM item_category');
		return $result;
	}

}

?>
