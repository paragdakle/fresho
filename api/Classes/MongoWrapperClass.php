<?php

class MongoWrapperClass
{
	private $connection = null;
	private $db = null;
	private $collection = null;
	
	public function __construct($dbname, $colname) {
		$connection = new MongoClient();
		$db = $connection->selectDB($dbname);
		$collection = $db->selectCollection($colname);
	}
	
	public function insertOne($document) {
		$collection->insert($document);
		return true;
	}
	
	public function getOne($search_parameters) {
		$record = null;
		$record = $collection->findOne($search_parameters);
		return $record;
	}
	
	public function getMany($document) {
		$record = null;
		$record = $collection->find($search_parameters);
		return $record;
	}
	
	public function insertMany($document) {
		$collection->batchInsert($document, array('continueOnError' => true));
		return true;
	}
	
	public function removeOne($criteria) {
		$collection->remove($criteria, array("justOne" => true));
		return true;
	}
	
	public function removeMany($criteria) {
		$collection->remove($criteria, array("justOne" => false));
		return true;
	}
	
	public function updateOne($criteria, $update_fields) {
		$collection->update($criteria, array('$set' => $update_fields), array("upsert" => true));
		return true;
	}
	
	public function updateMany($criteria, $update_fields) {
		$collection->update($criteria, array('$set' => $update_fields), array("multiple" => true));
		return true;
	}
	
	public function __destruct() {
        $connection = null;
        $db = null;
        $collection = null;
    }
}
