<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package JobScout
 */

get_header(); ?>

    <div id="primary" class="content-area">
        
        <?php 
        /**
         * Before Posts hook
        */
        do_action( 'jobscout_before_posts_content' );

        // Gọi hàm hiển thị blog section
        if ( function_exists( 'jobscout_display_blog_section' ) ) {
            jobscout_display_blog_section();
        }
        ?>
        
        <main id="main" class="site-main">

       
        </main><!-- #main -->
        
        <?php
        /**
         * After Posts hook
         * @hooked jobscout_navigation - 15
        */
        do_action( 'jobscout_after_posts_content' );
        ?>
        
    </div><!-- #primary -->

<?php
get_sidebar();
get_footer();