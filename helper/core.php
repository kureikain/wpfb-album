<?php

/*
 * A project from Axcoto.Com
 * by kureikain
 */

class WfalbumHelperCore {

    static public function log($message) {
        if (WP_DEBUG === true) {
            if (is_array($message) || is_object($message)) {
                error_log(print_r($message, true));
            } else {
                error_log($message);
            }
        }
    }

    static public function redirect($title, $message, $page, $url) {
        include AxcotoFontBird::singleton()->pluginPath . '/templates/common/redirect.php';
    }

    static public function e(&$value, $default='') {
        echo self::g($value, $default);
    }

    static public function g(&$value, $default='') {
        if (isset($value)) {
            return $value;
        } else {
            return $default;
        }
    }

    static public function load($file, $create = false) {
        include_once dirname(__FILE__) . '/' . $file . '.php';
        if ($create) {
            $class = 'WfalbumHelper' . ucfirst($file);
            return new $class;
        }
        return null;
    }


}