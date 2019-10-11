<?php
/**
 * Extend Walker Class
 *
 * PHP Version >= 5.6
 *
 * @package    WordPress
 * @category   Theme
 * @subpackage 4536
 * @author     Chef
 * @license    https://www.gnu.org/licenses/gpl-3.0.html/ GPL v2 or later
 * @link       https://4536.jp/
 * @since      1.0.0
 */

// https://wordpress.stackexchange.com/questions/124772/using-wp-category-checklist-in-a-widget.

require_once ABSPATH . 'wp-admin/includes/template.php';

/**
 * Main Class
 */
class Walker_Category_Checklist_Widget extends Walker_Category_Checklist {

	private $name;
	private $id;

	function __construct( $name = '', $id = '' ) {
		$this->name = $name;
		$this->id   = $id;
	}

	function start_el( &$output, $cat, $depth = 0, $args = array(), $id = 0 ) {
		extract( $args );
		if ( empty( $taxonomy ) ) {
			$taxonomy = 'category';
		}
		$class   = ' class="category-list"';
		$id      = $this->id . '-' . $cat->term_id;
		$checked = checked( in_array( $cat->term_id, $selected_cats ), true, false );
		$output .= "\n<li id='{$taxonomy}-{$cat->term_id}'$class>"
			. '<label class="selectit"><input value="'
			. $cat->term_id . '" type="checkbox" name="' . $this->name
			. '[]" id="in-' . $id . '"' . $checked
			. disabled( empty( $args['disabled'] ), false, false ) . ' /> '
			. esc_html( apply_filters( 'the_category', $cat->name ) )
			. '</label>';
	}
}
