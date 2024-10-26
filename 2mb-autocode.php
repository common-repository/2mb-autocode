<?php
/*
Author: 2MB Solutions
Author URI: https://2mb.solutions/
Description: This plugin allows you to place predetermined text, php, or shortcodes at the top and/or bottom of posts.
Plugin Name: 2MB Autocode
Plugin URI: https://2mb.solutions/plugins/autocode
Version: 1.2.6
License: Gpl v2 or later
*/
add_filter('the_content', 'twomb_autocode_modify_content', 8); //Actually add top and bottom content.
function twomb_autocode_modify_content($content) {
    $count = 0; //Do'nt include top content if ##no_top## is set.
    $content = str_replace('##no_top##', '', $content, $count);
    $count2 = 0; //Same, but for bottom.
    $content = str_replace('##no_bottom##', '', $content, $count2);
    $count3 = 0; //Same, but only for top content on the home page.
    $content = str_replace('##no_top_home##', '', $content, $count3);
    $count4 = 0; //Ditto, but for bottom home content.
    $content = str_replace('##no_bottom_home##', '', $content, $count4);
    $count5 = 0; //No top content on the single post page.
    $content = str_replace('##no_top_post##', '', $content, $count5);
    $count6 = 0; //Same, but for the bottom.
    $content = str_replace('##no_bottom_post##', '', $content, $count6);
    $count7 = 0; //We don't want to echo the content twice if they chose an override of placement.
    if(get_option('2mb_autocode_toptype') == 0) {
        $content = str_replace('##do_top##', do_shortcode(get_option('2mb_autocode_topstring')), $content, $count7);
    }
    else if(get_option('2mb_autocode_toptype') == 1) {
                ob_start();
                eval(get_option('2mb_autocode_topstring'));
                $topstring = ob_get_contents();
                ob_end_clean();
        $content = str_replace('##do_top##', do_shortcode($topstring), $content, $count7);
    }
    else {
        $content = str_replace('##do_top##', '<pre>'.get_option('2mb_autocode_topstring').'</pre>', $content, $count7);
    }
    $count8 = 0; //Same, but for bottom.
    if(get_option('2mb_autocode_bottomtype') == 0) {
        $content = str_replace('##do_bottom##', do_shortcode(get_option('2mb_autocode_bottomstring')), $content, $count8);
    }
    else if(get_option('2mb_autocode_bottomtype') == 1) {
                ob_start();
                eval(get_option('2mb_autocode_bottomstring'));
                $bottomstring = ob_get_contents();
                ob_end_clean();
        $content = str_replace('##do_bottom##', do_shortcode($bottomstring), $content, $count8);
    }
    else {
        $content = str_replace('##do_bottom##', '<pre>'.get_option('2mb_autocode_bottomstring').'</pre>', $content, $count8);
    }
    $count9 = 0; //Check if they had an override to the home pages (for the top content).
    $content = str_replace('##do_top_home##', '', $content, $count9);
    $count10 = 0; //Same, but for bottom.
    $content  = str_replace('##do_bottom_home##', '', $content, $count10);
    $top = 1;
    $bottom = 1;
    if($count > 0) { //They told us not to echo the top content anywhere.
        $top = 0;
    }
    if(($count3 > 0 || get_option('2mb_autocode_tophome') == 0) && !is_single()) { //Top content shouldn't be shown on the home page.
        $top = 0;
    }
    if($count5 > 0 && is_single()){ //It shouldn't be shown on the single pages.
        $top = 0;
    }
    if($count2 > 0) { //See count1, but for bottom.
        $bottom = 0;
    }
    if(($count4 > 0 || get_option('2mb_autocode_tophome') == 0) && !is_single()) { //Same, but see count2.
        $bottom = 0;
    }
    if($count6 > 0 && is_single()) { //Ditto, see count 5.
        $bottom = 0;
    }
    if($count9 > 0 && !is_single()) { //They told us to put it on the home page.
        $top = 1;
    }
    if($count10  > 0 && !is_single()) { //Same, but for bottom.
        $bottom = 1;
    }
    global $post;
    $tophome_force = get_post_meta($post->ID, '2mb_autocode_tophome_force', true);
    $bottomhome_force = get_post_meta($post->ID, '2mb_autocode_bottomhome_force', true);
    $top_force = get_post_meta($post->ID, '2mb_autocode_top_force', true);
    $bottom_force = get_post_meta($post->ID, '2mb_autocode_bottom_force', true);
    if($tophome_force == '') {
        $tophome_force = 0;
    }
    if($bottomhome_force == '') {
        $bottomhome_force = 0;
    }
    if($top_force == '') {
        $top_force = 0;
    }
    if($bottom_force == '') {
        $bottom_force = 0;
    }
    if($tophome_force == 1 && !is_single()) { //The meta box in the post editor said to put it on the home page.
        $top = 1;
    }
    else if($tophome_force == 2 && !is_single()) { //They told us not to.
        $top = 0;
    }
    if($bottomhome_force == 1 && !is_single()) { //They told us to put the bottom content on the homepage.
        $bottom = 1;
    }
    else if($bottomhome_force == 2 && !is_single()) { //They told us not to.
        $bottom = 0;
    }
    if($top_force == 1 && is_single()) { //Force it on on the post page.
        $top = 1;
    }
    else if($top_force == 2 && is_single()) { //Force it off.
        $top = 0;
    }
    if($bottom_force == 1 && is_single()) { //Force the bottom text on on the post page.
        $bottom = 1;
    }
    if($bottom_force == 2 && is_single()) { //Force it off.
        $bottom = 0;
    }
    if($count7 > 0) { //We already echoed the top content.
        $top = 0;
    }
    if($count8 > 0) { //Yep, we echoed the bottom.
        $bottom = 0;
    }
    if($top == 1) { //Finally, we need to display the content!
        if(get_option('2mb_autocode_toptype') == 1) { //php
            ob_start();
            eval(get_option('2mb_autocode_topstring'));
            $string = ob_get_contents();
            ob_end_clean();
            $content = do_shortcode($string).$content;
        }
        else if(get_option('2mb_autocode_toptype') == 2) { //Pre-formatted text.
            $content = '<pre>'.get_option('2mb_autocode_topstring').'</pre>'.$content;
        }
        else { //html.
            $content = do_shortcode(get_option('2mb_autocode_topstring')).$content;
        }
    }
    if($bottom == 1) { //We need to echo the bottom content.
        if(get_option('2mb_autocode_bottomtype') == 1) { //php
            ob_start();
            eval(get_option('2mb_autocode_bottomstring'));
            $string = ob_get_contents();
            ob_end_clean();
            $content = $content.do_shortcode($string);
        }
        else if(get_option('2mb_autocode_bottomtype') == 2) { //pre-formatted text.
            $content = $content.'<pre>'.get_option('2mb_autocode_bottomstring').'</pre>';
        }
        else { //html
            $content = $content.do_shortcode(get_option('2mb_autocode_bottomstring'));
        }
    }
    return $content;
}

