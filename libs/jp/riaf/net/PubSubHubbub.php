<?php
/**
 * PubSubHubbub
 * publisher
 *
 * @author  Keisuke Sato <riaf@nequal.jp>
 * @license New BSD License
 */

class PubSubHubbub
{
    protected $hubs = array();
    protected $urls = array();
    protected $vars = array();
    static protected $__hubs__ = 'type=string[]';
    static protected $__urls__ = 'type=string[]';
    static protected $__vars__ = 'type=string{}';
    
    /**
     * ハブサーバーに通知する
     */
    public function publish(){
        if(empty($this->hubs) || empty($this->urls)) return;
        $params = $this->params();
        $http = new Http();
        foreach($this->hubs() as $hub){
            $http->raw(implode('&', $params));
            $http->do_post($hub);
            if($http->status() != 204){
                throw new Exception(sprintf('[%d] %s', $http->status(), $http->body()));
            }
        }
    }
    private function params(){
        $params = array('hub.mode=publish');
        foreach($this->urls() as $url){
            $params[] = 'hub.url='. urlencode($url);
        }
        foreach($this->vars() as $k => $v){
            $params[] = sprintf('%s=%s', urlencode($k), urlencode($v));
        }
        return $params;
    }
}
