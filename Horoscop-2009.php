<?php
/*
	Plugin Name: WP-Horoscop Widget
	Plugin URI: http://horoscop2009.org/wp-horoscop-widget
	Description: Horoscop zilnic - Horoscop2009.org Widget
	Version: 1.1
	Author: Horoscop2009.org
	Author URI: http://horoscop2009.org
	
	Copyright 2009, Horoscop2009.org

	This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

function Horoscop_2009_install () {
	$widgetoptions = get_option('Horoscop2009_widget');
	$newoptions['width'] = '180';
	$newoptions['height'] = '220';
	$newoptions['bgcolor'] = 'ffffff';
	add_option('Horoscop2009_widget', $newoptions);
}

function Horoscop_2009_add_pages() {
	add_options_page('Horoscop2009.org Plugin', 'Horoscop2009.org Plugin', 8, __FILE__, 'Horoscop_2009_options');
}

function Horoscop_2009_init($content){
	if( strpos($content, '[Horoscop-2009]') === false ){
		return $content;
	} else {
		$code = Horoscop_2009_createflashcode(false);
		$content = str_replace( '[Horoscop-2009]', $code, $content );
		return $content;
	}
}

function Horoscop_2009_insert(){
	echo Horoscop_2009_createflashcode(false);
}

function Horoscop_2009_createflashcode($widget){
	if( $widget != true ){
	} else {
		$options = get_option('Horoscop2009_widget');
		$soname = "widget_so";
		$divname = "wpHoroscop2009widgetcontent";
	}
	if( function_exists('plugins_url') ){ 
		$movie = plugins_url('Horoscop-2009/horoscop.swf');
		$path = plugins_url('Horoscop-2009/');
	} else {
		$movie = get_bloginfo('wpurl') . "/wp-content/plugins/Horoscop-2009/horoscop.swf";
		$path = get_bloginfo('wpurl')."/wp-content/plugins/Horoscop-2009/";
	}
	$flashtag = '<!-- SWFObject embed by Geoff Stearns geoff@deconcept.com http://blog.deconcept.com/swfobject/ -->';	
	$flashtag .= '<script type="text/javascript" src="'.$path.'swfobject.js"></script>';
	$flashtag .= '<div id="'.$divname.'"><p style="display:none;">';
	$flashtag .= '</p><p>Plugin <a href="http://horoscop2009.org">Horoscop</a> by <a href="http://horoscop2009.org">Horoscop 2009</a>.org requires Flash Player 8 or better.Plugin creat de <a href="http://horoscop2009.org">Horoscop</a> - <a href="http://horoscop2009.org">Horoscop 2009</a>.org <a href="http://horoscop2009.org">Horoscop saptamanal</a></p></div>';
	$flashtag .= '<script type="text/javascript">';
	$flashtag .= 'var rnumber = Math.floor(Math.random()*9999999);'; // force loading of movie to fix IE weirdness
	$flashtag .= 'var '.$soname.' = new SWFObject("'.$movie.'", "Horoscop2009.org", "'.$options['width'].'", "'.$options['height'].'", "9", "#'.$options['bgcolor'].'");';
	$flashtag .= $soname.'.addParam("allowScriptAccess", "always");';
	$flashtag .= $soname.'.write("'.$divname.'");';
	$flashtag .= '</script>';
	return $flashtag;
}

function Horoscop_2009_options() {	
	$options = $newoptions = get_option('Horoscop2009_options');
	if ( $_POST["Horoscop2009_submit"] ) {
		$newoptions['width'] = strip_tags(stripslashes($_POST["width"]));
		$newoptions['height'] = strip_tags(stripslashes($_POST["height"]));
		$newoptions['bgcolor'] = strip_tags(stripslashes($_POST["bgcolor"]));

	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('Horoscop2009_options', $options);
	}
	
	echo '<form method="post" action="'.get_bloginfo('wpurl').'/wp-admin/options-general.php?page=Horoscop-2009/Horoscop-2009.php">';
	echo "<div class=\"wrap\"><h2>Horoscop2009.org Plugin (Page for next versions)</h2>";
	echo "Comming Soon...";
	echo "</div>";
	
}

function Horoscop_2009_uninstall () {
	delete_option('Horoscop2009_options');
	delete_option('Horoscop2009_widget');
}


function widget_init_Horoscop_2009_widget() {
	if (!function_exists('register_sidebar_widget'))
		return;

	function Horoscop_2009_widget($args){
	    extract($args);
		$options = get_option('Horoscop2009_widget');
		$title = empty($options['title']) ? __('Horoscop Widget') : $options['title'];
		?>
	        <?php echo $before_widget; ?>
				<?php echo $before_title . $title . $after_title; ?>
				<?php 
					if( !stristr( $_SERVER['PHP_SELF'], 'widgets.php' ) ){
						echo Horoscop_2009_createflashcode(true);
					}
				?>
	        <?php echo $after_widget; ?>
		<?php
	}
	
	function Horoscop_2009_widget_control() {
		$options = $newoptions = get_option('Horoscop2009_widget');
		if ( $_POST["Horoscop2009_widget_submit"] ) {
			$newoptions['title'] = strip_tags(stripslashes($_POST["Horoscop2009_widget_title"]));
			$newoptions['width'] = strip_tags(stripslashes($_POST["Horoscop2009_widget_width"]));
			$newoptions['height'] = strip_tags(stripslashes($_POST["Horoscop2009_widget_height"]));
			$newoptions['bgcolor'] = strip_tags(stripslashes($_POST["Horoscop2009_widget_bgcolor"]));
		}
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('Horoscop2009_widget', $options);
		}
		$title = attribute_escape($options['title']);
		$width = attribute_escape($options['width']);
		$height = attribute_escape($options['height']);
		$bgcolor = attribute_escape($options['bgcolor']);
		?>
			<p><label for="Horoscop2009_widget_title"><?php _e('Title:'); ?> <input class="widefat" id="Horoscop2009_widget_title" name="Horoscop2009_widget_title" type="text" value="<?php echo $title; ?>" /></label></p>
			<p><label for="Horoscop2009_widget_width"><?php _e('Width:'); ?> <input class="widefat" id="Horoscop2009_widget_width" name="Horoscop2009_widget_width" type="text" value="<?php echo $width; ?>" /></label></p>
			<p><label for="Horoscop2009_widget_height"><?php _e('Height:'); ?> <input class="widefat" id="Horoscop2009_widget_height" name="Horoscop2009_widget_height" type="text" value="<?php echo $height; ?>" /></label></p>
			<p><label for="Horoscop2009_widget_bgcolor"><?php _e('Background color:'); ?> <input class="widefat" id="Horoscop2009_widget_bgcolor" name="Horoscop2009_widget_bgcolor" type="text" value="<?php echo $bgcolor; ?>" /></label></p>
			<input type="hidden" id="Horoscop2009_widget_submit" name="Horoscop2009_widget_submit" value="1" />
		<?php
	}
	
	register_sidebar_widget( "Horoscop Widget", Horoscop_2009_widget );
	register_widget_control( "Horoscop Widget", "Horoscop_2009_widget_control" );
}

add_action('widgets_init', 'widget_init_Horoscop_2009_widget');

add_action('admin_menu', 'Horoscop_2009_add_pages');
add_filter('the_content','Horoscop_2009_init');
register_activation_hook( __FILE__, 'Horoscop_2009_install' );
register_deactivation_hook( __FILE__, 'Horoscop_2009_uninstall' );
?>