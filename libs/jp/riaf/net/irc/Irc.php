<?php
// import('jp.riaf.net.irc.IrcConnection');
// import('jp.riaf.net.irc.IrcException');

class Irc extends Object
{
    static public function connect($dict=null){
        $connection = new IrcConnection($dict);
        $connection->connect();
        $connection->login();
        return $connection;
    }
}
