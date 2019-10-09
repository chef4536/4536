<?php
/**
 * Review JSON LD
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

declare( strict_types = 1 );

/**
 * Review Class
 */
class Review_4536 {

	/**
	 * Constractor
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', [ $this, 'add_meta_box' ] );
		add_action( 'transition_post_status', [ $this, 'save' ], 10, 3 );
		add_action( 'wp_head_4536', [ $this, 'script' ] );
	}

	/**
	 * Get Post Meta
	 *
	 * @param string $key is get_post_meta key.
	 */
	public function get_post_meta( string $key ) {
		global $post;
		$value = get_post_meta( $post->ID, $key, true );
		return esc_html( $value );
	}

	/**
	 * Init
	 */
	public function add_meta_box() {
		$title    = __( 'レビュー', '4536' );
		$id       = 'review';
		$callback = $id;
		add_meta_box( $id, $title, [ $this, $callback ], 'post', 'side', 'low' );
		add_meta_box( $id, $title, [ $this, $callback ], 'page', 'side', 'low' );
	}

	/**
	 * Save
	 *
	 * @param string $new_status is new post status.
	 * @param string $old_status is old post status.
	 * @param string $post       is post content.
	 */
	public function save( $new_status, $old_status, $post ) {
		switch ( $old_status ) {
			case 'auto-draft':
			case 'draft':
			case 'pending':
			case 'future':
				if ( 'publish' === $new_status ) {
					return $post;
				}
				break;
			default:
				add_action(
					'save_post',
					[ $this, 'post_meta_action' ]
				);
				break;
		}
	}

	/**
	 * Save Function Callback
	 *
	 * @param int $post_id .
	 */
	public function post_meta_action( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
		if ( 'inline-save' === filter_input( INPUT_POST, 'action' ) ) {
			return $post_id;
		}
		$meta_key_arr = [
			'review_name',
			'review_rating',
			'review_type',
		];
		foreach ( $meta_key_arr as $meta_key ) {
			if ( filter_input( INPUT_POST, $meta_key ) ) {
				update_post_meta( $post_id, $meta_key, filter_input( INPUT_POST, $meta_key ) );
			} else {
				delete_post_meta( $post_id, $meta_key );
			}
		}
	}

	/**
	 * Callback Function
	 */
	public function review() {
		$review_name   = $this->get_post_meta( 'review_name' );
		$review_rating = $this->get_post_meta( 'review_rating' );
		$review_type   = $this->get_post_meta( 'review_type' );
		?>
		<p><small>この記事がレビュー記事の場合に「評価」と「レビュー対象の名前」を設定すると検索結果にレビュー項目が表示されることがあります。</small></p>
		<p>
			<label>レビュー対象の種類</label><br>
			<select name="review_type" type="text">
				<?php $selected = ( $review_type === $x ) ? ' selected' : ''; ?>
				<option value="" hidden>選択してください</option>
				<?php
				$review_type_arr = [
					'Product'       => '製品・サービス',
					'LocalBusiness' => 'お店',
				];
				foreach ( $review_type_arr as $type => $name ) {
					$selected = ( $review_type === $type ) ? ' selected' : '';
					echo '<option value="' . esc_attr( $type ) . '"' . esc_attr( $selected ) . '>'
							. esc_html( $name ) . '</option>';
				}
				?>
			</select>
		</p>
		<p><label>レビュー対象<input type="text" name="review_name" value="<?php echo esc_attr( $review_name ); ?>" size="60" class="input-4536" /></label></p>
		<label>評価</label><br>
		<select name="review_rating" type="text">
		<option value="" hidden>選択してください</option>
		<?php
		for ( $i = 2; $i <= 10; $i++ ) {
			$x        = strval( $i / 2 );
			$selected = ( strval( $review_rating ) === $x ) ? ' selected' : '';
			echo '<option value="' . esc_attr( $x ) . '"' . esc_attr( $selected ) . '>' . esc_html( $x ) . '</option>';
		}
		?>
		</select>
		<?php
	}

	/**
	 * Script
	 */
	public function script() {
		$review_name   = $this->get_post_meta( 'review_name' );
		$review_rating = $this->get_post_meta( 'review_rating' );
		if ( empty( $review_name ) || empty( $review_rating ) ) {
			return;
		}
		// For Old Rating.
		if ( $review_rating > 5 ) {
			$review_rating = intval( $review_rating ) / 2;
		}
		global $post;
		$posted_date    = get_the_date( 'c' );
		$image_url      = esc_url( wp_get_attachment_image_src( $image_id, true ) );
		$author         = get_userdata( $post->post_author )->display_name;
		$publisher_name = get_bloginfo( 'name' );
		// Here Document Begin.
		?>
<script type="application/ld+json">
{
	"@context": "http://schema.org",
	"@type": "Review",
	"itemReviewed": {
		"@type": "Thing",
		"name": "<?php echo esc_html( $review_name ); ?>"
	},
	"reviewRating": {
		"@type": "Rating",
		"ratingValue": "<?php echo esc_html( $review_rating ); ?>",
	},
	"datePublished": "<?php echo esc_html( $posted_date ); ?>",
	"author": {
		"@type": "Person",
		"name": "<?php echo esc_html( $author ); ?>"
	},
	"publisher": {
		"@type": "Organization",
		"name": "<?php echo esc_html( $publisher_name ); ?>"
	}
}
</script>
		<?php
	}
}
$review_class = new Review_4536();
add_action( 'init', [ $review_class, '__construct' ] );
