<?php
/**
 * JobScout functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package JobScout
 */

$jobscout_theme_data = wp_get_theme();
if( ! defined( 'JOBSCOUT_THEME_VERSION' ) ) define ( 'JOBSCOUT_THEME_VERSION', $jobscout_theme_data->get( 'Version' ) );
if( ! defined( 'JOBSCOUT_THEME_NAME' ) ) define( 'JOBSCOUT_THEME_NAME', $jobscout_theme_data->get( 'Name' ) );

/**
 * Implement Local Font Method functions.
 */
require get_template_directory() . '/inc/class-webfont-loader.php';

/**
 * Custom Functions.
 */
require get_template_directory() . '/inc/custom-functions.php';

/**
 * Standalone Functions.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Template Functions.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Custom functions for selective refresh.
 */
require get_template_directory() . '/inc/partials.php';

if( jobscout_is_rara_theme_companion_activated() ) :
	/**
	 * Modify filter hooks of RTC plugin.
	 */
	require get_template_directory() . '/inc/rtc-filters.php';
endif;

/**
 * Custom Controls
 */
require get_template_directory() . '/inc/custom-controls/custom-control.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Widgets
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Metabox
 */
require get_template_directory() . '/inc/metabox.php';

/**
 * Getting Started
*/
require get_template_directory() . '/inc/getting-started/getting-started.php';

/**
 * Plugin Recommendation
*/
require get_template_directory() . '/inc/tgmpa/recommended-plugins.php';

/**
 * Add theme compatibility function for woocommerce if active
*/
if( jobscout_is_woocommerce_activated() ){
    require get_template_directory() . '/inc/woocommerce-functions.php';    
}

/**
 * Modify filter hooks of WP Job Manager plugin.
 */
if( jobscout_is_wp_job_manager_activated() ) :
	require get_template_directory() . '/inc/wp-job-manager-filters.php';
endif;

function enqueue_stylesBS5() {
    // Enqueue Bootstrap CSS from CDN
    wp_enqueue_style('enqueue_stylesBS5', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');
}
add_action('wp_enqueue_scripts', 'enqueue_stylesBS5');


function enqueue_scriptBS5() {
    // Enqueue Bootstrap JS from CDN
    wp_enqueue_script('enqueue_scriptBS5', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js');
}
add_action('wp_enqueue_scripts', 'enqueue_scriptBS5');

function enqueue_SeparateBS5() {
    // Enqueue Tailwind CSS from CDN
    wp_enqueue_script('enqueue_SeparateBS5', 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js');
}
add_action('wp_enqueue_scripts', 'enqueue_SeparateBS5');

function enqueue_SeparateBS51() {
    // Enqueue Bootstrap JS from CDN
    wp_enqueue_script('enqueue_SeparateBS51', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js');
}
add_action('wp_enqueue_scripts', 'enqueue_SeparateBS51');
function jobscout_display_blog_section() {
    $blog_heading = get_theme_mod( 'blog_section_title', __( 'NEWEST BLOG ENTRIES', 'jobscout' ) );
    $sub_title    = get_theme_mod( 'blog_section_subtitle', __( '', 'jobscout' ) );
    $blog         = get_option( 'page_for_posts' );
    $label        = get_theme_mod( 'blog_view_all', __( 'See More Posts', 'jobscout' ) );
    $hide_author  = get_theme_mod( 'ed_post_author', false );
    $hide_date    = get_theme_mod( 'ed_post_date', false );
    $ed_blog      = get_theme_mod( 'ed_blog', true );

    $args = array(
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => 6,
        'ignore_sticky_posts' => true
    );

    $qry = new WP_Query( $args );

    if( $ed_blog && ( $blog_heading || $sub_title || $qry->have_posts() ) ) {
        ?>
        <div id="newest-blog">
            <section id="blog-section" class="article-section">
                <div class="container">
                    <?php 
                    if( $blog_heading ) echo '<h2 class="section-title">' . esc_html( $blog_heading ) . '</h2>';
                    if( $sub_title ) echo '<div class="section-desc">' . wpautop( wp_kses_post( $sub_title ) ); 
                    ?>
                    <?php if( $qry->have_posts() ){ ?>
                        <div class="row blog-all-item gy-5">
                            <?php 
                            while( $qry->have_posts() ) {
                                $qry->the_post(); ?>
                                <div class="col-md-6 blog-item">
                                    <div class="p-3 bg-light blog-item1">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <figure class="post-thumbnail">
                                                    <a href="<?php the_permalink(); ?>" class="post-thumbnail">
                                                    <?php 
                                                        if( has_post_thumbnail() ){
                                                            the_post_thumbnail( 'jobscout-blog', array( 'itemprop' => 'image' ) );
                                                        }else{ 
                                                            jobscout_fallback_svg_image( 'jobscout-blog' ); 
                                                        }                            
                                                    ?>                        
                                                    </a>
                                                </figure>
                                            </div>
                                            <div class="col-md-7 blog-item-text">
                                                <article class="post">
                                                    <header class="entry-header">
<h3 class="entry-title">
                                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                        </h3>
                                                        <div class="entry-excerpt">
                                                            <?php the_excerpt(); ?>
                                                        </div>
                                                        <div class="read-more">
                                                            <a href="<?php the_permalink(); ?>">Read More</a>
                                                        </div>
                                                    </header>
                                                </article>
                                            </div>
                                        </div>
                                    </div>
                                </div>			
                                <?php 
                            }
                            wp_reset_postdata();
                            ?>
                        </div>
                    <?php } ?>
                </div>
            </section>
        </div>
        <?php 
    }
}