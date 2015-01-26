<?php namespace Mannysoft\Database;

trait ModelTrait {

	

	public function scopeSortBy($query, $field, $order)
    	{
	        if($field == '' and $order == '') return;
	        return $query->orderBy($field, $order);
    	}

}
