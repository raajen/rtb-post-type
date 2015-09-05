# Raw Tool Box Post Type Generator
Post Type Generator Class for developers



## Usage:
1. Include it inside your theme or plugin. Usage for theme is shown here
````
	require( get_template_directory() . '/rtb-post-type/rtb-post-type.class.php' );
````

2. We're going to create a portfolio post type
````
	$singular_name = 'Portfolio';
	$menu_name = 'Portfolios';	// can be empty, if it is not set, plural name is used
	$plural_name = 'Portfolios';
	$post_type_slug = 'rtb_portfolio';

	$portfolio = new RawToolBox_PostType( $singular_name, $menu_name = '', $plural_name, $post_type_slug );

	OR,

	$portfolio = new RawToolBox_PostType( 'Portfolio', 'Portfolios', 'Portfolios', 'rtb_portfolio' );

	//set custom menu icon
	$portfolio->set_menu_icon( 'dashicons-portfolio' );

	//set menu position
	$portfolio->set_menu_position( 5 );

	// Important: Creates 'Portfolios' menu or nest them inside any Other heading
	$portfolio->set_parent_menu( true );	'true|edit.php?post_type=post|page|'
````

#### You can rewrite default post type slug in this way
````
	$portfolio->set_rewrite( true );
	$portfolio->set_custom_slug( 'portfolio' );
````

#### Lets make it hierarchical like pages
````
	$portfolio->set_hierarchical( true );
````

#### Even you can create columns created with this generator
```` 
	$columns = array(
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
````

## Many More if you dig into the class


