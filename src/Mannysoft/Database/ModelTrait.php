<?php namespace Mannysoft\Database;

trait ModelTrait {

	public function looksGood() 
	{
	 	return ShipperConsignee::where('type', '=', 'consignee')
                ->where('user_id', '=', 1)->get();
	}

	public function scopeSortBy($query, $field, $order)
    {
        if($field == '' and $order == '') return;
        return $query->orderBy($field, $order);
    }

}
