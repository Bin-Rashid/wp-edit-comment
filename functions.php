<?php 
// if ( class_exists( 'Attachments' ) ) {
//     require_once "Lib/attachment.php";
// }




// if(site_url() == 'http://localhost/LWSBR'){
//     define("VERSION", time());
// }else{
//     define("VERSION", wp_get_theme()->get("Version"));
// }

// function errorfixer_bootstraping(){
//     // Load theme's text domain for translation
//     load_theme_textdomain("errorfixer");
    
//     // Add support for post thumbnails (featured images)
//     add_theme_support('post-thumbnails');
    
    
//     // Add support for dynamic title tag
//     add_theme_support("title-tag");
//     $errorfixer_custom_header_details = array(
//         'header-text' => true,
//         'default-text-color' => '#333',
//         'width' => 1200,
//         'height' => 600,
//         'flex-height' => true,
//         'flex-width' => true

//     );
//     $errorfixer_custom_logo = array(
//         'height' => 100,
//         'weidth' => 1000

//     );

//     add_theme_support("custom-header", $errorfixer_custom_header_details);
//     add_theme_support("custom-logo", $errorfixer_custom_logo);
//     add_theme_support("custom-background");
//     add_theme_support( 'html5', array( 'search-form' ) );

//     // Register Menu Location
//     register_nav_menu('primary', __("Primary Menu","errorfixer"));
//     register_nav_menu('footermenu', __("Footer Menu","errorfixer"));

//     add_theme_support("post-formats", array(
//         "image",
//         "quote",
//         "video",
//         "audio",
//         "link"
//     ));
//     add_image_size('errorfixer_blogImage', 550, 200, true);
// }

// // Hook the function to the 'after_setup_theme' action
// add_action('after_setup_theme', 'errorfixer_bootstraping');

// function enqueue_errorfixer_assets() {
//     wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
//     // Enqueue Bootstrap CSS from CDN
//     wp_enqueue_style('bootstrap-css', '//cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', array(), null);

//     // Enqueue Featherlight CSS for lightbox functionality
//     wp_enqueue_style('featherlight-css', '//cdn.jsdelivr.net/npm/featherlight@1.7.14/release/featherlight.min.css', array(), time());
//     wp_enqueue_style("dashicons");
//     // tiny slider css
//     wp_enqueue_style('tns-slider-css', '//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css');
//     // Enqueue the theme's stylesheet
//     wp_enqueue_style('theme-stylesheet', get_stylesheet_uri(),null,VERSION);

//     // Enqueue Featherlight JS for lightbox functionality, with jQuery as a dependency
//     wp_enqueue_script('tns-js', '//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js', array('jquery'), null, true);
//     wp_enqueue_script('featherlight-js', '//cdn.jsdelivr.net/npm/featherlight@1.7.14/release/featherlight.min.js', array('jquery'), null, true);
//     wp_enqueue_script('main-js', get_theme_file_uri('assets/js/main.js'), array('jquery','featherlight-js'), VERSION, true);
// }

// // Hook the function to wp_enqueue_scripts action
// add_action('wp_enqueue_scripts', 'enqueue_errorfixer_assets');


// // sidebar register
// function errorfixer_register_sidebars() {
//     register_sidebar(array(
//         'name'          => __('Error Fixer Sidebar Single', 'errorfixer'),
//         'id'            => 'errorfixer-sidebar-1',//most important thing in sidebar register is id.
//         'description' => __('Our Right sidebar', 'errorfixer'),
//         'before_widget' => '<section id="%1$s" class="widget %2$s">',
//         'after_widget'  => '</section>',
//         'before_title'  => '<h2 class="widget-title">',
//         'after_title'   => '</h2>'

 
//     ));
//     register_sidebar(array(
//         'name'          => __('Error Fixer Sidebar Footer Left', 'errorfixer'),
//         'id'            => 'errorfixer-sidebar-footer-left',//most important thing in sidebar register is id.
//         'description' => __('Our Footer left sidebar', 'errorfixer'),
//         'before_widget' => '<section id="%1$s" class="widget %2$s">',
//         'after_widget'  => '</section>',
//         'before_title'  => '',//jehetu footer a widget dekhabo tai title na rakhi
//         'after_title'   => ''

 
//     ));
//     register_sidebar(array(
//         'name'          => __('Error Fixer Sidebar Footer Right', 'errorfixer'),
//         'id'            => 'errorfixer-sidebar-footer-right',//most important thing in sidebar register is id.
//         'description' => __('Our Footer Right sidebar', 'errorfixer'),
//         'before_widget' => '<section id="%1$s" class="widget %2$s">',
//         'after_widget'  => '</section>',
//         'before_title'  => '',
//         'after_title'   => ''

 
//     ));

