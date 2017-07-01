<?php 

/**
 * Animal class.
 */
class Animal {

	/**
	 * Animal id.
	 * @var int
	 */
	public $animal_id;

	/**
	 * Filename for ids storage.
	 * @var string
	 */
	public $ids_storage;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->animal_id = $this->generate_id();
	}

	/**
	 * Generates random id number.
	 *
	 * @param int $min Minimum limit, defaults to 0.
	 * @param int $max Maximum limit, defaults to 10000.
	 *
	 * @return int A random number between $min and $max.
	 */
	public function generate_id( $min = 0, $max = 10000 ) {
		return rand( $min, $max );
	}

	/**
	 * Stores animal id.
	 *
	 * @return boolean|int False if not saved, 'int' if saved correctly. 
	 */
	public function save_id_to_storage() {

		$storage = $this->ids_storage;
		$id = $this->animal_id;

		// Bail early if we have no file name for storage or no valid id.
		if ( empty( $storage ) || ! is_string( $storage ) || empty( $id ) ) {
			return false;
		}

		// Save id to file.
		$saved = file_put_contents( $storage, $id . ',', FILE_APPEND | LOCK_EX );

		// If saved correctly, return animal id.
		if ( ! empty( $saved ) ) {
			return $id;
		}
	}
}

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

// Generate 10,000 of goats and save their ids into an array.
$goats = array();

for ( $i = 1; $i <= 10000; $i++ ) {
	$goat = new Goat();

	if ( property_exists( $goat, 'animal_id' ) ) {
		$goats[] = $goat->animal_id;
	}
}
