<?php
namespace Home\Controller;
use Think\Controller;
class ProfileController extends Controller {
	public function profile(){
		$UserModel=M('User');
		$uid=session('uid');
		$Condition['id']=$uid;
		$Profile=$UserModel->where($Condition)->find();
		$this->assign('Profile', $Profile); // 赋值数据集
		$this->display();
	}
	public function edit($id){
		$this->error('登录失败，用户名或密码错误');
	}
}