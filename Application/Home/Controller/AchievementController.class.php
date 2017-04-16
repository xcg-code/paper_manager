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
	//我的科研成果页面
	public function my_achievement(){
		$AchievementModel=M('Achievement');
		$Condition['user_id']=session('uid');
		$AchievementInfo=$AchievementModel->where($Condition)->select();
		$AchievementCount['All']=$AchievementModel->where($Condition)->count();
		//获取各种科研成果的数目
		$AchievementCount=get_achievement_count($AchievementCount,$AchievementInfo);
		$this->assign('AchievementInfo',$AchievementInfo);
		$this->assign('AchievementCount',$AchievementCount);
		$this->display();
	}

	public function journal_paper_add($id){
		parent::is_login();
		$this->display();
	}
	public function journal_paper_add_db($id){
		$JournalModel=D('Journalpaper');
		$AchievementModel=D('Achievement');
		if($JournalModel->create()){
			//添加用户id
			$JournalModel->user_id=$id;
			$Result=$JournalModel->add();//添加信息到期刊论文数据表
			//获取刚刚插入的期刊论文表ID值
			$condition=array(
			'user_id'=>$id,
			'title_zh'=>I('post.title_zh'),
			'journal_name'=>I('post.journal_name')
			);
			$JouranlInfo=$JournalModel->where($condition)->find();
			var_dump($condition);
			var_dump($JouranlInfo);
			//赋值成果模型类
			$AchievementModel->user_id=$id;
			$AchievementModel->achievement_id=$JouranlInfo['id'];
			$AchievementModel->achievement_type='JournalPaper';
			$AchievementModel->title=$JouranlInfo['title_zh'];
			$AchievementModel->institute_name=$JouranlInfo['journal_name'];
			$AchievementModel->publish_time=$JouranlInfo['publish_date'];
			$ResultAchi=$AchievementModel->add();//添加科研成果信息
			if($Result && $ResultAchi){
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