<?php 

/**
 * Goat class.
 */
class Goat extends Animal {

	/**
	 * Constructor.
	 */
	public function __construct() {

		// Initiate parent class and generate animal id.
		parent::__construct();

		// Set storage to goat.txt
		$this->ids_storage = 'goat.txt';

		// Save animal id to storage.
		$this->save_id_to_storage();
	}
}
