<?php
import('org.yabeken.service.Pea');
pear('openpear.org/PEG');
pear('openpear.org/HatenaSyntax-beta');

class HatenaFormat
{
    public function format($str){
        return HatenaSyntax::render($str, Text::dict(module_const('option')));
    }
}
