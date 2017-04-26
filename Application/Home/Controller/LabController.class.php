<?php
namespace Home\Controller;
use Think\Controller;
class LabController extends Controller {
    public function lab_apply(){
    	parent::is_login();
        $this->display();
    }
}