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
		//显示头像
		parent::is_login();
		$this->display();
	}
	public function journal_paper_add_db($id){
		$JournalModel=D('Journalpaper');
		if($JournalModel->create()){
			//添加用户id
			$JournalModel->user_id=$id;
			$Result=$JournalModel->add();
			if($Result){
				$this->success('添加期刊论文成功');
			}else{
				$this->error('添加期刊论文失败',__ROOT__.'/index.php/Home/Achievement/journal_paper_add/id/'.$id);
			}
		}else
		{
			$this->error($JournalModel->getError(),__ROOT__.'/index.php/Home/Achievement/journal_paper_add/id/'.$id);
		}
	}

}