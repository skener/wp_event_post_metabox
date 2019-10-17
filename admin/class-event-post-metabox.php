<?php

//defined('ABSPATH') or die();
    
    namespace Admin;
    
    class EventPostMetaBox
    {
        
        public function __construct()
        {
            
            add_action('init', [$this, 'custom_post_type']);
            add_action('add_meta_boxes', [$this, 'add_event_metaboxes']);
            add_action('save_post', [$this, 'save_event_meta_post']);
            
        }
        
        public function activate()
        {
            
            $this->custom_post_type();
            
            flush_rewrite_rules();
        }
        
        public function deactivate()
        {
            
            flush_rewrite_rules();
        }
        
        public function custom_post_type()
        {
            register_post_type('event',
                [
                    'labels'             => [
                        'name'          => 'Event',
                        'add_new_item'  => ' Add New Event',
                        'menu_name'     => 'Events',
                        'singular_name' => 'Event'
                    ],
                    'public'             => true,
                    'publicly_queryable' => true,
                    'show_ui'            => true,
                    'show_in_menu'       => true,
                    'query_var'          => true,
                    'rewrite'            => array ('slug' => 'event'),
                    'capability_type'    => 'post',
                    'has_archive'        => true,
                    'hierarchical'       => false,
                    'menu_position'      => null,
                    'supports'           => array ('title', 'editor', 'author')
                ]);
        }
        
        public function event_form_markup_func()
        {
            global $post;
            wp_nonce_field(basename(__FILE__), "event-meta-box-nonce");
            $inputOne = get_post_meta($post->ID, 'event_input_msg_1', true);
            $inputTwo = get_post_meta($post->ID, 'event_input_msg_2', true);
            ?>
            <div>
                <table>
                    <tr>
                        <td>
                            <label for="inputOne"><p>Input 1:</p></label>
                            <textarea id="inputOne" name="inputOne" rows="3" cols="50" placeholder="...">
					<?php echo esc_attr($inputOne); ?>
                    </textarea>
                        </td>
                        <td>
                            <label for="inputTwo"><p>Input 2:</p></label>
                            <textarea id="inputTwo" name="inputTwo" rows="3" cols="50" maxlength="50" placeholder="...">
					<?php echo esc_attr($inputTwo); ?>
                    </textarea>
                        </td>
                    </tr>
                </table>
            </div>
            <?php
        }
        
        public function add_event_metaboxes()
        {
            
            add_meta_box('event_id', 'Event-meta-box', [$this, 'event_form_markup_func'], 'event', 'normal', 'high',
                null);
            
        }
        
        public function save_event_meta_post($post_id)
        {
            
            // Check if our nonce is set.
            if ( ! isset($_POST['event-meta-box-nonce'])) {
                return $post_id;
            }
            
            $nonce = $_POST['event-meta-box-nonce'];
            
            // Verify that the nonce is valid.
            if ( ! wp_verify_nonce($nonce, basename(__FILE__))) {
                return $post_id;
            }
            
            if (isset($_POST['inputOne'])):
                $inputOne = sanitize_text_field($_POST['inputOne']);
            endif;
            if (isset($_POST['inputTwo'])):
                $inputTwo = sanitize_text_field($_POST['inputTwo']);
            endif;
            
            // Update the meta field.
            update_post_meta($post_id, 'event_input_msg_1', $inputOne);
            update_post_meta($post_id, 'event_input_msg_2', $inputTwo);
        }
        
    }