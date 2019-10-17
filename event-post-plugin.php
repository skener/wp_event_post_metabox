<?php
    
    /**
     * Plugin name: Events post type
     * Plugin URI:        https://skener.githu.io/cv
     * Description:       Create Event Post Type and add two metabox fields.
     * Version:           1.0.0
     * Author:            Andriy Tserkovnyk <skenerster@gmail.com>
     * Author URI:        https://skener.githu.io/cv
     * Text Domain:       skener
     *
     * @package WordPress.
     */
    
    require __DIR__ . '/vendor/autoload.php';
    
    use Admin\EventPostMetaBox;
    
    if (class_exists('Admin\EventPostMetaBox')) {
        
        $adminPlug = new EventPostMetaBox();
        
    } else {
        echo 'Some Error';
    }
