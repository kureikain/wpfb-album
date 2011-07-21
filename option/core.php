<?php
/*
 * A project from Axcoto.Com
 * by kureikain
 */

class WfalbumOptionCore {

    public static function init() {
        //Setting Option
        $optionName = Wfalbum::singleton()->optionName;
        $defaultOption = array(
            'fp_cache_time' => 5000,
            'fp_app_secret' => '',
            'fp_app_id' => '',
        );
        $option = get_option($optionName, false);
        if (!$option) {
            update_option($optionName, $defaultOption);
        }

        //Use our own setting page
        register_setting($optionName . '_group', $optionName);
        add_settings_section($optionName . '_facebook', 'Facebook App Setting', array('WfalbumOptionCore', 'setting_overview_facebook'), 'wfalbum_facebook');
        add_settings_field('fb_app_id', 'Facebook App ID/Key', array('WfalbumOptionCore', 'setting_control_fb_app_id'), 'wfalbum_facebook', $optionName . '_facebook');
        add_settings_field('fp_app_secret', 'Facebook App Secret', array('WfalbumOptionCore', 'setting_control_fb_app_secret'), 'wfalbum_facebook', $optionName . '_facebook');
        add_settings_field('fp_cache_time', 'Cache Time', array('WfalbumOptionCore', 'setting_control_fp_cache_time'), 'wfalbum_facebook', $optionName . '_facebook');
        
    }

    /**
     * Over view of setting form
     * Thus function can be called by magic method __callStatic when missing overview of a group
     * @see __callStatic
     */
    public static function setting_overview($group='') {
        static $sections = array(
    'facebook' => 'Fill in the information of your facebook application.',
        );
        echo $sections[$group];
    }

    /**
     * control of setting form
     * Thus function can be called by magic method __callStatic when missing function to define form control
     * @see __callStatic
     */
    public static function setting_control($field='') {
        $optionName = Wfalbum::singleton()->optionName;
        $optionValue = get_option($optionName);
        ?>
        <input id="<?php echo $field ?>" name="<?php echo $optionName ?>[<?php echo $field ?>]" class="regular-text" value="<?php echo $optionValue[$field]; ?>" />
        <?php
    }

    /**
     * Render setting form
     */
    public static function setting_form() {
        $optionName = Wfalbum::singleton()->optionName;
        ?>
        <div class="wrap">
            <?php screen_icon("options-general"); ?>
            <h2><?php echo __('WP FB Album Settings') ?></h2>
            <form action="options.php" method="post">

                <?php settings_fields($optionName . '_group'); ?>
                <?php do_settings_sections('wfalbum_facebook'); ?>

                <p class="submit">
                    <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
                </p>
            </form>
        </div>
        <?php
    }

    public static function __callStatic($name, $args) {
        if (substr($name, 0, 16) == 'setting_control_') {
            echo call_user_func(array('WfalbumOptionCore', 'setting_control'), substr($name, 16));
        } elseif (substr($name, 0, 17) == 'setting_overview_') {
            echo call_user_func(array('WfalbumOptionCore', 'setting_overview'), substr($name, 17));
        }
        return '';
    }

}
?>
