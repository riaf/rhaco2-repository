<?php
class ModelProperty extends Object
{
    protected $name;
    protected $annotation;
    static protected $__annotation__ = 'type=string{}';

    protected function __fm_annotation__() {
        $ret = array();
        foreach ($this->annotation as $k => $v) {
            $ret[] = sprintf('%s=%s', $k, $v);
        }
        return implode(',', $ret);
    }

    protected function __str__() {
        return $this->name;
    }
}

