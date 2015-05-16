<?php
/*
	Plugin Name: Notely
	Plugin URI: http://michaelott.id.au
	Description: Adds a new metabox into the Posts, Pages and Woo Commerce Products admin sidebar for making notes.
	Author: Michael Ott
	Version: 1.3
*/

class twgb_notely {

    function  __construct() {

        add_action( 'add_meta_boxes', array( $this, 'notelypost_meta_box' ) );
		add_action( 'add_meta_boxes', array( $this, 'notelypage_meta_box' ) );
		add_action( 'add_meta_boxes', array( $this, 'notelywoo_meta_box' ) );
        add_action( 'save_post', array($this, 'save_data') );
    }

	// Add the meta box to POSTS
    function notelypost_meta_box(){
        add_meta_box(
             'notes'
            ,'Post Notes'
            ,array( &$this, 'meta_box_content' )
            ,'post'
            ,'side'
            ,'default'
        );
    }

	// Add the meta box to PAGES
    function notelypage_meta_box(){
        add_meta_box(
             'notes'
            ,'Page Notes'
            ,array( &$this, 'meta_box_content' )
            ,'page'
            ,'side'
            ,'default'
        );
    }

	// Add the meta box to Woo Commerce Product
    function notelywoo_meta_box(){
		if ( class_exists( 'WooCommerce' ) ) {
			add_meta_box(
				 'notes'
				,'Product Notes'
				,array( &$this, 'meta_box_content' )
				,'product'
				,'side'
				,'default'
			);
		}
	}

    function meta_box_content(){
        global $post;
        // Use nonce for verification
        wp_nonce_field( plugin_basename( __FILE__ ), 'twgb_notely_nounce' );

        // The actual fields for data entry
        echo '<textarea id="notelyfield" name="notelyfield" size="20" style="width:100%; height:120px;">' . get_post_meta($post->ID, 'notely', TRUE) . '</textarea>';
    }

    function save_data($post_id){
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return;

        if ( !wp_verify_nonce( $_POST['twgb_notely_nounce'], plugin_basename( __FILE__ ) ) )
            return;

        // Check permissions
        if ( 'page' == $_POST['post_type'] ){
            if ( !current_user_can( 'edit_page', $post_id ) )
                return;
        }else{
            if ( !current_user_can( 'edit_post', $post_id ) )
                return;
        }
        $data = $_POST['notelyfield'];
        update_post_meta($post_id, 'notely', $data, get_post_meta($post_id, 'notely', TRUE));
        return $data;
    }
}
$twgb_notely = new twgb_notely;


add_action( 'admin_enqueue_scripts', 'load_admin_styles' );
function load_admin_styles() {
    wp_enqueue_style( 'admin_notely_css', plugins_url() . '/notely/css/notely.css', false, '1.0.0' );
}


// Add JS to admin
function my_custom_js() {
    echo '<script type="text/javascript" src="' . plugins_url() . '/notely/js/notely.js"></script>';
}
// Add hook for admin <head></head>
add_action('admin_head', 'my_custom_js');






// Add notely to POST admin columns
add_filter('manage_posts_columns', 'notely_post_columns');
function notely_post_columns($columns) {
    $columns['notely'] = 'Notes';
    return $columns;
}

add_action('manage_posts_custom_column',  'notely_show_post_columns');
function notely_show_post_columns($name) {
    global $post;
    switch ($name) {
        case 'notely':
            $notely = get_post_meta($post->ID, 'notely', true);
            $options = get_option( 'notely_settings' );
            if ($notely !="") { ?>

                <?php if($options['visibility'] == "hidden") { ?>

                    <span class="notely-icon note-icon-<?php echo $options['note_color']; ?>" title="Show Notes">&#9780;</span>
                    <pre class="notely-preserve"><?php echo $notely; ?></pre>

                <?php } else { ?>
                    <pre class="notely-preserve notely-preserve-shown"><?php echo $notely; ?></pre>
                <?php } ?>

            <?php }

    }
}




