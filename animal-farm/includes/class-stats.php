<?php 

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
