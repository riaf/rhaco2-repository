<?php
/**
 * IRC Client
 * IrcClient を継承して， __anymethod__ メソッドを実装する用
 *
 * @author  Keisuke Sato <riaf@nequal.jp>
 * @license New BSD License
 */

import('jp.riaf.net.irc.IrcClientConnection');
import('jp.riaf.net.irc.IrcException');

class IrcClient extends Object
{
    protected $connection;
    protected $channels = array();
    protected $send_stack = array();
    
    protected function __new__($dict){
        $connection = new IrcClientConnection($dict);
        $connection->connect();
        $connection->login();
        $this->connection = $connection;
        $this->__connected__();
    }
    
    public function listen(){
        while(true){
            if(!empty($this->send_stack)){
                foreach($this->send_stack as $k => $data){
                    try {
                        $this->connection->send($data);
                        unset($this->send_stack[$k]);
                    } catch(Exception $e){
                        // Exceptions::add($e);
                    }
                }
            }
            $results = $this->connection->receive();
            if(is_array($results)) foreach($results as $result){
printf("received: %s\n", $result);
                if($result{0} == ':'){
                    if(preg_match('/^:(.*?)\!.*? (PRIVMSG|NOTICE) (#.*?) :(.+)/i', $result, $match)){
                        switch(strtoupper($match[2])){
                            case 'PRIVMSG':
                                $this->__privmsg__($match[1], $match[3], $match[4]);
                                break;
                            case 'NOTICE':
                                $this->__notice__($match[1], $match[3], $match[4]);
                                break;
                        }
                        continue;
                    }
                } else if(preg_match('/^PING :(.+?)/', $result, $match)){
                    $this->__ping__($match[1]);
                    continue;
                }
            }
        }
    }
    protected function privmsg($destination, $msg){
        $this->send_stack[] = sprintf('PRIVMSG %s :%s', $destination, $msg);
    }
    protected function notice($destination, $msg){
        $this->send_stack[] = sprintf('NOTICE %s :%s', $destination, $msg);
    }
    protected function join($channels){
        if(is_array($channels)) $channels = implode(',', $channels);
        $this->connection->send('JOIN', $channels);
    }
    
    protected function __connected__(){
    }
    protected function __disconnected__(){
        // auto reconnect
    }
    protected function __privmsg__($nick, $destination, $msg){
    }
    protected function __notice__($nick, $destination, $msg){
    }
    protected function __ping__($msg){
        $this->connection->send('PONG', ':'. $msg);
    }
}
