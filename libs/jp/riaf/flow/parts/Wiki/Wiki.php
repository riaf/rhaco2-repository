<?php
module('model.WikiPage');
class Wiki extends Flow
{
    /**
     * ページ閲覧
     */
    public function model($name="FrontPage"){
        try {
            $this->vars('page', C(WikiPage)->find_get(Q::eq('name', $name), Q::order('-version')));
        } catch(Exception $e){
            $this->redirect_method('edit', $name);
        }
    }
    /**
     * 検索
     */
    public function search(){
        
    }
    /**
     * ページ編集
     */
    public function edit($name){
        $this->vars('name', $name);
        try {
            $current = C(WikiPage)->find_get(Q::eq('name', $name), Q::order('-version'));
        } catch(Exception $e){}
        if($this->is_post()){
            try {
                $page = new WikiPage();
                $page->cp($this->vars());
                if(isset($current)) $page->version($current->version() + 1);
                $page->save();
                C($page)->commit();
                $this->redirect_method('model', $name);
            } catch(Exception $e){
                $this->vars('page', $page);
                $this->vars('body', $page->body());
            }
        } else if(isset($current)){
            $this->vars('page', $current);
            $this->vars('body', $current->body());
        } else {
            $default = new WikiPage();
            $default->name($name);
            $this->vars('page', $default);
            $this->vars('body', '*'. $name);
        }
    }
    /**
     * Wiki の初期データをインストール
     */
    static public function __setup_install_wiki__(){
        $frontpage = new WikiPage('name=FrontPage,body=Welcome to rhaco wiki');
        $frontpage->save();
        C($frontpage)->commit();
    }
}