// Add notely to PAGE admin columns
add_filter('manage_pages_columns', 'notely_page_columns');
function notely_page_columns($columns) {
    $columns['notely'] = 'Notes';
    return $columns;
}

add_action('manage_pages_custom_column',  'notely_show_page_columns');
function notely_show_page_columns($name) {
    global $post;
    switch ($name) {
        case 'notely':
            $notely = get_post_meta($post->ID, 'notely', true);
            $options = get_option( 'notely_settings' );
            if ($notely !="") { ?>

                <?php if($options['visibility'] == "hidden") { ?>

                    <span class="notely-icon note-icon-<?php echo $options['note_color']; ?>" title="Show Notes">&#9780;</span>
                    <pre class="notely-preserve"><?php echo $notely; ?></pre>

                <?php } else { ?>
                    <pre class="notely-preserve notely-preserve-shown"><?php echo $notely; ?></pre>
                <?php } ?>

            <?php }

    }
}


// ---------------------------
// Notely Settings -
// ---------------------------

// Register settings
function notely_settings_init(){
    register_setting( 'notely_settings', 'notely_settings' );
}

// Add settings page to menu
function add_notely_settings_page() {
    add_options_page( 'Notely', 'Notely', 'manage_options', 'notely-settings', 'notely_settings_page' );
}

// Add actions
add_action( 'admin_init', 'notely_settings_init' );
add_action( 'admin_menu', 'add_notely_settings_page' );


// Define your variables
$color_scheme = array('default','blue','green',);

// Start settings page
function notely_settings_page() {
?>
<div class="wrap">
    <h2>Notely</h2>

    <form method="post" action="options.php">
    	<?php settings_fields( 'notely_settings' ); ?>
        <?php $options = get_option( 'notely_settings' ); ?>

        <table class="form-table notely-form-table">
            <tbody>
                <tr>
                    <td><strong>Admin Column Display</strong></td>
                    <td>
                        <p><input type="radio" class="dash_red" name="notely_settings[visibility]" value="hidden"<?php checked( 'hidden' == $options['visibility'] ); ?> /> Hidden (Tap icon to reveal note)</p>
                        <p><input type="radio" class="dash_blue" name="notely_settings[visibility]" value="visible"<?php checked( 'visible' == $options['visibility'] ); ?> /> Visible (Always)</p>
                    </td>
                </tr>

                <tr>
                    <td><strong>Note Icon Colour</strong></td>
                    <td>
                        <p><label><input type="radio" name="notely_settings[note_color]" value="default"<?php checked( 'default' == $options['note_color'] ); ?> /> Default</label></p>
                        <p><label><input type="radio" name="notely_settings[note_color]" value="red"<?php checked( 'red' == $options['note_color'] ); ?> /> Red</label></p>
                        <p><label><input type="radio" name="notely_settings[note_color]" value="blue"<?php checked( 'blue' == $options['note_color'] ); ?> /> Blue</label></p>
                        <p><label><input type="radio" name="notely_settings[note_color]" value="yellow"<?php checked( 'yellow' == $options['note_color'] ); ?> /> Yellow</label></p>
                    </td>
                </tr>

            </tbody>
        </table>

        <p class="padder"><input name="submit" class="button button-primary" value="Save Settings" type="submit" /></p>

    </form>
</div>

<?php }
//sanitize and validate
function notely_options_validate( $input ) {
    global $select_options, $radio_options;
    if ( ! isset( $input['option1'] ) )
        $input['option1'] = null;
    $input['option1'] = ( $input['option1'] == 1 ? 1 : 0 );
    $input['sometext'] = wp_filter_nohtml_kses( $input['sometext'] );
    if ( ! isset( $input['radioinput'] ) )
        $input['radioinput'] = null;
    if ( ! array_key_exists( $input['radioinput'], $radio_options ) )
        $input['radioinput'] = null;
        $input['sometextarea'] = wp_filter_post_kses( $input['sometextarea'] );
    return $input;
}
