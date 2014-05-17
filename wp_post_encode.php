<?php
/*
Plugin Name: WP Post Encode
Plugin URI: http://darrinb.com/notes/2010/wp-post-encode/
Description: Easily include raw code  in posts.  Based off of "bb_encodeit" used in bbPress comment system.
Version: 1.5
Author: Darrin Boutote
Author URI: http://darrinb.com
*/
/*
Copyright 2010  Darrin Boutote  (contact : http://darrinb.com/hello/)
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/


class dbdbPostEncode {
	
	public function __construct() {
		add_action( 'admin_print_footer_scripts', array(&$this, 'add_quicktags'), 100 );
		add_action( 'wp_insert_post_data', array(&$this, 'quick_encode'), 1, 1);
		add_filter( 'the_content', array(&$this, 'post_encode'), 1, 1);
		
	}
	
	/**
	 * Add a button to the Text Editor
	 */
	public function add_quicktags() {
		if (wp_script_is('quicktags')){ ?>
			<script type="text/javascript" charset="utf-8">
				// <![CDATA[
				if ( typeof QTags != 'undefined' ) {
					QTags.addButton( 'db_pencode', 'encode', '<!--encode-->', '<!--/encode-->', '', 'Column Section', '', '' );
				}
				// ]]>
			</script>		
		<?php }
	}	
	
	// Encode WP default quicktags
	public function quick_encode($content_text) {	
		$charset = get_bloginfo('charset');
		$replaced_text = preg_replace('#(<!--encode-->)(.*?)(<!--/encode-->)#isme', "'$1'.str_replace(array('<!--nextpage-->', '<!--more-->'), array('&lt;!--nextpage--&gt;', '&lt;!--more--&gt;'), '$2').'$3'", $content_text);
		foreach($replaced_text as $k => $v ) {
			$encoded_text[$k] = str_replace(array('\"'),array('"'), $v);
		}
		return $encoded_text;
	}
	
	public function post_encode($text) {
		$text = str_replace(array("\r\n", "\r"), "\n", $text);  // replace any carriage returns and/or new lines with a new line.
		$text = preg_replace_callback("#(<!--encode-->)(.*?)(<!--/encode-->)#is", array(&$this,'code_encode'), $text);
		return $text;
	}
	
	public function code_encode( $matches ) {
		$charset = get_bloginfo('charset');
		$text = trim($matches[2]);
		$text = str_replace(array('&lt;!--nextpage--&gt;', '&lt;!--more--&gt;'), array('<!--nextpage-->', '<!--more-->'), $text); // quicktag filtering
		$text = htmlspecialchars($text, ENT_QUOTES, $charset);  // encode html chars.
		$text = str_replace('[','&#91;', $text);                // shortcode filtering
		$text = str_replace(array("\r\n", "\r"), "\n", $text);  // replace any carriage returns and/or new lines with a new line.
		$text = preg_replace("#\n\n\n+#", "\n\n", $text);       // replace any multiple new lines with 2 new lines.
		return $text;
	}
	
}


new dbdbPostEncode();