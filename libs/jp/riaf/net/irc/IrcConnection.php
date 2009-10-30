<?php
class IrcConnection extends Object
{
    public $_socket_;
    
    protected $server;
    protected $port = 6667;
    protected $nick;
    protected $username;
    protected $realname;
    protected $usermod;
    protected $password;
    
    public function connect(){
        if(empty($this->server)){
            throw new IrcException('server address is required');
        }
        // FIXME! for ipv6
        $this->_socket_ = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if($this->_socket_ === false){
            $error_code = socket_last_error();
            throw new IrcException(sprintf('Cannot create socket[%d] %s',
                $error_code, socket_strerror($error_code)));
        }
        if(socket_connect($this->_socket_, $this->server, $this->port) === false){
            $error_code = socket_last_error($this->_socket_);
            throw new IrcException(sprintf('Connect error[%d] %s',
                $error_code, socket_strerror($error_code)));
        }
    }
    
    public function login(){
        if(empty($this->nick)){
            throw new IrcException('nick is required.');
        }
        if($this->password !== null){
            $this->send('PASS', $this->password);
        }
        if(empty($this->realname)){
            $this->realname = $this->nick;
        }
        if(empty($this->username)){
            $this->username = $this->nick;
        }
        if(is_numeric($this->usermod) === false){
            $this->usermod = 0;
        }
        $this->send('NICK', $this->nick);
        $this->send('USER', $this->username, $this->usermod, '*', $this->realname);
    }
    
    public function send($data){
        $data = str_replace(array("\r\n", "\n"), '', implode(' ', func_get_args()));
        Log::debug(sprintf('Irc send: %s', $data));
        if(socket_write($this->_socket_, $data. "\r\n") === false){
            $error_code = socket_last_error($this->_socket_);
            throw new IrcException(sprintf('Send error[%d] %s',
                $error_code, socket_strerror($error_code)));
        }
    }
    
    protected function __end__(){
        $this->send('QUIT');
        @socket_shutdown($this->_socket_);
        @socket_close($this->_socket_);
    }
}
