<?php 

/**
 * Sheep class.
 */
class Sheep extends Animal {

	/**
	 * Constructor.
	 */
	public function __construct() {

		// Initiate parent class and generate animal id.
		parent::__construct();

		// Set storage to sheep.txt
		$this->ids_storage = 'sheep.txt';

		// Save animal id to storage.
		$this->save_id_to_storage();
	}
}
