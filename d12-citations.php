<?php
/*
Plugin Name: d12 MLA Citations
Plugin URI: http://www.kjodle.net/wordpress/mla-citations/
Description: Easily add MLA style citations to your WordPress posts.
Version: 1.0
Author: Kenneth John Odle
Author URI: http://techblog.kjodle.net
Author Support: http://kjodle.info/support

Copyright 2015 Kenneth John Odle
© 2015 Kenneth John Odle

Released under the GPL v.3, http://www.gnu.org/copyleft/gpl.html

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 3, as 
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Prevent this page from being loaded directly.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// Make non-self-enclosing shortcodes work
define('FILTERPRIORITY', 10);
add_filter('the_content', 'do_shortcode', FILTERPRIORITY);

// Let's add our stylesheets:
function d12cite_styles() {
	wp_enqueue_style( 'screenstyle', plugins_url( '/css/d12citescreen.css', __FILE__, '1.0', 'screen' ) );
	wp_enqueue_style( 'printstyle', plugins_url( '/css/d12citeprint.css', __FILE__, '1.0', 'print' ) );
}
add_action( 'wp_enqueue_scripts', 'd12cite_styles' );

// Add shortcodes to clear floats
function clearboth_shortcode() {
	return '<div class="d12clear"></div>';
	}
add_shortcode ('clear', 'clearboth_shortcode');

function clearleft_shortcode() {
	return '<div class="d12clearleft"></div>';
	}
add_shortcode ('clearleft', 'clearleft_shortcode');

function clearright_shortcode() {
	return '<div class="d12clearright"></div>';
	}
add_shortcode ('clearright', 'clearright_shortcode');

// Add shortcode for smaller text
function smalltext_shortcode_handler( $atts, $content=null ) {
	return '<span class="smalltext">' . $content . '</span>';
}
add_shortcode( 'small', 'smalltext_shortcode_handler' );

// Add MLA style "Works Cited" section //
function d12mlaworks_cited( $atts , $content = null ) {
return '<div id="d12src">
<p class="d12mlatitle">Works Cited</p>' . $content . '</div>';
}
add_shortcode( 'mlaworks', 'd12mlaworks_cited' );

// Add "d12mlabook" shortcode for "Works Cited" section //
function d12mlabook_shortcode( $atts ) {
	extract( shortcode_atts(
		array(
			'author' => '',
			'title' => '',
			'city' => '',
			'publisher' => '',
			'year' => '',
			'medium' => '',
			'addt' => '',
		), $atts )
	);
	if ($author == null) {$authorend = "";} else {$authorend = ". ";}
	if ($addt == null) {$mediumend = ".";} else {$mediumend = ". ";}
return html_entity_decode('<p class="d12srcp">' . $author . $authorend . '<i>' . $title . '</i>. ' . $city . ': ' . $publisher . ', ' . $year . '. ' . $medium . $mediumend . $addt . '</p>');
}
add_shortcode( 'mlabook', 'd12mlabook_shortcode' );

// Add "d12mlajournal" shortcode for "Works Cited" section //
function d12mlajournal_shortcode( $atts ) {
	extract( shortcode_atts(
		array(
			'author' => '',
			'title' => '',
			'journal' => '',
			'volume' => '',
			'issue' => '',
			'year' => '',
			'pages' => '',
			'medium' => '',
			'addt' => '',
		), $atts )
	);
	if ($author == null) {$authorend = "";} else {$authorend = ". ";}
	if ($addt == null) {$mediumend = ".";} else {$mediumend = ". ";}
return html_entity_decode(
	'<p class="d12srcp">' . $author . $authorend . 
	'&ldquo;' . $title . '.&rdquo;' . 
	'<i>' . $journal . '</i>. ' . 
	$volume . '.' . 
	$issue . 
	' (' . $year . '): ' . 
	$pages . '. ' . 
	$medium . $mediumend . $addt . 
	'</p>');
}
add_shortcode( 'mlajournal', 'd12mlajournal_shortcode' );

// Add "d12mlamagazine" shortcode for "Works Cited" section //
function d12mlamagazine_shortcode( $atts ) {
	extract( shortcode_atts(
		array(
			'author' => '',
			'title' => '',
			'magazine' => '',
			'date' => '',
			'pages' => '',
			'medium' => '',
			'addt' => '',
		), $atts )
	);
	if ($author == null) {$authorend = "";} else {$authorend = ". ";}
	if ($addt == null) {$mediumend = ".";} else {$mediumend = ". ";}
return html_entity_decode(
	'<p class="d12srcp">' . $author . $authorend . 
	'&ldquo;' . $title . '.&rdquo; ' . 
	'<i>' . $magazine . '</i>. ' . 
	$date . ': ' . 
	$pages . '. ' . 
	$medium . $mediumend . $addt . 
	'</p>');
}
add_shortcode( 'mlamagazine', 'd12mlamagazine_shortcode' );

// Add note paragraph 
function d12citationnote_shortcode_handler( $atts, $content=null, $code="" ) {
	return '<p class="d12citenote">' . $content . '</p>';
}
add_shortcode( 'note' , 'd12citationnote_shortcode_handler' );

// Add a highlighting shortcode
function d12highlightyellow_handler( $atts, $content=null ) {
	return '<span class="d12highlightyellow">' . $content . '</span>';
}
add_shortcode( 'hly' , 'd12highlightyellow_handler' );
