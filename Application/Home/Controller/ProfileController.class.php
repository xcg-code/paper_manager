<?php
namespace Home\Controller;
use Think\Controller;
class ProfileController extends Controller {
	public function profile(){
		parent::is_login();
		$UserModel=M('User');
		$uid=session('uid');
		$Condition['id']=$uid;
		$Profile=$UserModel->where($Condition)->find();
		$this->assign('Profile', $Profile); //基本信息前端赋值
		$AreaModel=M('Area');
		$AreaCondition['user_id']=$uid;
		$AreaInfo=$AreaModel->where($AreaCondition)->count();
		$this->display();
	}
	public function edit($id){
		$ProfileModel=D('User');
		if($ProfileModel->validate($EditProfileRules)->create()){
			$Condition['id']=$id;
			$Result=$ProfileModel->where($Condition)->save();
			if($Result>0){
				$this->success('个人信息保存成功',__ROOT__.'/index.php/Home/Profile/profile');
			}
			else if($Result==0){
				$this->error('您没有修改任何信息');
			}
			else{
				$this->error('个人信息保存失败');
			}

    	}
    	else{
    		$this->error($ProfileModel->getError());
    	}
	}
}