<?php
namespace Home\Controller;
use Think\Controller;
class ExcelController extends Controller {
    public function add_achi(){
        parent::is_login();
        $this->display();
    }
}