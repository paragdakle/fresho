<?php

class MongoWrapperClass
{
	private $connection = null;
	private $db = null;
	private $collection = null;
	
	public function __construct($dbname, $colname) {
		$this->connection = new MongoClient();
		$this->db = $this->connection->selectDB($dbname);
		$this->collection = $this->db->selectCollection($colname);
	}
	
	public function get($projections) {
		$record = null;
		$record = $this->collection->find(array(), $projections);
		return $record;
	}
	
	//methods to get data
	public function getOne($search_parameters) {
		$record = null;
		$record = $this->collection->findOne($search_parameters);
		return $record;
	}
	
	public function getMany($search_parameters) {
		$record = null;
		$record = $this->collection->find($search_parameters);
		return $record;
	}
	
	//methods to insert data
	public function insertOne($document) {
		$this->collection->insert($document);
		return true;
	}
	
	public function insertMany($document) {
		$this->collection->batchInsert($document, array('continueOnError' => true));
		return true;
	}

	//methods to delete data	
	public function deleteOne($criteria) {
		$this->collection->remove($criteria, array("justOne" => true));
		return true;
	}
	
	public function deleteMany($criteria) {
		$this->collection->remove($criteria, array("justOne" => false));
		return true;
	}

	//methods to update data
	public function updateOne($criteria, $update_fields) {
		$this->collection->update($criteria, array('$set' => $update_fields), array("upsert" => true));
		return true;
	}
	
	public function updateMany($criteria, $update_fields) {
		$this->collection->update($criteria, array('$set' => $update_fields), array("multiple" => true));
		return true;
	}
	
	public function __destruct() {
        $this->connection = null;
        $this->db = null;
        $this->collection = null;
    }
}