// }

// add_action("widgets_init","errorfixer_register_sidebars");



// // Protected Post customization

// function errorfixer_protected_post($excerpt){
//     if(!post_password_required()){
//         return $excerpt;
//     }else{
//         echo get_the_password_form();
//     }
// }
// add_filter('the_excerpt', 'errorfixer_protected_post');

// // Protected Title customization

// function errorfixer_protected_title($title){
//     return "%s"; //%s holo string replace hobe jeta php print ba print_r a hoy.
// }
// add_filter("protected_title_format" , "errorfixer_protected_title");


// // Menu Location Functionality 

// function errorfixer_menu_item_class($classes , $item){
//     $classes[] = "list-inline-item";
//     return $classes; 

// }

// add_filter( 'nav_menu_css_class', 'errorfixer_menu_item_class', 10, 2 );


// function errorfixer_page_template_banner(){
//     if(is_page()){
//         $errorfixer_feat_image = get_the_post_thumbnail_url(null, "large");
//         ?>
//         <style>
//             .page-header {
//                 background-image: url(<?php echo esc_url($errorfixer_feat_image); ?>);
//             }
//         </style>
//         <?php
//     }

//     if(is_front_page()){
//         if(current_theme_supports("custom-header")){
//             ?>
//             <style>
//                 .header{
//                     background-image: url(<?php header_image(); ?>);
//                     margin-bottom: 50px;
//                     background-size: cover;
//                 }

//                 .header h1.heading a, h3.tagline{
//                     color: #<?php echo get_header_textcolor(); ?>;

//                     <?php
//                     if(!display_header_text()){
//                         echo "display: none";
//                     }
//                     ?>

//                 }
//             </style>

//             <?php
//         }
//     }
// }

// add_action("wp_head", "errorfixer_page_template_banner", 11);


// function errorfixer_customize_register($wp_customize) {
//     $wp_customize->add_section('hero_section', array(
//         'title'    => __('Hero Section', 'errorfixer'),
//         'priority' => 30,
//     ));

//     $wp_customize->add_setting('portfolio_image', array(
//         'default'   => '',
//         'transport' => 'refresh',
//     ));

//     $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'portfolio_image', array(
//         'label'    => __('Portfolio Image', 'errorfixer'),
//         'section'  => 'hero_section',
//         'settings' => 'portfolio_image',
//     )));
// }
// add_action('customize_register', 'errorfixer_customize_register');



// function highlight_search_terms($text) {
//     if (is_search()) {
//         $pattern = '/('.join('|',explode(' ', get_search_query())).')/i';
//         $text = preg_replace($pattern, '<span class="highlight">\0</span>', $text);
//     }
//     return $text;
// }

// add_filter('the_content', 'highlight_search_terms');
// add_filter('the_excerpt', 'highlight_search_terms');
// add_filter('the_title', 'highlight_search_terms');

// this code is for popup comment edit form and edit comment after that save comment ajax req
function update_comment_callback() {
    if (isset($_POST['comment_ID']) && isset($_POST['comment_content'])) {
        $comment_data = array(
            'comment_ID' => intval($_POST['comment_ID']),
            'comment_content' => sanitize_text_field($_POST['comment_content'])
        );
        wp_update_comment($comment_data);
        echo 'success';
    }
    wp_die();
}
add_action('wp_ajax_update_comment', 'update_comment_callback');





