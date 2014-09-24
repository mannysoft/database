<?php namespace Mannysoft\Database;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Validation\Validator;

class Model extends Eloquent {

    public $errors;
	  public $validation;
	  public $rawErrors;
	  
	  //----------------------------------------------------------------	

  	public static function boot()
  	{
  		parent::boot();
  		
  		static::saving(function($model)
  		{
  			if ( ! $model->force) return $model->validate();
  		});
  	}
  
  	//----------------------------------------------------------------	
  	
  	public function validate()
  	{
  		$rules = self::processRules(static::$insertRules);
  		
  		// Lets see if the key has value
  		if($this->getKey() != NULL)
  		{
  			// Lets use the update rules
  			$rules = self::processRules(static::$updateRules);
  		}
  		
  		$messages = static::$messages;
  		
  		$validation = Validator::make($this->attributes, $rules, $messages);
  		
  		if($validation->passes()) return true;
  		
  		$this->errors 		= $validation->messages()->all();
  		$this->validation 	= $validation;
  		
  		return false;
  	}
  	
  	/**
  	 * Process validation rules.
  	 *
  	 * @param  array  $rules
  	 * @return array  $rules
  	 */
  	protected function processRules($rules)
  	{
  		$id = $this->getKey();
  		
  		array_walk($rules, function(&$item) use ($id)
  		{
  			// Replace placeholders
  			$item = stripos($item, ':id:') !== false ? str_ireplace(':id:', $id, $item) : $item;
  		});
  		
  		return $rules;
  	}
  
  	//----------------------------------------------------------------
  
  	public function rawErrors()
  	{
  		$rawErrors = '';
  
  		foreach($this->errors as $error)
  		{
  			$rawErrors.= $error.' ';
  		}
  
  		return $rawErrors;	
  	}	

}   
