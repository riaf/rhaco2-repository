<?php
import('jp.riaf.net.agent.Mobile');

class MobileTemplateModule
{
    public function after_exec_template(&$src, Template $template) {
        if (strpos($src, 'm:agent') !== false) {
            $this->m_agent($src, $template);
        }
        if (strpos($src, 'm:mobile') !== false) {
            $this->m_mobile($src, $template);
        }
        if (strpos($src, 'm:not_mobile') !== false) {
            $this->m_not_mobile($src, $template);
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
    private function m_mobile(&$src, Template $template) {
        while (Tag::setof($tag, $src, 'm:mobile')) {
            if (Mobile::is_mobile()) {
                $src = str_replace($tag->plain(), $tag->value(), $src);
            } else {
                $src = str_replace($tag->plain(), '', $src);
            }
        }
        $src = $template->parse_vars($src);
    }
    private function m_not_mobile(&$src, Template $template) {
        while (Tag::setof($tag, $src, 'm:not_mobile')) {
            if (!Mobile::is_mobile()) {
                $src = str_replace($tag->plain(), $tag->value(), $src);
            } else {
                $src = str_replace($tag->plain(), '', $src);
            }
        }
        $src = $template->parse_vars($src);
    }
}

