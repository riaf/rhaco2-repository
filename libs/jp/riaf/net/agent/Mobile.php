<?php
/**
 * 携帯
 *
 * @author  Keisuke Sato <riaf@nequal.jp>
 * @license New BSD License
 **/
class Mobile extends Object
{
    static protected $carrier;

    static public function __import__() {
        $agent = isset($_SERVER['HTTP_USER_AGENT'])? $_SERVER['HTTP_USER_AGENT']: null;
        if (strpos($agent, 'DoCoMo') !== false) {
            self::$carrier = 'docomo';
        } else if (strpos($agent, 'SoftBank') !== false || strpos($agent, 'Vodafone')) {
            self::$carrier = 'softbank';
        } else if (strpos($agent, 'KDDI') !== false) {
            self::$carrier = 'au';
        } else {
            self::$carrier = null;
        }
        if (self::is_mobile()) {
            ini_set('session.use_cookies', 'off');
            ini_set('session.use_only_cookies', 0);
            ini_set('session.use_trans_sid', '1');
        }
    }
    static public function carrier() {
        return self::$carrier;
    }
    static public function is_docomo() {
        return self::$carrier === 'docomo';
    }
    static public function is_au() {
        return self::$carrier === 'au';
    }
    static public function is_softbank() {
        return self::$carrier === 'softbank';
    }
    static public function is_mobile() {
        return self::is_docomo() || self::is_au() || self::is_softbank();
    }
}

