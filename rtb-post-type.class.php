<?php
class RawToolBox_PostType{
	private $_singular, $_post_type, $_plural, $_custom_query_var, $_in_menu;

	/**
	 * Set Some defaults
	 */
	private $_hierarchical = 0;
	private $_rewrite = 'true';
	private $_in_nav_menu = 'true';
	private $_in_admin_bar = 'true';
	private $_public = 'true';
	private $_show_ui = 'true';
	private $_queryable = 'true';
	private $_exclude_from_search = 'false';
	private $_menu_icon = 'dashicons-admin-post';
	private $_cap_type = 'page';
	private $_menu_position = 20;
	private $_archive = 'true';
	private $_privacy = 'true';
	private $_export = 'true';
	private $_description = '';
	private $_admin_column = false;

	private $_labels = array();
	private $_args = array();

	private $_capabilities = array(
		'edit_post'		=>		'edit_post'
	);

	private $_supports = array(
		'title',
		'editor',
		'thumbnail'
	);

	/**
	 * Set Some Conditionals
	 *
	 * 1. slug [ set if rewrite is boolean & true]
	 * @var $slug [array]
	 */

	private $_slug = array();


	public function __construct( $singular, $menu_name = '', $plural, $post_type ){
		if( ! empty( $singular ) ){
			$this->_singular = $singular;
		}

		if( ! empty( $menu_name ) ){
			$this->_menu_name = $menu_name;
		}else{
			$this->_menu_name = $this->_set_menu_name();
		}

		if( !empty( $plural ) ){
			$this->_plural = $plural;
		}

		if( ! empty( $post_type ) ){
			$this->_post_type = strtolower( str_replace( ' ', '_', $post_type ) );
		}

		//check if theme supports post-thumbnails or not.
		// if doesn't support add
		if( false === current_theme_supports( 'post-thumbnails' ) ){
			add_action( 'after_setup_theme', 'add_feature', 999 );
		}

		add_action( 'init', array( $this, 'create_post_type' ) );
	}

	public function create_post_type(){
		$this->_args = $this->_set_args();
		register_post_type( $this->_post_type, $this->_args );
	}

	private function _set_labels(){
		$labels = array(
			'name'                => _x( $this->_plural, 'Post Type General Name', 'text_domain' ),
			'singular_name'       => _x( $this->_singular, 'Post Type Singular Name', 'text_domain' ),
			'menu_name'           => __( $this->_menu_name, 'text_domain' ),
			'name_admin_bar'      => __( $this->_menu_name, 'text_domain' ),
			'parent_item_colon'   => __( 'Parent '.$this->_singular.':', 'text_domain' ),
			'all_items'           => __( 'All '.$this->_plural, 'text_domain' ),
			'add_new_item'        => __( 'Add New '.$this->_singular , 'text_domain' ),
			'add_new'             => __( 'Add New', 'text_domain' ),
			'new_item'            => __( 'New '.$this->_singular , 'text_domain' ),
			'edit_item'           => __( 'Edit '.$this->_singular, 'text_domain' ),
			'update_item'         => __( 'Update '.$this->_singular, 'text_domain' ),
			'view_item'           => __( 'View '.$this->_singular, 'text_domain' ),
			'search_items'        => __( 'Search '.$this->_singular, 'text_domain' ),
			'not_found'           => __( 'Not found', 'text_domain' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
		);

		return $labels;
	}

	private function _set_args(){
		$args = array(
			'labels' 			  => $this->_set_labels(),
			'description'         => __( $this->_description, 'text_domain' ),
			'supports'            => $this->_supports,
			'hierarchical'        => $this->_hierarchical,
			'public'              => $this->_privacy,
			'show_ui'             => $this->_show_ui,
			'show_in_menu'        => $this->_in_menu,
			'menu_position'       => $this->_menu_position,
			'menu_icon'			  => $this->_menu_icon,
			'show_in_admin_bar'   => $this->_in_admin_bar,
			'show_in_nav_menus'   => $this->_in_nav_menu,
			'can_export'          => $this->_export,
			'has_archive'         => $this->_archive,
			'exclude_from_search' => $this->_exclude_from_search,
			'publicly_queryable'  => $this->_queryable,
			'query_var'		 	  => $this->_custom_query_var,
			'rewrite'			  => $this->_slug,
			'capability_type'     => $this->_cap_type,
		);

		return $args;
	}

	private function _set_menu_name(){
		$this->_menu_name = $this->_plural;
	}

	public function set_hierarchical( $hierarchy ){
		if( is_bool( $hierarchy ) ){
			$this->_hierarchical = $hierarchy;
		}
	}

	public function show_in_admin_bar( $admin_bar ){
		if( is_bool( $admin_bar ) ){
			$this->_in_admin_bar = $admin_bar;
		}
	}

	public function show_ui( $ui ){
		if( is_bool( $ui ) ){
			$this->_show_ui = $ui;
		}
	}

	public function set_rewrite( $rewrite ){
		if( is_bool( $rewrite ) ){
			$this->_rewrite = $rewrite;
		}
	}

	public function set_custom_slug( $slug = '' ){
		if( $this->_rewrite == true && ! empty( $slug ) ){
			$this->_slug = array( 'slug'=> $slug, 'with_front'=> true, 'pages'=>true, 'feeds'=> true );
		}else if( $this->_rewrite == true && empty( $slug ) ){
			$this->_slug = array( 'slug'=>$this->_post_type, 'with_front'=> true, 'pages'=>true, 'feeds' => true );
		}else{
			$this->_slug = $this->_rewrite;
		}
	}

	public function show_in_nav_menu( $nav_menu ){
		if( is_bool( $nav_menu ) ){
			$this->_in_nav_menu = $nav_menu;
		}
	}

	public function set_menu_icon( $icon ){
		if( ! empty( $icon ) ){
			$this->_menu_icon = $icon;
		}
	}

	public function set_supports( $supports = array() ){
		if( is_array( $supports ) && ! empty( $supports ) ){
			$this->_supports = $supports;
		}
	}

	public function set_capability_type( $cap_type ){
		if( isset( $cap_type ) && ! empty( $cap_type ) ){
			$this->_cap_type = $cap_type;
		}
	}

	public function set_menu_position( $position ){
		if( is_int( $position ) && $position > 0 ){
			$this->_menu_position = $position;
		}
	}

	public function exclude_from_search( $search ){
		if( is_bool( $search ) ){
			$this->_exclude_from_search = $search;
		}
	}

	public function set_parent_menu( $menu ){
		if( is_bool( $menu ) ){
			$this->_in_menu = $menu;
		}else if( ! empty( $menu ) ){
			$this->_in_menu = $menu;
		}
	}

	public function set_archive_support( $archive ){
		if( is_bool( $archive ) ){
			$this->_archive = $archive;
		}
	}

	public function set_queryable( $queryable ){
		if( is_bool( $queryable ) ){
			$this->_queryable = $queryable;
		}
	}

	public function set_query_var( $var ){
		if( ! empty( $var ) ){
			$this->_custom_query_var = $var;
		}else{
			$this->_custom_query_var = $this->_post_type;
		}
	}

	public function set_privacy( $privacy ){
		if( is_bool( $privacy ) ){
			$this->_privacy = $privacy;
		}
	}

	public function set_export_rule( $rule ){
		if( is_bool( $rule ) ){
			$this->_export = $rule;
		}
	}

	public function set_description( $descriptions ){
		if( ! empty( $descriptions ) ){
			$this->_description = $descriptions;
		}
	}

	public function add_feature(){
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'admin-thumb', 85, 50, true );
	}

