<?php
/**
 * htmlencode を自動で挿入するよ
 * 
 * @author Keisuke Sato
 * @license New BSD License
 */
class HtmlAutoEscape
{
    /**
     * Templateのモジュール
     * @param string $src
     * @param Template $template
     */
    public function after_template(&$src, Template $template){
        preg_match_all('/{(\\$[\$\w][^\t]*?)}/', $src, $matches);
        $hist = array();
        foreach($matches[0] as $k => $match){
            if(in_array($match, $hist)
                || stripos($match, '{$_t_.html') === 0
                || stripos($match, '{$_t_.text') === 0
                || stripos($match, '{$t.html') === 0
                || stripos($match, '{$t.text') === 0
                || stripos($match, '{$t.noop') === 0) continue;
            $src = str_replace($match, sprintf('{$t.htmlencode(%s)}', $matches[1][$k]), $src);
            $hist[] = $match;
        }
    }
}
