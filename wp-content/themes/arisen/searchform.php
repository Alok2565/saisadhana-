<?php
/**
 * The Template for displaying pages
 *
 * @package WordPress
 * @subpackage Arisen
 * @since Arisen 1.0
 */
?>

<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="search-div">
		<input type="text" class="search" value="<?php echo esc_html( get_search_query() ); ?>" name="s" id="s" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'arisen' ) ?>" />
	</div>
	<div class="button-div">
		<button type="submit" id="searchsubmit" class="search-button"><i class="search-icon fa fa-search" aria-hidden="true"></i></button>
	</div>
</form>