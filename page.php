<?php
/**
 * Page template.
 *
 * Pages (and the block-built custom post types routed here) are composed
 * entirely from blocks, each of which carries its own .container.
 *
 * @package cb-hesis2026
 */

get_header();

while ( have_posts() ) {
	the_post();
	the_content();
}

get_footer();
