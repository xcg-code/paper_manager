<?php
namespace Home\Controller;
use Think\Controller;
class ProfileController extends Controller {
	public function profile(){
		parent::is_login();
		//获取用户基本信息
		$UserModel=M('User');
		$uid=session('userNum');
		$Condition['user_number']=$uid;
		$Profile=$UserModel->where($Condition)->find();
		//获取科研成果分布百分比情况
		$AchiPercent=get_achi_percent($uid);
		//获取科研成果总数
		$AchiNum=get_achievement_count('',$uid);
		//获取科研项目总数
		$ProjectModel=M('ProjectMember');
		$ConditionPro['user_number']=$uid;
		$ConditionPro['p_status']=1;
		$ProjectNum=$ProjectModel->where($ConditionPro)->count();
		//获取不同类别科研成果数
		$AchievementCount=get_achievement_count('',$uid);
		$this->assign('Profile', $Profile); //基本信息前端赋值
		$this->assign('AchiPercent', $AchiPercent); 
		$this->assign('AchiNum', $AchiNum['All']);
		$this->assign('AchievementCount', $AchievementCount);
		$this->assign('ProjectNum', $ProjectNum);
		$this->display();
	}
	public function edit($id){
		$ProfileModel=D('User');
		if($ProfileModel->validate()->create()){
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