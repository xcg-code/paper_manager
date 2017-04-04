<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->display();
    }
    public function register(){
    	$UserInfo=D('User');
    	if($UserInfo->create()){
    		$password=$UserInfo->password;
    		$UserInfo->password=md5($password);
    		$result=$UserInfo->add();

    		if($result){
    			$this->success('注册成功，返回登录页面',__ROOT__.'/index.php/Home/');
    		}else{
    			$this->error($UserInfo->getError());
    		}
    	}else{
    		$this->error($UserInfo->getError());
    	}
    }
}