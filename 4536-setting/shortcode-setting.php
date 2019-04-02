<?php

if( !class_exists( 'WP_List_Table' ) ) {
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
		// add_action( 'plugins_loaded', [$this, 'get_instance'] );
    add_action( 'admin_init', [$this, 'create_table'] );
    if( isset( $_POST['add_new_shortcode_setting_submit_4536'] ) ) {
      $this->insert();
    }
    if( isset( $_POST['update_shortcode_setting_submit_4536'] ) ) {
      // $this->update();
    }
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

  function table_name() {
    global $wpdb;
    $table_name = $wpdb->prefix . '4536_shortcode';
    return $table_name;
  }

  function create_table() {
    global $wpdb;
    $table_name = $this->table_name();
    $db_version = '1.0';
    $installed_ver = get_option( '4536_shortcode_db_version' );
    if(
      !is_null( $wpdb->get_row("SHOW TABLES FROM " . DB_NAME . " LIKE '" . $table_name . "'") ) &&
      ( $db_version === $installed_ver )
      ) return;
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
      id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
      author bigint(20) UNSIGNED DEFAULT '0' NOT NULL,
      title varchar(50) NOT NULL,
      text text NOT NULL,
      date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
      modified datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
      UNIQUE KEY id (id)
    ) $charset_collate;";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    update_option( '4536_shortcode_db_version', $db_version );
  }

	public function form() {
    if ( isset( $_GET['action'] ) ) {
      if( isset( $_GET['id'] ) && !is_null( $_GET['id'] ) ) {
        $id = $_GET['id'];
        $h1 = 'ショートコードの編集';
        $submit = get_submit_button( '変更を保存', 'primary large', 'update_shortcode_setting_submit_4536', $wrap, $other_attributes );
      } else {
        $h1 = 'ショートコードの新規追加';
        $submit = get_submit_button( '保存', 'primary large', 'add_new_shortcode_setting_submit_4536', $wrap, $other_attributes );
        $id = '1'; //test
      }
      $link = menu_page_url( 'shortcode', false );
      $link_text = '一覧';
      ob_start(); ?>
      <div id="poststuff">
        <div id="post-body-content">
          <div id="titlediv">
            <div id="titlewrap">
              <input type="text" value="" name="post_title" size="30" id="title" spellcheck="true" autocomplete="off" placeholder="タイトルを入力" />
            </div>
          </div>
          <div class="metabox-holder">
            <div class="postbox">
              <div class="tabs">
                <input id="common" type="radio" name="tab_item" checked>
                <label class="tab_item" for="common">共通</label>
                <input id="amp" type="radio" name="tab_item">
                <label class="tab_item" for="amp">AMP用</label>
                <fieldset class="tab_content" id="common_content">
                  <textarea name="" rows="15" cols="100" class="code" style="width:100%"></textarea>
                </fieldset>
                <fieldset class="tab_content" id="amp_content">
                  <textarea name="" rows="15" cols="100" class="code" style="width:100%"></textarea>
                </fieldset>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php echo $submit; ?>
      <style>
        .tabs {
          width: 100%;
        }
        .tab_item {
          box-sizing: border-box;
          width: calc(100%/2);
          line-height: 1.6;
          padding: .5em;
          border-bottom: 3px solid #5ab4bd;
          background-color: #d9d9d9;
          font-size: 16px;
          text-align: center;
          color: #565656;
          display: block;
          float: left;
          text-align: center;
          font-weight: bold;
          transition: all 0.2s ease;
        }
        .tab_item:hover {
          opacity: 0.75;
        }
        input[name="tab_item"] {
          display: none;
        }
        .tab_content {
          display: none;
          padding: 1.5em;
          clear: both;
          overflow: hidden;
        }
        #common:checked ~ #common_content,
        #amp:checked ~ #amp_content {
          display: block;
        }
        .tabs input:checked + .tab_item {
          background-color: #5ab4bd;
          color: #fff;
        }
      </style>
      <?php
      $form_inner = ob_get_clean();
		} else {
      $h1 = 'ショートコード設定';
      $link = add_query_arg( 'action', 'new' );
      $link_text = '新規追加';
      ob_start();
      $this->wp_list_table->prepare_items( $msgs );
      $this->wp_list_table->display();
      $form_inner = ob_get_clean();
    }
    ?>
		<div class="wrap" id="">
			<h1 class="wp-heading-inline"><?php echo $h1; ?></h1>
			<a href="<?php echo $link; ?>" class="page-title-action"><?php echo $link_text; ?></a>
			<hr class="wp-header-end">
			<form method="post" action="<?php echo add_query_arg([ 'id' => $id, 'action' => 'edit' ]); ?>">
				<?php echo $form_inner; ?>
			</form>
		</div>
	<?php }

  function insert() {
    global $wpdb;
    $table_name = $this->table_name();
    $title = ( isset( $_POST['post_title'] ) ) ? $_POST['post_title'] : '(タイトルなし)' ;
    // $common_text = ( isset( $_POST['title'] ) ) ? $_POST['title'] : '(タイトルなし)' ;
    $master_arr = compact( 'title' );
    $wpdb->insert( $table_name, $master_arr );
  }

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
// https://wpdocs.osdn.jp/%E3%83%97%E3%83%A9%E3%82%B0%E3%82%A4%E3%83%B3%E3%81%A7%E3%83%87%E3%83%BC%E3%82%BF%E3%83%99%E3%83%BC%E3%82%B9%E3%83%86%E3%83%BC%E3%83%96%E3%83%AB%E3%82%92%E4%BD%9C%E3%82%8B
//--------------------------------------------------------//
