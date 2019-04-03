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
    add_action( 'admin_init', [$this, 'create_table'] );
		add_action( 'admin_menu', [$this, 'admin_menu'] );
		// add_action( 'plugins_loaded', [$this, 'get_instance'] );
    // delete_option( '4536_shortcode_last_id' );
    if( isset( $_POST['add_new_shortcode_setting_submit_4536'] ) ) {
      insert_db_table_record( $this->table_name(), $this->post_data() );
      global $wpdb;
      update_option( '4536_shortcode_last_id', ++$wpdb->insert_id );
    }
    if( isset( $_POST['update_shortcode_setting_submit_4536'] ) && ( isset( $_GET['id'] ) && !is_null( $_GET['id'] ) ) ) {
      update_db_table_record( $this->table_name(), $this->post_data( 'modified' ), ['id' => $_GET['id']], null, ['%d'] );
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
      title varchar(60) NOT NULL,
      common_text text NULL,
      pc_text text NULL,
      amp_text text NULL,
      date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
      modified datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
      UNIQUE KEY id (id)
    ) $charset_collate;";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    update_option( '4536_shortcode_db_version', $db_version );
  }

	public function form() {
    $link_to_new = '<a href="' . add_query_arg( 'action', 'new' ) . '" class="page-title-action">新規追加</a>';
    if ( isset( $_GET['action'] ) ) {
      if( isset( $_GET['id'] ) && !is_null( $_GET['id'] ) ) {
        $id = intval( $_GET['id'] );
        $link_to_new = remove_query_arg( 'id' );
        $link_to_new = '<a href="' . add_query_arg( 'action', 'new', $link_to_new ) . '" class="page-title-action">新規追加</a>';
        $h1 = 'ショートコードの編集';
        $data = get_db_table_record( $this->table_name(), $id );
        $submit = get_submit_button( '変更を保存', 'primary large', 'update_shortcode_setting_submit_4536', $wrap, $other_attributes );
      } else {
        $link_to_new = '';
        $h1 = 'ショートコードの新規追加';
        $submit = get_submit_button( '保存', 'primary large', 'add_new_shortcode_setting_submit_4536', $wrap, $other_attributes );
        $id = get_option( '4536_shortcode_last_id', 1 );
      }
      $link_to_list = '<a href="' . menu_page_url( 'shortcode', false ) . '" class="page-title-action">一覧</a>';
      ob_start(); ?>
      <div id="poststuff">
        <div id="post-body-content">
          <div id="titlediv">
            <div id="titlewrap">
              <input type="text" value="<?php if( isset( $data ) ) echo $data->title; ?>" name="post_title" size="30" id="title" spellcheck="true" autocomplete="off" placeholder="タイトルを入力" />
            </div>
          </div>
          <div class="metabox-holder">
            <div class="postbox">
              <div class="tabs">
                <?php
                $arr = [
                  'common_text' => '共通',
                  'pc_text' => 'PC用',
                  'amp_text' => 'AMP用',
                ];
                $no = 0;
                foreach( $arr as $key => $value ) {
                  $checked = ( $no === 0 ) ? ' checked' : '';
                  $no++;
                  ?>
                  <input id="<?php echo $key; ?>" type="radio" name="tab_item"<?php echo $checked; ?>>
                  <label class="tab_item" for="<?php echo $key; ?>"><?php echo $value; ?></label>
                <?php }
                foreach( $arr as $key => $value ) { ?>
                  <fieldset class="tab_content" id="<?php echo $key; ?>_content">
                    <textarea name="<?php echo $key; ?>" rows="15" cols="100" class="code" style="width:100%"><?php if( isset( $data ) ) echo $data->$key; ?></textarea>
                  </fieldset>
                <?php } ?>
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
          width: calc(100%/3);
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
        #common_text:checked ~ #common_text_content,
        #pc_text:checked ~ #pc_text_content,
        #amp_text:checked ~ #amp_text_content {
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
      ob_start();
      $this->wp_list_table->prepare_items( $msgs );
      $this->wp_list_table->display();
      $form_inner = ob_get_clean();
    }
    ?>
		<div class="wrap" id="">
			<h1 class="wp-heading-inline"><?php echo $h1; ?></h1>
      <?php
      if( isset( $link_to_list ) ) echo $link_to_list;
      if( !empty( $link_to_new ) ) echo $link_to_new;
      ?>
			<hr class="wp-header-end">
			<form method="post" action="<?php echo add_query_arg([ 'id' => $id, 'action' => 'edit' ]); ?>">
				<?php echo $form_inner; ?>
			</form>
		</div>
	<?php }

  function post_data( $time = 'date' ) {
    $master_arr = [];
    $master_arr['title'] = ( isset( $_POST['post_title'] ) && !empty( $_POST['post_title'] ) ) ? $_POST['post_title'] : '(タイトルなし)' ;
    $arr = [
      'common_text',
      'pc_text',
      'amp_text',
    ];
    foreach( $arr as $key ) {
      $master_arr[$key] = isset( $_POST[$key] ) && !empty( $_POST[$key] ) ? $_POST[$key] : NULL;
    }
    switch( $time ) {
      case 'date':
        $master_arr['date'] = current_time( 'mysql' );
        break;
      case 'modified':
        $master_arr['modified'] = current_time( 'mysql' );
        break;
    }
    return $master_arr;
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
