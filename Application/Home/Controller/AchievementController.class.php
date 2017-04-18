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
		parent::is_login();
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

	//显示添加作者信息页面
	public function author_add($achi_id){
		parent::is_login();
		$this->assign('achi_id',$achi_id);
		$this->display();
	}

	//添加作者信息数据库操作
	public function author_add_db($achi_id){
		$AuthorModel=D('Author');
		$user_id=session('uid');
		$Count=I('post.author_num');
		$Result=false;
		$AuthorList='';
		if($Count==0){
			$this->error('您没有填写任何作者信息');
		}
		for ($i=0; $i < $Count; $i++) { 
			$Data['author_name']=I('post.author_name_'.$i);
			if($Data['author_name']==''){
				$this->error('作者姓名为必填项');
			}
			$Data['author_workplace']=I('post.author_workplace_'.$i);
			$Data['author_email']=I('post.author_email_'.$i);
			$Data['is_contact']=I('post.is_contact_'.$i);
			$Data['is_first']=I('post.is_first_'.$i);
			$Data['is_main']=I('post.is_main_'.$i);
			$Data['is_company']=I('post.is_company_'.$i);
			$Data['user_id']=$user_id;
			$Data['achievement_id']=$achi_id;
			if($AuthorModel->add($Data)){
				$Result=true;
				$AuthorList=$AuthorList.$Data['author_name'].';';//合并作者名字
			}
		}
		$Condition['achievement_id']=$achi_id;
		$AchievementModel=M('Achievement');
		$AchievementModel->author=$AuthorList;
		$AchiResult=$AchievementModel->where($Condition)->save();
		if($Result && $AchiResult){
			$this->success('添加作者信息成功，请上传相关文档');
		}else{
			$this->success('添加作者信息失败');
		}
		
	}

	//显示添加期刊论文信息页面
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
				$this->success('添加期刊论文成功，请添加作者信息',__ROOT__.'/index.php/Home/Achievement/journal_paper_author_add/achi_id/'.$uniq_id);
			}else{
				$this->error('添加期刊论文失败,请检查信息后重新保存');
			}
		}else
		{
			$this->error($JournalModel->getError());
		}
	}

	//查看期刊论文详细信息
	public function journal_paper_show($achi_id){
		parent::is_login();
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
		//获取全文电子文档路径信息
		$FilePath=get_main_file_path($achi_id);
		$this->assign('FilePath', $FilePath); 
		$this->display();
	}

	//显示成果文档上传页面
	public function file_upload($achi_id){
		parent::is_login();
		$FileModel=M('File');
		$Condition['$achievement_id']=$achi_id;
		$FileInfo=$FileModel->where($Condition)->select();
		$this->assign('achi_id', $achi_id); 
		$this->assign('FileInfo', $FileInfo); 
		$this->display();
	}

	//全文电子文档上传
	public function file_upload_main_db($achi_id){
		$upload = new \Think\Upload();// 实例化上传类
    	$upload->maxSize   =     20971520 ;// 设置附件上传大小 20MB
    	$upload->exts      =     array('pdf');// 设置附件上传类型
    	$upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
    	$upload->savePath  =     './UserMainFile/'; // 设置附件上传（子）目录
    	$upload->saveName = array('uniqid','');
    	$upload->autoSub  = false;
    	$info   =   $upload->uploadOne($_FILES['main']);
    	if(!$info) {// 上传错误提示错误信息
    	    $this->error($upload->getError());
    	}else{// 上传成功
    		$FileInfo['name']=$info['name'];
    		$FileInfo['path']=$info['savename'];
    		$FileInfo['description']=I('post.description');
    		$FileInfo['upload_time']=date("Y-m-d H:i:s");
    		$FileInfo['type']='Main';
    		$FileInfo['achievement_id']=$achi_id;
    	    $FileModel=M('File');
    	    $Result=$FileModel->add($FileInfo);
    	    if($Result){
    	    	$this->success('全文电子文档上传成功',__ROOT__.'/index.php/Home/Achievement/file_upload/achi_id/'.$achi_id);
    	    }else{
    	    	$this->error('全文电子文档上传失败');
    	    }
    	}
	}

	//科研成果其他相关文档上传
	public function file_upload_other_db($achi_id){
		$upload = new \Think\Upload();// 实例化上传类
    	$upload->maxSize   =     20971520 ;// 设置附件上传大小 20MB
    	$upload->exts      =     array('pdf');// 设置附件上传类型
    	$upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
    	$upload->savePath  =     './UserOtherFile/'; // 设置附件上传（子）目录
    	$upload->saveName = array('uniqid','');
    	$upload->autoSub  = false;
    	$info   =   $upload->uploadOne($_FILES['other']);
    	if(!$info) {// 上传错误提示错误信息
    	    $this->error($upload->getError());
    	}else{// 上传成功
    		$FileInfo['name']=$info['name'];
    		$FileInfo['path']=$info['savename'];
    		$FileInfo['description']=I('post.description');
    		$FileInfo['upload_time']=date("Y-m-d H:i:s");
    		$FileInfo['type']='Other';
    		$FileInfo['achievement_id']=$achi_id;
    	    $FileModel=M('File');
    	    $Result=$FileModel->add($FileInfo);
    	    if($Result){
    	    	$this->success('文档上传成功',__ROOT__.'/index.php/Home/Achievement/file_upload/achi_id/'.$achi_id);
    	    }else{
    	    	$this->error('文档上传失败');
    	    }
    	}
	}

}