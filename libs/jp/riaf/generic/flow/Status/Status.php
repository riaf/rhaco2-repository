<?php
module('model.StatusMessage');

class Status extends Flow
{
    public function models(){
        $paginator = new Paginator(20, $this->inVars('page', 1));
        $this->vars('object_list', C(StatusMessage)->find_page($this->inVars('q'), $paginator, '-id'));
        $this->vars('paginator', $paginator->add(array('q' => $this->inVars('q'))));
        return $this;
    }
    public function model($id){
        $this->vars('object', C(StatusMessage)->find_get(Q::eq('id', $id)));
        return $this;
    }
    public function create(){
        if($this->isPost()){
            try {
                if($this->verify()){
                    $message = new StatusMessage();
                    $message->body($this->inVars('body'));
                    $message->save();
                    C(StatusMessage)->commit();
                    $this->success_redirect();
                }
            } catch (Exception $e){
                Log::error($e->getMessage());
            }
        }
        $this->fail_redirect();
    }
}