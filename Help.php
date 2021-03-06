<?php
class Help {
	public static function arToArray($models) {
		if(is_array($models)) {
			$result = array();
			foreach($models as $model) array_push($result, self::arToArray($model));
		} else {
            if(!($models instanceof CActiveRecord)) throw new Exception('The passed model is not ActiveRecord type!');
			$result = array_filter($models->attributes, function($element) { return !is_null($element);});	
			foreach($models->relations() as $relationName=>$_) {
				if($models->hasRelated($relationName)) {
					$result[$relationName] =  self::arToArray($models->getRelated($relationName));
				}
			}
		}

		return $result;
	}
    
    public static function arToJSON($models) {
		return CJSON::encode(self::arToArray($models));
	}
}
?>
