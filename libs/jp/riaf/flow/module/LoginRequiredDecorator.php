<?php
/**
 * LoginRequiredDecorator
 * written @login_required in phpdoc when call Flow::login_required
 *
 * @author  Keisuke SATO <riaf@nequal.jp>
 * @license New BSD License
 **/

class LoginRequiredDecorator
{
    public function init_flow_handle(Flow $flow) {
        $map = $flow->handled_map();
        $ref = new ReflectionMethod($map['class'], $map['method']);
        $doc = $ref->getDocComment();
        if (stripos($doc, '@login_required') !== false) {
            $flow->a('user', 'require', true, true);
        }
    }
}
