<?php
import('Mobile');

class MobileTemplateModule
{
    public function after_exec_template(&$src, Template $template) {
        if (strpos($src, 'm:agent') !== false) {
            $this->m_agent($src, $template);
        }
    }
    private function m_agent(&$src, Template $template) {
        while (Tag::setof($tag, $src, 'm:agent')) {
            $agent = $tag->in_param('param');
            if (
                ($agent == 'docomo' && Mobile::is_docomo())
                || ($agent == 'au' && Mobile::is_au())
                || ($agent == 'softbank' && Mobile::is_softbank())
            ) {
                $src = str_replace($tag->plain(), $tag->value(), $src);
            } else {
                $src = str_replace($tag->plain(), '', $src);
            }
        }
        $src = $template->parse_vars($src);
    }
}

