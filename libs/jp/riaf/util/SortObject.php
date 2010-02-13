<?php
/**
 * オブジェクトの簡易ソート
 *
 * @author  Keisuke SATO
 * @license New BSD License
 **/
class SortObject extends Object
{
    protected $objects = array();
    protected $method;
    protected $order;
    protected $asort = false;
    static protected $__objects__ = 'type=Object[]';
    static protected $__method__ = 'type=string';
    static protected $__order__ = 'type=choice(asc,desc)';
    static protected $__asort__ = 'type=boolean';
    
    /**
     * Object の配列をソートする
     */
    static public function sort(Array $objects, $method, $order='asc'){
        $sort = new self($objects);
        $sort->method($method);
        $sort->order($order);
        return $sort->objects();
        /***
            #sort
            uc($sobj, '
                protected $name;
                protected $value;
            ');
            $sobja = new $sobj('name=aaa,value=1');
            $sobjb = new $sobj('name=bbb,value=2');
            $sobjc = new $sobj('name=ccc,value=3');
            
            $objects = SortObject::sort(array($sobjb, $sobja, $sobjc), 'value');
            eq('aaa', $objects[0]->name());
            $objects = SortObject::sort(array($sobjb, $sobja, $sobjc), 'value', 'desc');
            eq('ccc', $objects[0]->name());
        */
    }
    /**
     * インデックスを保持したままソートする
     */
    static public function asort(Array $objects, $method, $order='asc'){
        $sort = new self($objects);
        $sort->method($method);
        $sort->order($order);
        $sort->asort(true);
        return $sort->objects();
    }
    protected function __new__($objects=array()){
        $this->objects = $objects;
    }
    protected function __get_objects__(){
        if($this->is_asort()){
            uasort($this->objects, array($this, 'cmp'));
        } else {
            usort($this->objects, array($this, 'cmp'));
        }
        return $this->objects;
    }
    /**
     * usort 比較関数
     */
    public function cmp(Object $a, Object $b){
        if($a->{$this->method}() === $b->{$this->method}()){
            return 0;
        }
        switch($this->order){
            case 'desc':
                return $this->cmp_object($b, $a);
            case 'asc':
            default:
                return $this->cmp_object($a, $b);
        }
        return 0;
    }
    private function cmp_object(Object $a, Object $b){
        return ($a->{$this->method}() < $b->{$this->method}()) ? -1 : 1;
    }
}
