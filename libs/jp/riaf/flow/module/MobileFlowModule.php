<?php
import('Mobile');

class MobileFlowModule
{
    public function init_flow_handle(Flow $flow) {
        if (Mobile::is_mobile()) {
            $vars = $flow->vars();
            mb_convert_variables('utf-8', 'utf-8,SJIS-win', $vars);
            $flow->vars($vars);
        }
    }
}

