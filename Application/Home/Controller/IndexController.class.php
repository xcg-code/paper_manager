<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index($type="login"){
    	$this->assign('type',$type);
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
    			$this->error($UserInfo->getError(),__ROOT__.'/index.php/Home/index.html?type=register');
    		}
    	}else{
    		$this->error($UserInfo->getError(),__ROOT__.'/index.php/Home/index.html?type=register');
    	}
    }
    public function login(){
    	$login=D('User');
    	$uname=I('Post.username');
        $pwd=md5(I('Post.password')); 
        $condition=array(
			'username'=>$uname,
			'password'=>$pwd
		);
		$data=$login->where($condition)->find();
		if($data){
            $PicPath="Uploads/UserPic/".$data['pic_save_path'];
            session('uid',$data[id],3600);
            session('pic_path',$PicPath,3600);
            session('fullname',$data[fullname],3600);
			$this->success('登录成功',__ROOT__.'/index.php/Home/Profile/profile');
		}else{
			$this->error('登录失败，用户名或密码错误');
		}
    }
    public function logout(){
        session(null); 
        $this->success('登出成功，请重新登录！',__ROOT__);
    }
}