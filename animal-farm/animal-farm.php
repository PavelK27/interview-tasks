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

/**
 * Statistics class.
 */
 class Stats {

	/**
	* Finds equal ids between goats and sheeps arrays.
	*
	* @param array Goats ids.
	* @param array Sheeps ids.
	*
	* @return boolean|array An array of equal ids or false if we have no valid data or no matches.
	*/
	 public function find_equals( $goats, $sheeps ) {

		// Bail early if no valid data.
		if ( empty( $goats ) || empty( $sheeps ) || ! is_array( $goats ) || ! is_array( $sheeps ) ) {
			return false;
		}

		$soulmates = array_intersect( $goats, $sheeps );

		// Return false if we have no matches.
		if ( empty( $soulmates ) || ! is_array( $soulmates ) ) {
			return false;
		}

		// Save ids to file.
		foreach( $soulmates as $match ) {
			$saved = file_put_contents( 'soulmates.txt', $match . ',', FILE_APPEND | LOCK_EX );
		}

		return $soulmates;
	 }
 }

// Generate 100 of goats and 100 of sheeps and save their ids into an respective arrays.
$goats  = array();
$sheeps = array();

for ( $i = 1; $i <= 100; $i++ ) {

	// Generate a goat.
	$goat  = new Goat();

	if ( property_exists( $goat, 'animal_id' ) ) {
		$goats[] = $goat->animal_id;
	}

	// Generate a sheep.
	$sheep = new Sheep();

	if ( property_exists( $sheep, 'animal_id' ) ) {
		$sheeps[] = $sheep->animal_id;
	}
}

// Perform our statistics.
$stats = new Stats();

// Find equals.
$soulmates = $stats->find_equals( $goats, $sheeps );

// Display message about soulmates.
if ( ! empty( $soulmates ) ) {
	echo 'The total number of matches between goats and sheeps: ' . count( $soulmates );
} else {
	echo 'There were no matches!';
}
