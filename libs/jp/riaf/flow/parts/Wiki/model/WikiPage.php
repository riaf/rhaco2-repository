<?php
import('org.rhaco.storage.db.Dao');

class WikiPage extends Dao
{
    protected $id;
    protected $name;
    protected $body;
    protected $version;
    protected $created;
    static protected $__id__ = 'type=serial';
    static protected $__name__ = 'require=true,min=2';
    static protected $__body__ = 'type=text,require=true';
    static protected $__version__ = 'type=number';
    static protected $__created__ = 'type=timestamp';
    
    protected function __init__(){
        $this->version = 1;
        $this->created = time();
    }
    protected function __fm_body__(){
        return (C(module_package_class())->has_module('format'))? C(module_package_class())->call_module('format', $this->body) : $this->body;
    }
}
