<?php

class MongoDB
{
	$connection = null;
	$db = null;
	$collection = null;
	
	function __construct($dbname, $colname) {
		$connection = new MongoClient();
		$db = $connection->selectDB($dbname);
		$collection = $db->selectCollection($colname);
	}
	
	function insertOne($document) {
		$collection->insert($document);
		return true;
	}
	
	function getOne($search_parameters) {
		$record = null;
		$record = $collection->findOne($search_parameters);
		return $record;
	}
	
	function getMany($document) {
		$record = null;
		$record = $collection->find($search_parameters);
		return $record;
	}
	
	function insertMany($document) {
		$collection->batchInsert($document, array('continueOnError' => true));
		return true;
	}
	
	function removeOne($criteria) {
		$collection->remove($criteria, array("justOne" => true));
		return true;
	}
	
	function removeMany($criteria) {
		$collection->remove($criteria, array("justOne" => false));
		return true;
	}
	
	function updateOne($criteria, $update_fields) {
		$collection->update($criteria, array('$set' => $update_fields), array("upsert" => true));
		return true;
	}
	
	function updateMany($criteria, $update_fields) {
		$collection->update($criteria, array('$set' => $update_fields), array("multiple" => true));
		return true;
	}
	
	public function __destruct() {
        $connection = null;
		$db = null;
		$collection = null;
    }
}