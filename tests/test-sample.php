<?php
/**
 * Class SampleTest
 *
 */

/**
 * Sample test case.
 */
class SampleTest extends WP_UnitTestCase {

	/**
	 * A single example test.
	 */
	public function test_sample() {
		// Replace this with some actual testing code.
		$this->assertTrue( true );
	}

	/**
	 * Check if the values ​​are the same.
	 */
	public function test_option_value() {
		update_option( 'my_name', 'Shinobi Works' );
		$this->assertSame( 'Shinobi Works', get_option( 'my_name' ) );
	}

}
