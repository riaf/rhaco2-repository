<?php
import('org.yabeken.service.Pea');
pear('openpear.org/PEG');
pear('openpear.org/HatenaSyntax-beta');

class HatenaFormat
{
    const CACHE_EXPIRE = 86400;
    
    public function format($str){
        if(module_const('is_cache', false)){
            $store_key = array('__hatenaformat_format', $str);
            if(Store::has($store_key)){
                return Store::get($store_key);
            }
        }
        $str = HatenaSyntax::render($str, Text::dict(module_const('option')) + array(
            'headerlevel' => 3,
            'htmlescape' => true,
            'linktitlehandler' => 'HatenaFormat::linktitleHandler',
            'keywordlinkhandler' => 'HatenaFormat::keywordlinkHandler'));
        if(module_const('is_cache', false)) Store::set($store_key, $str, self::CACHE_EXPIRE);
        return $str;
    }
    
    /**
     * keywordlinkHandler
     */
    static public function keywordlinkHandler($keyword){
        return url($keyword);
    }
    /**
     * linktitleHandler
     */
    static public function linktitleHandler($url){
        if(module_const('is_cache', false)){
            $store_key = array('__hatenaformat_linktitlehandler', $url);
            if(Store::has($store_key)){
                return Store::get($store_key);
            }
        }
        if(Tag::setof($title, Http::read($url), 'title')){
            $url = $title->value();
            if(module_const('is_cache', false)) Store::set($store_key, $url, self::CACHE_EXPIRE);
        }
        return $url;
    }
    /**
     * 必要な PEAR パッケージをインストールする
     */
    static public function __setup_install_hatenasyntax__(){
        pear_install('openpear.org/PEG');
        pear_install('openpear.org/HatenaSyntax-beta');
    }
}
