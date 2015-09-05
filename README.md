# Raw Tool Box Post Type Generator
Post Type Generator Class for developers



## Usage:
1. require it inside your theme or plugin
````
	require( get_template_directory() . '/rtb-post-type/rtb-post-type.class.php' );
````

2. We're going to create a portfolio post type
````
	$portfolio = new RawToolBox_PostType( $singular_name, $menu_name = '', $plural_name, $post_type_slug );
	$portfolio->set_menu_icon( 'dashicons-portfolio' );
	$portfolio->set_menu_position( 5 );
	$portfolio->set_parent_menu( true );	'true|edit.php?post_type=post|page|'
````


#### Even you can create columns created with this generator
```` $columns = array(
		'admin_column'		=>	true,
		'columns'			=> array(
			array(
				'column_title'	=>	__( 'Featured Image', RTB_TD ),
				'name'			=>	'featured-image',
				'value_type'	=> 'image'
			),
			array(
				'column_title'	=>	__( 'Author', RTB_TD ),
				'name'			=>	'author',		// built in feature
			),

			//usage instruction for Adding Metabox Field into admin columns
			// array(
			// 	'column_title'	=>	__( 'Metabox', RTB_TD ),
			// 	'value_type'	=>	'meta',
			// 	'name'			=>	'abcs',
			// 	'meta_key'		=>	'_custom_meta_key'	//additional arguments for meta value type
			// ),


		)
	);
	$portfolio->set_admin_columns( $columns );