add_action('the_content', 'twomb_autocode_do_php', 0); //Parse php in the post with [php] ... [/php] tags.
function twomb_autocode_do_php($content) {
    $content = preg_replace_callback('/\[php\]((.|\n)+)\[\/php\]/', 'twomb_autocode_exec_php', $content); //I know, weird regex.
    return $content;
}

function twomb_autocode_exec_php($matches) {
    ob_start();
    eval($matches[1]);
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

add_action('admin_menu', 'twomb_autocode_init_admin_menu'); //Make our sub-menu.
function twomb_autocode_init_admin_menu() {
    add_options_page('Autocode Options', 'Autocode', 'manage_options', 'twomb-autocode-settings', 'twomb_autocode_options');
}

function twomb_autocode_options() {
    if(!current_user_can( 'manage_options')) {
        wp_die( 'You do not have rights to access this page.');
    }
    ?>
    <div class="wrap">
    <h2>Wait just a second.</h2>
    <p>
    Do you like this plugin? Does it make your life just a little bit easier -- we hope! If it does, please consider donating to help our plugin effort along. Any amount helps. We'll love you forever ;-)
    <br>
    <form name="input" target="_blank" action="https://www.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="add" value="1">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="business" value="ai5hf@hotmail.com">
    <input type="hidden" name="item_name" value="Support 2MB Solutions">
    Amount: $<input type="text" maxlength="200" style="width:50px;" name="amount" value="5.00"> USD<br />
    <input type="hidden" name="currency_code" value="USD">
    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_SM.gif" border="0" alt="PayPal - The safer, easier way to pay online!">
    </form>
    <br>
    Also please consider visiting our website to stay up to date on 2MB Solutions news, plugins, offers, and more. <a href="https://2mb.solutions/">Click here to visit</a>.
    </p>
<form method="post" action="options.php">
    <?php
    settings_fields('twomb-autocode-settings');
    do_settings_sections('twomb-autocode-settings');
    submit_button();
    ?>
    </form>
    <h2>Documentation</h2>
    <p>
    This plugin is rather simple, but to make it as easy as possible to use this plugin, we will include some documentation here:
    <br>
    <ul>
    <li>To stop the text from displaying at the top or bottom of a post and the homepage, enter ##no_top## for the top text or ##no_bottom## for the bottom text anywhere in the post. Alternatively, simply select the appropriate option on the post edit page itself.</li>
    <li>To stop the text from displaying selectively on the homepage *or* the post page, enter ##no_top_home## or ##no_bottom_home## for the homepage, or ##no_top_post## or ##no_bottom_post## for the post page. Once again, these options can be set in the post editor.</li>
    <li>To enable the top and/or bottom text when it is normally not enabled on the homepage, add ##do_top_home## or ##do_bottom_home## to anywhere on the post. And again, post editor... you get it.</li>
    <li>To include php code to run in a page, enter [php]CODE HERE[/php] anywhere in the post. Note: You should not include the beginning opening or end closing php tag, but you may exit php and re-enter by using a closing then opening tag.</li>
<li>To place the top or bottom text at a different point than at the top or bottom, enter ##do_bottom## or ##do_top## where you want them in the post editor.</li>
    </ul>
    <br>
    Remember, feedback is most welcome! <a href="https://2mb.solutions/">Visit our homepage to suggest a feature, a new plugin, and more</a>.
    </p>
    </div>
    <?php
}

add_action('admin_init', 'twomb_autocode_init_settings'); //Init settings pages.
function twomb_autocode_init_settings() {
    add_settings_section('twomb-autocode-settings', 'Autocode Options', 'twomb_autocode_print_section', 'twomb-autocode-settings');
    register_setting('twomb-autocode-settings', '2mb_autocode_topstring', 'twomb_autocode_topstring_sanitize');
    register_setting('twomb-autocode-settings', '2mb_autocode_toptype', 'twomb_autocode_toptype_sanitize');
    register_setting('twomb-autocode-settings', '2mb_autocode_bottomstring', 'twomb_autocode_bottomstring_sanitize');
    register_setting('twomb-autocode-settings', '2mb_autocode_bottomtype', 'twomb_autocode_bottomtype_sanitize');
    register_setting('twomb-autocode-settings', '2mb_autocode_tophome', 'twomb_autocode_tophome_sanitize');
    register_setting('twomb-autocode-settings', '2mb_autocode_bottomhome', 'twomb_autocode_bottomhome_sanitize');
    add_settings_field('2mb-autocode-topstring', 'Text to place at the top of posts/pages', 'twomb_autocode_topstring_print', 'twomb-autocode-settings', 'twomb-autocode-settings');
    add_settings_field('2mb-autocode-toptype', 'What type of text is this?', 'twomb_autocode_toptype_print', 'twomb-autocode-settings', 'twomb-autocode-settings');
    add_settings_field('2mb-autocode-tophome', 'Should this be displayed at the top of each post on the homepage?', 'twomb_autocode_tophome_print', 'twomb-autocode-settings', 'twomb-autocode-settings');
    add_settings_field('2mb-autocode-bottomstring', 'Text to place at the bottom of posts/pages', 'twomb_autocode_bottomstring_print', 'twomb-autocode-settings', 'twomb-autocode-settings');
    add_settings_field('2mb-autocode-bottomtype', 'What type of text is this?', 'twomb_autocode_bottomtype_print', 'twomb-autocode-settings', 'twomb-autocode-settings');
    add_settings_field('2mb-autocode-bottomhome', 'Should this text be displayed at the bottom of each post on the homepage?', 'twomb_autocode_bottomhome_print', 'twomb-autocode-settings', 'twomb-autocode-settings');
}


function twomb_autocode_topstring_sanitize($data) {
    return wp_kses_post($data);
}

function twomb_autocode_toptype_sanitize($data) {
    if((int)$data < 0 || (int)$data > 2) {
        return 0;
    }
    else {
        return (int)$data;
    }
}

function twomb_autocode_tophome_sanitize($data) {
    if($data == NULL) {
        return 0;
    }
    else {
        if($data == 'true') {
            return 1;
        }
        else {
            return 0;
        }
    }
}

function twomb_autocode_bottomtype_sanitize($data) {
    if((int)$data < 0 || (int)$data > 2) {
        return 0;
    }
    else {
        return (int)$data;
    }
}

function twomb_autocode_bottomstring_sanitize($data) {
    return wp_kses_post($data);
}

function twomb_autocode_bottomhome_sanitize($data) {
    if($data == NULL) {
        return 0;
    }
    else {
        if($data == 'true') {
            return 1;
        }
        else {
            return 0;
        }
    }
}

function twomb_autocode_topstring_print() {
    ?>
    <textarea id="2mb_autocode_topstring" name="2mb_autocode_topstring"><?php echo(get_option('2mb_autocode_topstring'));?></textarea>
    <?php
}

function twomb_autocode_toptype_print() {
    ?>
    <input type="radio" name="2mb_autocode_toptype" id="2mb_autocode_toptype" value="0" <?php echo((get_option('2mb_autocode_toptype') == 0)?'checked="checked"':'');?>> Html
    <input type="radio" name="2mb_autocode_toptype" id="2mb_autocode_toptype" value="1" <?php echo((get_option('2mb_autocode_toptype') == 1)?'checked="checked"':'');?>> php
    <input type="radio" name="2mb_autocode_toptype" id="2mb_autocode_toptype" value="2" <?php echo((get_option('2mb_autocode_toptype') == 2)?'checked="checked"':'');?>> Preformatted text
    <br>
    Note: When using php, you must echo any required output, and not include any php tags. Also, when using preformatted text, shortcodes will not work.
    <?php
}

function twomb_autocode_tophome_print() {
    ?>
    <input type="checkbox" name="2mb_autocode_tophome" id="2mb_autocode_tophome" value="true" <?php echo((get_option('2mb_autocode_tophome') == 1)?'checked="checked"':'');?>> Yes
    <?php
}

function twomb_autocode_bottomstring_print() {
    ?>
    <textarea id="2mb_autocode_bottomstring" name="2mb_autocode_bottomstring"><?php echo(get_option('2mb_autocode_bottomstring'));?></textarea>
    <?php
}

function twomb_autocode_bottomtype_print() {
    ?>
    <input type="radio" name="2mb_autocode_bottomtype" id="2mb_autocode_bottomtype" value="0" <?php echo((get_option('2mb_autocode_bottomtype') == 0)?'checked="checked"':'');?>> Html
    <input type="radio" name="2mb_autocode_bottomtype" id="2mb_autocode_bottomtype" value="1" <?php echo((get_option('2mb_autocode_bottomtype') == 1)?'checked="checked"':'');?>> php
    <input type="radio" name="2mb_autocode_bottomtype" id="2mb_autocode_bottomtype" value="2" <?php echo((get_option('2mb_autocode_bottomtype') == 2)?'checked="checked"':'');?>> Preformatted text
    <br>
    Note: When using php, you must echo any required output, and not include any php tags. Also, when using preformatted text, shortcodes will not work.
    <?php
}

function twomb_autocode_bottomhome_print() {
    ?>
    <input type="checkbox" name="2mb_autocode_bottomhome" id="2mb_autocode_bottomhome" value="true" <?php echo((get_option('2mb_autocode_bottomhome') == 1)?'checked="checked"':'');?>> Yes
    <?php
}

register_activation_hook(__FILE__, 'twomb_autocode_activate'); //Activate and add options.
function twomb_autocode_activate() {
    add_option('2mb_autocode_bottomstring', '');
    add_option('2mb_autocode_topstring', '');
    add_option('2mb_autocode_toptype', 0);
    add_option('2mb_autocode_bottomtype', 0);
    add_option('2mb_autocode_tophome', 0);
    add_option('2mb_autocode_bottomhome', 0);
}

function twomb_autocode_print_section() {
    ?>
    <p>
    Enter your settings below, then click save to save your changes.
    </p>
    <?php
}

add_action('add_meta_boxes', 'twomb_autocode_add_meta_box'); //For the post editor.
function twomb_autocode_add_meta_box() {
    add_meta_box('2mb_autocode_options', 'Autocode Options', 'twomb_autocode_post_options', 'post');
}

function twomb_autocode_post_options ($post) {
    wp_nonce_field( 'twomb_autocode_save_meta_box_data', 'twomb_autocode_meta_box_nonce' );
    $value = get_post_meta($post->ID, '2mb_autocode_tophome_force', true);
    if($value == '') {
        $value = 0;
    }
    ?>
<p>
Should the top text be prepended to that on the home page? Note: The first option means that it will not be set specifically on this post, it will simply follow what is set in the options page. The other options will change the option only for this post.
<br>
<input type="radio" name="2mb_autocode_tophome_force" value="0"<?php echo(($value == 0)?' checked="checked">':'>'); ?> Do what is set in the autocode settings.
<br>
<input type="radio" name="2mb_autocode_tophome_force" value="1"<?php echo(($value == 1)?' checked="checked">':'>'); ?> Force the top text to appear on this post for the home page.
<br>
<input type="radio" name="2mb_autocode_tophome_force" value="2"<?php echo(($value == 2)?' checked="checked">':'>'); ?> Force the top text to not show on the home page for this post.
</p>
<?php
    $value = get_post_meta($post->ID, '2mb_autocode_bottomhome_force', true);
    if($value == '') {
        $value = 0;
    }
    ?>
<p>
Should the bottom text be appended to that on the home page? Note: The first option means that it will not be set specifically on this post, it will simply follow what is set in the options page. The other options will change the option only for this post.
<br>
<input type="radio" name="2mb_autocode_bottomhome_force" value="0"<?php echo(($value == 0)?' checked="checked">':'>'); ?> Do what is set in the autocode settings.
<br>
<input type="radio" name="2mb_autocode_bottomhome_force" value="1"<?php echo(($value == 1)?' checked="checked">':'>'); ?> Force the bottom text to appear on this post for the home page.
<br>
<input type="radio" name="2mb_autocode_bottomhome_force" value="2"<?php echo(($value == 2)?' checked="checked">':'>'); ?> Force the bottom text to not show on the home page for this post.
</p>
<?php
    $value = get_post_meta($post->ID, '2mb_autocode_top_force', true);
    if($value == '') {
        $value = 0;
    }
    ?>
<p>
Should the top text be prepended to this post? Note: The first option means that it will not be set specifically on this post, it will simply follow what is set in the options page. The other options will change the option only for this post.
<br>
<input type="radio" name="2mb_autocode_top_force" value="0"<?php echo(($value == 0)?' checked="checked">':'>'); ?> Do what is set in the autocode settings.
<br>
<input type="radio" name="2mb_autocode_top_force" value="1"<?php echo(($value == 1)?' checked="checked">':'>'); ?> Force the top text to appear on this post.
<br>
<input type="radio" name="2mb_autocode_top_force" value="2"<?php echo(($value == 2)?' checked="checked">':'>'); ?> Force the top text to not show on this post.
</p>
<?php
    $value = get_post_meta($post->ID, '2mb_autocode_bottom_force', true);
    if($value == '') {
        $value = 0;
    }
    ?>
<p>
Should the bottom text be appended to this post? Note: The first option means that it will not be set specifically on this post, it will simply follow what is set in the options page. The other options will change the option only for this post.
<br>
<input type="radio" name="2mb_autocode_bottom_force" value="0"<?php echo(($value == 0)?' checked="checked">':'>'); ?> Do what is set in the autocode settings.
<br>
<input type="radio" name="2mb_autocode_bottom_force" value="1"<?php echo(($value == 1)?' checked="checked">':'>'); ?> Force the bottom text to appear on this post.
<br>
<input type="radio" name="2mb_autocode_bottom_force" value="2"<?php echo(($value == 2)?' checked="checked">':'>'); ?> Force the bottom text to not show on this post.
</p>
<?php
}

add_action( 'save_post', 'twomb_autocode_save_meta_box_data' ); //Save the changed settings.
function twomb_autocode_save_meta_box_data( $post_id ) {
    if ( !isset( $_POST['twomb_autocode_meta_box_nonce'] ) ) {
        return;
    }
    if ( !wp_verify_nonce( $_POST['twomb_autocode_meta_box_nonce'], 'twomb_autocode_save_meta_box_data' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
        if ( !current_user_can( 'edit_page', $post_id ) ) {
            return;
        }
    }
    else {
        if ( !current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }
    if(!isset($_POST['2mb_autocode_tophome_force']) || !isset($_POST['2mb_autocode_bottomhome_force']) || !isset($_POST['2mb_autocode_top_force']) || !isset($_POST['2mb_autocode_bottom_force'])) {
        return;
    }
    $tophome = (int)$_POST['2mb_autocode_tophome_force'];
    $bottomhome = (int)$_POST['2mb_autocode_bottomhome_force'];
    $top = (int)$_POST['2mb_autocode_top_force'];
    $bottom = (int)$_POST['2mb_autocode_bottom_force'];
    if($tophome < 0 || $tophome > 2) {
        $tophome = 0;
    }
    if($bottomhome < 0 || $bottomhome > 2) {
        $bottomhome = 0;
    }
    if($top < 0 || $top > 2) {
        $top = 0;
    }
    if($bottom < 0 || $bottom > 2) {
        $bottom = 0;
    }
    update_post_meta($post_id, '2mb_autocode_tophome_force', $tophome);
    update_post_meta($post_id, '2mb_autocode_bottomhome_force', $bottomhome);
    update_post_meta($post_id, '2mb_autocode_top_force', $top);
    update_post_meta($post_id, '2mb_autocode_bottom_force', $bottom);
}
?>
