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

		// Get our parameters from class properties.
		$storage = $this->ids_storage;
		$id = $this->animal_id;

		// Bail early if we have no file name for storage or no valid id.
		if ( empty( $storage ) || ! is_string( $storage ) || empty( $id ) ) {
			return false;
		}

		// Bail if file doesn't exist.
		if ( ! file_exists( $storage ) ) {
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
