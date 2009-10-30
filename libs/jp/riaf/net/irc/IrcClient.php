<?php
// import('jp.riaf.net.irc.IrcClientConnection');
// import('jp.riaf.net.irc.IrcException');

class IrcClient extends Object
{
    protected $connection;
    protected $channels = array();
    protected $send_stack = array();
    
    public function __new__($dict){
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
                    $this->connection->send($data);
                    unset($this->send_stack[$k]);
                }
            }
            $results = $this->connection->receive();
            if(is_array($results)) foreach($results as $result){
                // switch して，各アクションを呼ぶ
            }
        }
    }
    protected function privmsg(){
        
    }
    protected function notice($channel, $msg){
        
    }
    protected function join($channel){
        
    }
    
    protected function __connected__(){
    }
    protected function __disconnected__(){
        // auto reconnect
    }
    protected function __privmsg__(){
    }
    protected function __notice__(){
        
    }
    protected function __ping__(){
        // pong
    }
}