	public function set_admin_columns( $args = array() ){
		$defaults = array(
			// to do
		);

		$this->columns = wp_parse_args( $args, $defaults );

		if( isset( $args['admin_column'] ) && true === $args['admin_column'] ){
			$this->_admin_column = $args['admin_column'];
		}

		if( true === $this->_admin_column ){
			add_filter( 'manage_edit-' . $this->_post_type . '_columns', array( $this, 'column_head' ), 10 );
			add_action(  'manage_' . $this->_post_type . '_posts_custom_column', array( $this, 'column_content' ), 10, 2  );
			// to do: sorting
			//$this->addFilter( 'request', 'sort_by_mb_value' );
		}
	}

	public function column_head( $defaults ){
		$date = $defaults['date'];
		unset( $defaults['date'] );
		foreach( $this->columns['columns'] as $column ){
			$name = $column['name'];
			$defaults[$name] = $column['column_title'];
		}
		$defaults['date'] = $date;
		return $defaults;
	}

	public function column_content( $column_name, $post_ID ){
		foreach( $this->columns['columns'] as $column ){
			if( isset( $column['value_type'] ) && ! empty( $column['value_type'] ) && $column['value_type'] === 'meta' ){
				$parsed_value = $this->get_meta_value( $column['meta_key'], $post_ID );
				if( ! empty( $parsed_value ) ){
					$value = $parsed_value;
				}else{
					$value = '';
				}

				if( $column_name === $column['name'] ){
					echo $value;
				}
			}elseif( isset( $column['value_type'] ) && ! empty( $column['value_type'] ) && $column['value_type'] === 'image' ){
				$image = $this->get_featured_image( $post_ID );
				if( isset( $image ) && !empty( $image[0] ) ){
					$value = '<img src="' . $image[0] . '" width="' . $image[1] . '" height="'.$image[2].'"  alt="' . get_the_title( $post_ID ) . '">';
				}else{
					$value = '<img src="http://placehold.it/85x50" alt="' . get_the_title( $post_ID ) . '" >';
				}
				if( $column_name  === $column['name'] ){
					echo $value;
				}
			}
		}
	}

	public function get_meta_value( $key, $id ){
		$value = get_post_meta( $id, $key, true );
		return $value;
	}

	public function get_featured_image( $id ){
		$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'admin-thumb' );
		return $thumb;
	}

	/**
	 * [sort_by_mb_value To Do]
	 * @param  [type] $vars [description]
	 * @return [type]       [description]
	 */
	public function sort_by_mb_value( $vars ){

	}
}