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
		$PicPath="Uploads/UserPic/".$Profile['pic_save_path'];
		$this->assign('PicPath', $PicPath); //用户头像信息前端赋值
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
	public function update_pic($id){
		$upload = new \Think\Upload();// 实例化上传类
    	$upload->maxSize   =     3145728 ;// 设置附件上传大小
    	$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
    	$upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
    	$upload->savePath  =     './UserPic/'; // 设置附件上传（子）目录
    	$upload->saveName = array('uniqid','');
    	$upload->autoSub  = false;
    	// 上传文件 
    	$info   =   $upload->uploadOne($_FILES['picture']);
    	if(!$info) {// 上传错误提示错误信息
    	    $this->error($upload->getError());
    	}else{// 上传成功
    		$PicPath['pic_save_path']=$info['savename'];
    	    var_dump($PicPath);
    	    $UserModel=M('User');
    	    $Condition['id']=$id;
    	    $Result=$UserModel->where($Condition)->save($PicPath);
    	    if($Result){
    	    	$this->success('头像上传成功',__ROOT__.'/index.php/Home/Profile/profile');
    	    }else{
    	    	$this->error('头像上传失败');
    	    }
    	}
	}
}