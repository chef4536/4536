<?php

if( !class_exists( 'WP_List_Table' ) ) {
	//動作がおかしくなるようであればWP_List_Table拡張ファイルを別にしてrequireする
  require_once( ABSPATH . 'wp-admin/includes/screen.php' );
  require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Shortcode_List_Table_4536 extends WP_List_Table {

	/**
	* 初期化時の設定を行う
	*/
	public function __construct( $args = [] ) {
	 	parent::__construct([
 			'plural' => 'msgs',
 			'screen' => isset( $args['screen'] ) ? $args['screen'] : null,
			'ajax' => false,
	 	]);
	}

	/**
	* ショートコードがない場合
	* @param string
	*/
	public function no_items() {
  	_e( 'ショートコードが設定されていません' );
	}

	/**
	 * 表で使用されるカラム情報の連想配列を返す
	 * @return array
	 */
	public function get_columns() {
		return [
			'cb'		=> '<input type="checkbox" />',
			'title'		=> __( 'タイトル' ),
			'shortcode'	=> __( 'ショートコード' ),
			'author'		=> __( '作成者' ),
			'date'	=> __( '日付' ),
		];
	}

	/**
	 * プライマリカラム名を返す
	 * @return string
	 */
	protected function get_primary_column_name() {
		return 'title';
	}

	/**
	 * 表示するデータを準備する
	 */
	public function prepare_items( $items = null ) {
		if ( !is_null( $items ) ) {
			$this->items = $items;
			$this->set_pagination_args([
				'total_items' => count( $this->items ),
				'per_page' => 999,
			]);
		}
	}

	/**
	* 1行分のデータを表示する
	* @param array $item
	*/
	public function single_row( $item ) {
		list( $columns, $hidden, $sortable, $primary ) = $this->get_column_info();
		?>
			<tr>
			 	<?php
			 	foreach ( $columns as $column_name => $column_display_name ) {
				 	$classes = "$column_name column-$column_name";
				 	$extra_classes = '';
				 	if ( in_array( $column_name, $hidden ) ) {
						$extra_classes = ' hidden';
				 	}
				 	switch ( $column_name ) {
					 	case 'cb':
							$checkbox_id =  "checkbox_".$item->get( 'no' );
							$checkbox = "<label class='screen-reader-text' for='" . $checkbox_id . "' >" . sprintf( __( 'Select %s' ), $item->msgid ) . "</label>"
			 								. "<input type='checkbox' name='checked[]' value='" . $item->get( 'no' ). "' id='" . $checkbox_id . "' />";
							echo "<th scope='row' class='check-column'>$checkbox</th>";
			 				break;
						case 'title':
							echo '<td class="' .esc_attr( $classes.$extra_classes ). '">' . esc_html( $item->get( 'title' ) ) . '</td>';
			 				break;
						case 'shortcode':
							echo '<td class="' . esc_attr( $classes.$extra_classes ) . '"><textarea id="msgid_' . esc_attr( $item->no ) . '" name="msgid[' . esc_attr( $item->no ) . ']" rows="2" class="fit-width">' . esc_html( $item->shortcode ) . '</textarea></td>';
			 				break;
			 			// 一部省略
					}
				} ?>
			</tr>
	<?php }

	/**
	* 「一括操作」のプルダウンメニューを指定
	*
	* @return array
	*/
	protected function get_bulk_actions() {
		return [
			'delete-selected' => __( 'Delete' )
		];
	}

	/**
	* カラムのソート
	*
	* @return array
	*/
	protected function get_sortable_columns() {
		return [
			// 'no'	=> [ 'no', true ],
			'title'	=> 'title',
			'date'	=> 'date',
			'author'	=> 'author',
		];
	}

}

class Shortcode_Setting_4536 {

	static $instance;
	public $wp_list_table;

	public function __construct() {
		add_filter( 'set-screen-option', [ __CLASS__, 'set_screen' ], 10, 3 );
		add_action( 'admin_menu', [$this, 'admin_menu'] );
		add_action( 'plugins_loaded', [$this, 'get_instance'] );
	}

	public static function set_screen( $status, $option, $value ) {
		return $value;
	}

	public function admin_menu() {
		$menu = add_submenu_page( '4536-setting', 'ショートコード', 'ショートコード', 'manage_options', 'shortcode', [$this, 'form'] );
		add_action( "load-$menu", [$this, 'screen_option'] );
	}

	public function screen_option() {
		add_screen_option( $option, $args );
		$this->wp_list_table = new Shortcode_List_Table_4536();
	}

	public function form() {
    if ( isset( $_GET['action'] ) && $_GET['action']==='new' ) {
      $title = 'ショートコードを新規追加';
      $link = menu_page_url( 'shortcode', false );
      $link_text = '一覧';
      $form_inner = '';
		} else {
      $title = 'ショートコード設定';
      $link = add_query_arg( 'action', 'new' );
      $link_text = '新規追加';
      ob_start();
      $this->wp_list_table->prepare_items( $msgs );
      $this->wp_list_table->display();
      $form_inner = ob_get_clean();
    }
    ?>
		<div class="wrap" id="">
			<h1 class="wp-heading-inline"><?php echo $title; ?></h1>
			<a href="<?php echo $link; ?>" class="page-title-action"><?php echo $link_text; ?></a>
			<hr class="wp-header-end">
			<form method="post" id="">
				<?php echo $form_inner; ?>
			</form>
		</div>
	<?php }

	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

}
new Shortcode_Setting_4536();

//-------------------リファレンス----------------------------//
// https://elearn.jp/wpman/column/c20170823_01.html
// https://elearn.jp/wpman/column/c20170926_01.html
// https://www.sitepoint.com/using-wp_list_table-to-create-wordpress-admin-tables/
//--------------------------------------------------------//
