<?php
/*
	Plugin Name: Notely
	Plugin URI: http://www.thatwebguyblog.com
	Description: Adds a new metabox into the posts and pages Admin sidebar for making notes
	Author: Michael Ott
	Version: 1.0
*/

class twgb_Notely {

    var $plugin_dir;
    var $plugin_url;
    
    function  __construct() {

        add_action( 'add_meta_boxes', array( $this, 'notelypost_meta_box' ) );
		add_action( 'add_meta_boxes', array( $this, 'notelypage_meta_box' ) );
        add_action( 'save_post', array($this, 'save_data') );
    }

	// Add the meta box to the POSTS sidebar
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
	
	// Add the meta box to the PAGES sidebar
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
$twgb_Notely = new twgb_Notely;