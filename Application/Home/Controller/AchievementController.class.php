<?php
namespace Home\Controller;
use Think\Controller;
class AchievementController extends Controller {
	public function achievement_add(){
		//显示头像
		parent::is_login();
		$UserModel=M('User');
		$uid=session('uid');
		$Condition['id']=$uid;
		$Profile=$UserModel->where($Condition)->find();
		$this->assign('Profile', $Profile); //基本信息前端赋值
		$PicPath="Uploads/UserPic/".$Profile['pic_save_path'];
		$this->assign('PicPath', $PicPath); //用户头像信息前端赋值
		$this->display();
	}
	public function journal_paper_add($id){
		$this->display();
	}
	public function add($id){
		$AchievementModel=D('Achievement');
		if($AchievementModel->create())
			echo "success";
		else
			echo "failed";
		$name=I('post.achievement_type');
		$test=$AchievementModel->achievement_type;
		var_dump($test);
		var_dump($name);
		var_dump($AchievementModel);
	}
}