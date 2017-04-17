<?php
namespace Home\Controller;
use Think\Controller;
class AchievementController extends Controller {
	public function achievement_add(){
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

	//保存作者信息
	public function author_add($achi_id){
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
			$JournalModel->user_id=$id;
			$uniq_id=uniqid();
			$JournalModel->id=$uniq_id;
			$AchievementModel->achievement_id=$uniq_id;
			$AchievementModel->user_id=$id;
			$AchievementModel->achievement_type='JournalPaper';
			$AchievementModel->title=$JournalModel->title_zh;
			$AchievementModel->institute_name=$JournalModel->journal_name;
			$AchievementModel->publish_time=$JournalModel->publish_date;
			//sql事务
			$JournalModel->startTrans();
			$ResultJournal=$JournalModel->add();//添加信息到期刊论文数据表
			$ResultAchi=$AchievementModel->add();
			if($ResultJournal && $ResultAchi){
				$JournalModel->commit();
				$this->success('添加期刊论文成功，请添加作者信息');
			}else{
				$this->error('添加期刊论文失败',__ROOT__.'/index.php/Home/Achievement/journal_paper_add/id/'.$id);
			}
		}else
		{
			$this->error($JournalModel->getError(),__ROOT__.'/index.php/Home/Achievement/journal_paper_add/id/'.$id);
		}
	}

	//查看期刊论文详细信息
	public function journal_paper_show($achi_id){
		$JournalModel=M('Journalpaper');
		$Condition['id']=$achi_id;
		$JournalInfo=$JournalModel->where($Condition)->find();
		//添加其他详细信息
		$JournalInfo['achievement_type']='期刊论文';
		if($JournalInfo['language']=='Chinese'){
			$JournalInfo['language']='中文';
		}else{
			$JournalInfo['language']='英文';
		}
		if($JournalInfo['status']=='published'){
			$JournalInfo['status']='已发表';
		}else{
			$JournalInfo['status']='已接受未发表';
		}
		if($JournalInfo['inbox_status']=='peking'){
			$JournalInfo['inbox_status']='北大中文核心期刊';
		}else if($JournalInfo['inbox_status']=='other'){
			$JournalInfo['inbox_status']='其他';
		}
		$this->assign('JournalInfo', $JournalInfo); 
		$this->display();
	}

}