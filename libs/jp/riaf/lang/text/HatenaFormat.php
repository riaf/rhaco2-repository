<?php
import('org.yabeken.service.Pea');
pear('openpear.org/PEG');
pear('openpear.org/HatenaSyntax-beta');

class HatenaFormat
{
    public function format($str){
        return HatenaSyntax::render($str, Text::dict(module_const('option')));
    }
    /**
     * 必要な PEAR パッケージをインストールする
     */
    static public function __setup_install_hatenasyntax__(){
        pear_install('openpear.org/PEG');
        pear_install('openpear.org/HatenaSyntax-beta');
    }
}
