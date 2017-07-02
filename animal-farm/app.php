<?php
/**
 * Animal Farm Application.
 */
class App {
	
	/**
	 * Constructor.
	 */
	public function __construct() {
		// Load app classes.
		$this->auto_loader();

		// Generate animals.
		$animals = $this->generate_animals();

		// Collect statistics for them.
		$this->collect_statistics( $animals );
	}

	/**
	 * Register the autoloader.
	 */
	private function auto_loader() {
		spl_autoload_register( array( $this, 'autoload' ) );
	}

	/**
	 * Require classes.
	 *
	 * @param string $class_name Fully qualified name of class to try and load.
	 *
	 * @return  void Early exit if we can't load the class.
	 */
	public function autoload( $class_name ) {
		// Include our file.
		$includes_dir = dirname( __FILE__ ) . '/includes/';
		$file         = 'class-' . strtolower( $class_name ) . '.php';

		if ( stream_resolve_include_path( $includes_dir . $file ) ) {
			require_once $includes_dir . $file;
		}
	}

	/**
	 * Generate 100 animals of each kind.
	 *
	 * @return array $animals Array with animals ids.
	 */
	public function generate_animals() {
		// Generate 100 of goats and 100 of sheeps and save their ids into an respective arrays.
		$animals  = array();

		for ( $i = 1; $i <= 100; $i++ ) {

			// Generate a goat.
			$goat  = new Goat();

			if ( property_exists( $goat, 'animal_id' ) ) {
				$animals['goats'][] = $goat->animal_id;
			}

			// Generate a sheep.
			$sheep = new Sheep();

			if ( property_exists( $sheep, 'animal_id' ) ) {
				$animals['sheeps'][] = $sheep->animal_id;
			}
		}

		return $animals;
	}

	/**
	 * Generates random id number.
	 *
	 * @param array $animals Animals ids array.
	 *
	 * @return boolean Return false if there's no valid data.
	 */
	public function collect_statistics( $animals ) {

		// Bail early if no valid data.
		if ( empty( $animals ) || ! is_array( $animals['goats'] ) || ! is_array( $animals['sheeps'] ) ) {
			return false;
		}

		// Perform our statistics.
		$stats = new Stats();

		// Find equals.
		$soulmates = $stats->find_equals( $animals['goats'], $animals['sheeps'] );

		// Display statistics heading.
		echo "Animal Farm Statistics \n";

		// Display message about soulmates.
		if ( ! empty( $soulmates ) ) {
			echo 'The total number of matches between goats and sheeps: ' . count( $soulmates ) . "\n";
		} else {
			echo 'There were no matches in id numbers for sheeps and goats!' . "\n";
		}

		// Find biggest id numbers.
		$max_ids = $stats->find_biggest_numbers( $animals['goats'], $animals['sheeps'] );

		// Display message about max ids.
		if ( ! empty( $max_ids ) && is_array( $max_ids ) ) { }
			echo "The maximum id number for goats is ${max_ids['goats']} and for sheeps is ${max_ids['sheeps']}.\n";
		}

}

new App();
