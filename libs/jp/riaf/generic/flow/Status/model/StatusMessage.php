<?php
import('org.rhaco.storage.db.Dao');

class StatusMessage extends Dao
{
    protected $_database_ = 'status';
    protected $_table_ = 'message';
    /**
     * id
     */
    protected $id;
    static protected $__id__ = 'type=serial';
    /**
     * body
     */
    protected $body;
    static protected $__body__ = 'type=string,max=140';
    /**
     * created date
     */
    protected $created;
    static protected $__created__ = 'type=timestamp';
    
    /**
     * init
     */
    protected function __init__(){
        $this->created = time();
    }
}
