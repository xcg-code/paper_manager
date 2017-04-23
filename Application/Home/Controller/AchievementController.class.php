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

	//显示我的科研成果页面
	public function my_achievement(){
		parent::is_login();
		$AchievementModel=M('Achievement');
		$Condition['user_id']=session('uid');
		$AchievementInfo=$AchievementModel->where($Condition)->select();
		$AchievementCount['All']=count($AchievementInfo);
		//获取各种科研成果的数目
		$AchievementCount=get_achievement_count($AchievementCount,$AchievementInfo);
		//获取作者姓名字符串和详情链接
		for($i=0;$i<count($AchievementInfo);$i++){
			$AchievementInfo[$i]['author']=get_author_list($AchievementInfo[$i]['achievement_id']);
            $AchievementInfo[$i]['detail_link']=get_detail_link($AchievementInfo[$i]);
		}
		$this->assign('AchievementInfo',$AchievementInfo);
		$this->assign('AchievementCount',$AchievementCount);
		$this->display();
	}

	//显示成果文档上传页面
	public function file_upload($achi_id){
		parent::is_login();
		$FileModel=M('File');
		$Condition['achievement_id']=$achi_id;
		$FileInfo=$FileModel->where($Condition)->select();
        //获取文件下载路径
        for($i=0;$i<count($FileInfo);$i++){
            $FileInfo[$i]['path']=get_file_path($FileInfo[$i]);
        }
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

    //删除已上传文件操作
    public function file_delete($id,$file_type){
        $FileModel=M('File');
        $Condition['id']=$id;
        $FileInfo=$FileModel->where($Condition)->find();
        $FilePath=$FileInfo['path'];
        //拼接物理地址
        if($file_type=='Main'){
            $FilePath=substr(THINK_PATH, 0,-9).'Uploads/UserMainFile/'.$FilePath;
        }else{
            $FilePath=substr(THINK_PATH, 0,-9).'Uploads/UserOtherFile/'.$FilePath;
        }
        
        //删除物理文件
        $ResultDel=unlink($FilePath);
        //删除数据库信息
        $ResultDb=$FileModel->where($Condition)->delete();
        if($ResultDel && $ResultDb){
            $this->success('删除文件成功');
        }else{
            $this->error('删除文件失败');
        }
    }

	//显示添加作者信息页面
    public function author_add($achi_id){
    	parent::is_login();
    	$this->assign('achi_id',$achi_id);
    	$this->display();
    }

	//添加作者信息数据库操作
    public function author_add_db($achi_id,$type){
    	$AuthorModel=D('Author');
    	$user_id=session('uid');
    	$Count=I('post.author_num');
    	$Result=false;
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
    		}
    	}
    	if($Result){
            if($type==1){
                $this->success('添加作者信息成功',__ROOT__.'/index.php/Home/Achievement/file_upload/achi_id/'.$achi_id);
            }else{
                $this->success('添加作者信息成功');
            }
    		
    	}else{
    		$this->success('添加作者信息失败');
    	}

    }

	//显示查看作者页面
    public function author_show($achi_id,$page_type){
    	parent::is_login();
    	$AuthorModel=M('Author');
    	$Condition['achievement_id']=$achi_id;
    	$AuthorInfo=$AuthorModel->where($Condition)->select();
    	for($i=0;$i<count($AuthorInfo);$i++){
    		if($AuthorInfo[$i]['is_contact']!='是'){$AuthorInfo[$i]['is_contact']='否';}
    		if($AuthorInfo[$i]['is_main']!='是'){$AuthorInfo[$i]['is_main']='否';}
    		if($AuthorInfo[$i]['is_first']!='是'){$AuthorInfo[$i]['is_first']='否';}
    		if($AuthorInfo[$i]['is_company']!='是'){$AuthorInfo[$i]['is_company']='否';}
    	}
    	$this->assign('AuthorInfo',$AuthorInfo);
    	$this->assign('achi_id',$achi_id);
        $this->assign('page_type',$page_type);
    	$this->display();
    }

	//显示修改作者页面
    public function author_edit($author_id,$page_type){
    	parent::is_login();
    	$AuthorModel=M('Author');
    	$Condition['id']=$author_id;
    	$AuthorInfo=$AuthorModel->where($Condition)->find();
    	$this->assign('AuthorInfo',$AuthorInfo);
        $this->assign('page_type',$page_type);
    	$this->display();
    }

	//修改作者信息数据库操作
    public function author_edit_db($author_id,$achi_id,$page_type){
    	$AuthorModel=D('Author');
    	if($AuthorModel->create()){
    		$Condition['id']=$author_id;
    		$Result=$AuthorModel->where($Condition)->save();
    		if($Result==0){
    			$this->error('您没有修改任何信息');
    		}elseif ($Result>0) {
    			$this->success('修改作者信息成功',__ROOT__.'/index.php/Home/Achievement/author_show/achi_id/'.$achi_id.'/page_type/'.$page_type);
    		}else{
    			$this->error($AuthorModel->getError());
    		}
    	}else{
    		$this->error($AuthorModel->getError());
    	}
    }

	//删除作者信息数据库操作
    public function author_delete($author_id,$achi_id){
    	$AuthorModel=D('Author');
    	$Condition['id']=$author_id;
    	$Result=$AuthorModel->where($Condition)->delete();
    	if($Result){
    		$this->success('删除作者信息成功');
    	}else{
    		$this->error($AuthorModel->getError());
    	}
    }

    //显示添加项目类别页面
    public function project_type(){
    	parent::is_login();
        $TypeModel=M('Project_type');
        $TypeInfo=$TypeModel->select();
        $this->assign('TypeInfo',$TypeInfo);
    	$this->display();
    }

    //添加项目类别数据库操作
    public function project_type_add(){
        $TypeModel=D('Project_type');
        if($TypeModel->create()){
            $Result=$TypeModel->add();
            if($Result){
                $this->success('新增项目类别信息成功');
            }
        }else{
            $this->error($TypeModel->getError());
        }
    }

    //删除项目类别信息数据库操作
    public function project_type_delete($type_id){
        $TypeModel=M('Project_type');
        $Condition['id']=$type_id;
        $Result=$TypeModel->where($Condition)->delete();
        if($Result){
            $this->success('删除项目类别信息成功');
        }else{
            $this->error('删除项目类别信息失败');
        }
    }

    //显示添加项目信息页面
    public function project_add($achi_id){
    	parent::is_login();
        $TypeModel=M('Project_type');
        $TypeInfo=$TypeModel->select();
        $this->assign('TypeInfo',$TypeInfo);
        $this->assign('achi_id',$achi_id);
    	$this->display();
    }

    //添加项目类别信息数据库操作
    public function project_add_db($achi_id,$type){
        $ProjectModel=D('Project');
        $user_id=session('uid');
        $Count=I('post.num');
        if($type==2){
            if($Count==0){
                $this->error('您未添加任何信息');
            }
        }
        
        for($i=0;$i<$Count;$i++){
            $Data['type_name']=I('post.type_name_'.$i);
            $Data['project_num']=I('post.project_num_'.$i).';';
            $Data['content']=I('post.content_'.$i);
            $Data['user_id']=$user_id;
            $Data['achievement_id']=$achi_id;
            $ProjectModel->add($Data);
        }
        if($type==1){
            $this->success('您可以在我的科研成果列表查看该成果了',__ROOT__.'/index.php/Home/Achievement/my_achievement');
        }else{
            $this->success('新增科研成果所属项目信息成功');
        }
    }

    //显示查看修改成果所属项目信息页面
    public function project_show($achi_id,$page_type){
        parent::is_login();
        //获取项目类别信息
        $TypeModel=M('Project_type');
        $TypeInfo=$TypeModel->select();
        $this->assign('TypeInfo',$TypeInfo);
        $this->assign('achi_id',$achi_id);
        //获取所属项目信息
        $ProjectModel=M('Project');
        $Condition['achievement_id']=$achi_id;
        $ProjectInfo=$ProjectModel->where($Condition)->select();
        $this->assign('ProjectInfo',$ProjectInfo);
        $this->assign('page_type',$page_type);
        $this->display();
    }

    //显示编辑成果所属项目信息页面
    public function project_edit($project_id,$page_type){
        parent::is_login();
        //获取项目类别信息
        $TypeModel=M('Project_type');
        $TypeInfo=$TypeModel->select();
        $this->assign('TypeInfo',$TypeInfo);
        $this->assign('achi_id',$achi_id);
        //获取所属项目信息
        $ProjectModel=M('Project');
        $Condition['id']=$project_id;
        $ProjectInfo=$ProjectModel->where($Condition)->find();
        $this->assign('ProjectInfo',$ProjectInfo);
        $this->assign('page_type',$page_type);
        $this->display();
    }

    //编辑成果所属信息数据库操作
    public function project_edit_db($project_id,$achi_id,$page_type){
        $ProjectModel=D('Project');
        if($ProjectModel->create()){
            $Condition['id']=$project_id;
            $Result=$ProjectModel->where($Condition)->save();
            if($Result){
                $this->success('修改所属项目信息成功',__ROOT__.'/index.php/Home/Achievement/project_show/achi_id/'.$achi_id.'/page_type/'.$page_type);
            }else{
                $this->error($ProjectModel->getError());
            }
        }else{
            $this->error($ProjectModel->getError());
        }
    }

    //删除成果所属信息数据库操作
    public function project_delete($project_id){
        $ProjectModel=M('Project');
        $Condition['id']=$project_id;
        $Result=$ProjectModel->where($Condition)->delete();
        if($Result){
            $this->success('删除所属项目信息成功');
        }else{
            $this->error('删除所属项目信息失败');
        }
    }

	//显示添加期刊论文信息页面
    public function journal_paper_add($id){
    	parent::is_login();
    	$this->display();
    }

	//添加期刊论文数据库操作
    public function journal_paper_add_db($id){
    	$JournalModel=D('Journalpaper');
    	$AchievementModel=D('Achievement');
    	if($JournalModel->create()){
    		$JournalModel->user_id=$id;
    		$uniq_id=uniqid();
    		$JournalModel->id=$uniq_id;
			$Inclu='';//收录情况
			foreach ($JournalModel->inbox_status as $value) {
				$Inclu=$Inclu.$value.';';
			}
			$JournalModel->inbox_status=$Inclu;
			//赋值成果汇总模型类
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
				$this->success('添加期刊论文成功，请添加作者信息',__ROOT__.'/index.php/Home/Achievement/author_add/achi_id/'.$uniq_id);
			}else{
				$JournalModel->rollback();
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
		$this->assign('JournalInfo', $JournalInfo);
        //添加相关操作信息
        $this->assign('id', $JournalInfo['id']);
        $this->assign('edit','journal_paper_edit');
        $this->assign('delete','journal_paper_delete');
        $this->assign('show','journal_paper_show');

		//获取全文电子文档路径信息
		$FilePath=get_main_file_path($achi_id);
		$this->assign('FilePath', $FilePath); 
		$this->display();
	}

	//显示期刊论文基本信息修改页面
	public function journal_paper_edit($achi_id){
		parent::is_login();
		$JournalModel=D('Journalpaper');
		$Condition['id']=$achi_id;
		$JournalInfo=$JournalModel->where($Condition)->find();
		$Content=get_sub_content($JournalInfo['inbox_status']);//获取拆分后内容
		$Content=get_inbox_status($Content);//获取收录情况数组
		$this->assign('Content', $Content);
		$this->assign('JournalInfo', $JournalInfo);
		$this->display();
	}

	//期刊论文基本信息修改数据库操作
	public function journal_paper_edit_db($achi_id){
		$JournalModel=D('Journalpaper');
		$AchievementModel=D('Achievement');
		if($JournalModel->create()){
			$JournalModel->user_id=session('uid');
			$Inclu='';//收录情况
			foreach ($JournalModel->inbox_status as $value) {
				$Inclu=$Inclu.$value.';';
			}
			$JournalModel->inbox_status=$Inclu;
			//赋值成果汇总表模型类
			$AchievementModel->achievement_id=$achi_id;
			$AchievementModel->user_id=session('uid');
			$AchievementModel->achievement_type='JournalPaper';
			$AchievementModel->title=$JournalModel->title_zh;
			$AchievementModel->institute_name=$JournalModel->journal_name;
			$AchievementModel->publish_time=$JournalModel->publish_date;
			$ConditionJ['id']=$achi_id;
			$ConditionA['achievement_id']=$achi_id;
			//SQL操作
			$ResultJournal=$JournalModel->where($ConditionJ)->save();
			$ResultAchi=$AchievementModel->where($ConditionA)->save();
			if($ResultJournal>0){
				$this->success('论文信息修改成功',__ROOT__.'/index.php/Home/Achievement/journal_paper_show/achi_id/'.$achi_id);
			}
			else if($ResultJournal==0){
				$this->error('您没有修改任何信息');
			}
			else{
				$this->error('论文信息修改失败');
			}
		}else{
			$this->error($JournalModel->getError());
		}
	}

    //删除期刊论文成果信息
    public function journal_paper_delete($achi_id){
        $JournalModel=M('Journalpaper');
        $Condition['id']=$achi_id;
        $JournalModel->where($Condition)->delete();
        //删除相关作者，文件，所属项目，成果汇总信息
        delete_all_info($achi_id);
        $this->success('删除该科研成果成功',__ROOT__.'/index.php/Home/Achievement/my_achievement');
    }

    //显示会议论文添加页面
    public function conference_paper_add(){
        parent::is_login();
        $this->display();
    }

    //添加会议论文基本信息数据库操作
    public function conference_paper_add_db(){
        $ConferenceModel=D('Conferencepaper');
        $AchievementModel=D('Achievement');
        if($ConferenceModel->create()){
            $ConferenceModel->user_id=session('uid');
            $uniq_id=uniqid();
            $ConferenceModel->id=$uniq_id;
            $Inclu='';//收录情况
            foreach ($ConferenceModel->inbox_status as $value) {
                $Inclu=$Inclu.$value.';';
            }
            $ConferenceModel->inbox_status=$Inclu;
            //赋值成果汇总模型类
            $AchievementModel->achievement_id=$uniq_id;
            $AchievementModel->user_id=session('uid');
            $AchievementModel->achievement_type='ConferencePaper';
            $AchievementModel->title=$ConferenceModel->title_zh;
            $AchievementModel->institute_name=$ConferenceModel->conference_name;
            $AchievementModel->publish_time=$ConferenceModel->publish_date;

            //sql事务
            $ConferenceModel->startTrans();
            $ResultConference=$ConferenceModel->add();//添加信息到期刊论文数据表
            $ResultAchi=$AchievementModel->add();
            if($ResultConference && $ResultAchi){
                $ConferenceModel->commit();
                $this->success('添加会议论文成功，请添加作者信息',__ROOT__.'/index.php/Home/Achievement/author_add/achi_id/'.$uniq_id);
            }else{
                $ConferenceModel->rollback();
                $this->error('添加会议论文失败,请检查信息后重新保存');
            }
        }else{
            $this->error($ConferenceModel->getError());
        }
    }

    //显示会议论文详情页
    public function conference_paper_show($achi_id){
        parent::is_login();
        $ConferenceModel=M('Conferencepaper');
        $Condition['id']=$achi_id;
        $ConferenceInfo=$ConferenceModel->where($Condition)->find();
        //添加其他详细信息
        $ConferenceInfo['achievement_type']='会议论文';
        $this->assign('ConferenceInfo', $ConferenceInfo);
        //添加相关操作信息
        $this->assign('id', $ConferenceInfo['id']);
        $this->assign('edit','conference_paper_edit');
        $this->assign('delete','conference_paper_delete');
        $this->assign('show','conference_paper_show');

        //获取全文电子文档路径信息
        $FilePath=get_main_file_path($achi_id);
        $this->assign('FilePath', $FilePath); 
        $this->display();
    }

    //显示会议论文编辑页面
    public function conference_paper_edit($achi_id){
        parent::is_login();
        $ConferenceModel=D('Conferencepaper');
        $Condition['id']=$achi_id;
        $ConferenceInfo=$ConferenceModel->where($Condition)->find();
        $Content=get_sub_content($ConferenceInfo['inbox_status']);//获取拆分后内容
        $Content=get_inbox_status($Content);//获取收录情况数组
        $this->assign('Content', $Content);
        $this->assign('ConferenceInfo', $ConferenceInfo);
        $this->display();
    }

    //会议论文修改功能
    public function conference_paper_edit_db($achi_id){
        $ConferenceModel=D('Conferencepaper');
        $AchievementModel=D('Achievement');
        if($ConferenceModel->create()){
            $ConferenceModel->user_id=session('uid');
            $Inclu='';//收录情况
            foreach ($ConferenceModel->inbox_status as $value) {
                $Inclu=$Inclu.$value.';';
            }
            $ConferenceModel->inbox_status=$Inclu;
            //赋值成果汇总表模型类
            $AchievementModel->achievement_id=$achi_id;
            $AchievementModel->title=$ConferenceModel->title_zh;
            $AchievementModel->institute_name=$ConferenceModel->conference_name;
            $AchievementModel->publish_time=$ConferenceModel->publish_date;
            $ConditionJ['id']=$achi_id;
            $ConditionA['achievement_id']=$achi_id;
            //SQL操作
            $Result=$ConferenceModel->where($ConditionJ)->save();
            $AchievementModel->where($ConditionA)->save();
            if($Result>0){
                $this->success('信息修改成功',__ROOT__.'/index.php/Home/Achievement/conference_paper_show/achi_id/'.$achi_id);
            }
            else if($Result==0){
                $this->error('您没有修改任何信息');
            }
            else{
                $this->error('论文信息修改失败');
            }
        }else{
            $this->error($ConferenceModel->getError());
        }
    }

    //删除会议论文信息
    public function conference_paper_delete($achi_id){
        $ConferenceModel=M('Conferencepaper');
        $Condition['id']=$achi_id;
        $ConferenceModel->where($Condition)->delete();
        //删除相关作者，文件，所属项目，成果汇总信息
        delete_all_info($achi_id);
        $this->success('删除该科研成果成功',__ROOT__.'/index.php/Home/Achievement/my_achievement');
    }

    //显示学术专著录入界面
    public function monograph_add(){
        parent::is_login();
        $this->display();
    }

    //添加学术专著信息数据库操作
    public function monograph_add_db(){
        $MonographModel=D('Monograph');
        $AchievementModel=D('Achievement');
        if($MonographModel->create()){
            $MonographModel->user_id=session('uid');
            $uniq_id=uniqid();
            $MonographModel->id=$uniq_id;
            //赋值成果汇总模型类
            $AchievementModel->achievement_id=$uniq_id;
            $AchievementModel->user_id=session('uid');
            $AchievementModel->achievement_type='Monograph';
            $AchievementModel->title=$MonographModel->title_zh;
            $AchievementModel->institute_name=$MonographModel->publisher;
            $AchievementModel->publish_time=$MonographModel->publish_date;

            //sql事务
            $MonographModel->startTrans();
            $ResultMonograph=$MonographModel->add();//添加信息到期刊论文数据表
            $ResultAchi=$AchievementModel->add();
            if($ResultMonograph && $ResultAchi){
                $MonographModel->commit();
                $this->success('添加学术专著成功，请添加作者信息',__ROOT__.'/index.php/Home/Achievement/author_add/achi_id/'.$uniq_id);
            }else{
                $MonographModel->rollback();
                $this->error('添加学术专著失败');
            }
        }else{
            $this->error($MonographModel->getError());
        }
    }

    //显示学术专著详情页面
    public function monograph_show($achi_id){
        parent::is_login();
        $MonographModel=M('Monograph');
        $Condition['id']=$achi_id;
        $MonographInfo=$MonographModel->where($Condition)->find();
        //添加其他详细信息
        $MonographInfo['achievement_type']='学术专著';
        $this->assign('MonographInfo', $MonographInfo);
        //添加相关操作信息参数
        $this->assign('id', $MonographInfo['id']);
        $this->assign('edit','monograph_edit');
        $this->assign('delete','monograph_delete');
        $this->assign('show','monograph_show');

        //获取全文电子文档路径信息
        $FilePath=get_main_file_path($achi_id);
        $this->assign('FilePath', $FilePath); 
        $this->display();
    }

    //显示学术专著编辑页面
    public function monograph_edit($achi_id)
    {
        parent::is_login();
        $MonographModel=D('Monograph');
        $Condition['id']=$achi_id;
        $MonographInfo=$MonographModel->where($Condition)->find();
        $this->assign('MonographInfo', $MonographInfo);
        $this->display();
    }

    //学术专著编辑数据库操作
    public function monograph_edit_db($achi_id){
        $MonographModel=D('Monograph');
        $AchievementModel=D('Achievement');
        if($MonographModel->create()){
            //赋值成果汇总表模型类
            $AchievementModel->achievement_id=$achi_id;
            $AchievementModel->title=$MonographModel->title_zh;
            $AchievementModel->institute_name=$MonographModel->publisher;
            $AchievementModel->publish_time=$MonographModel->publish_date;
            $ConditionJ['id']=$achi_id;
            $ConditionA['achievement_id']=$achi_id;
            //SQL操作
            $Result=$MonographModel->where($ConditionJ)->save();
            $AchievementModel->where($ConditionA)->save();
            if($Result>0){
                $this->success('信息修改成功',__ROOT__.'/index.php/Home/Achievement/monograph_show/achi_id/'.$achi_id);
            }
            else if($Result==0){
                $this->error('您没有修改任何信息');
            }
            else{
                $this->error('信息修改失败');
            }
        }else{
            $this->error($MonographModel->getError());
        }
    }

    //学术专著删除
    public function monograph_delete($achi_id){
        $MonographModel=M('Monograph');
        $Condition['id']=$achi_id;
        $MonographModel->where($Condition)->delete();
        //删除相关作者，文件，所属项目，成果汇总信息
        delete_all_info($achi_id);
        $this->success('删除该科研成果成功',__ROOT__.'/index.php/Home/Achievement/my_achievement');
    }

    //显示专利添加页面
    public function patent_add(){
        parent::is_login();
        $this->display();
    }

    //添加专利信息数据库操作
    public function patent_add_db(){
        $PatentModel=D('Patent');
        $AchievementModel=D('Achievement');
        if($PatentModel->create()){
            $PatentModel->user_id=session('uid');
            $uniq_id=uniqid();
            $PatentModel->id=$uniq_id;
            //赋值成果汇总模型类
            $AchievementModel->achievement_id=$uniq_id;
            $AchievementModel->user_id=session('uid');
            $AchievementModel->achievement_type='Patent';
            $AchievementModel->title=$PatentModel->title_zh;
            $AchievementModel->institute_name=$PatentModel->publisher;
            $AchievementModel->publish_time=$PatentModel->apply_date;

            //sql事务
            $PatentModel->startTrans();
            $ResultPatent=$PatentModel->add();//添加信息到期刊论文数据表
            $ResultAchi=$AchievementModel->add();
            if($ResultPatent && $ResultAchi){
                $PatentModel->commit();
                $this->success('添加专利成功，请添加作者信息',__ROOT__.'/index.php/Home/Achievement/author_add/achi_id/'.$uniq_id);
            }else{
                $PatentModel->rollback();
                $this->error('添加专利失败');
            }
        }else{
            $this->error($PatentModel->getError());
        }
    }

    //显示专利详情页面
    public function patent_show($achi_id){
        parent::is_login();
        $PatentModel=M('Patent');
        $Condition['id']=$achi_id;
        $PatentInfo=$PatentModel->where($Condition)->find();
        //添加其他详细信息
        $PatentInfo['achievement_type']='专利';
        $this->assign('PatentInfo', $PatentInfo);
        //添加相关操作信息参数
        $this->assign('id', $PatentInfo['id']);
        $this->assign('edit','patent_edit');
        $this->assign('delete','patent_delete');
        $this->assign('show','patent_show');

        //获取全文电子文档路径信息
        $FilePath=get_main_file_path($achi_id);
        $this->assign('FilePath', $FilePath); 
        $this->display();
    }

    //显示专利修改页面
    public function patent_edit($achi_id){
        parent::is_login();
        $PatentModel=D('Patent');
        $Condition['id']=$achi_id;
        $PatentInfo=$PatentModel->where($Condition)->find();
        $this->assign('PatentInfo', $PatentInfo);
        $this->display();
    }

    //专利信息修改数据库操作
    public function patent_edit_db($achi_id){
        $PatentModel=D('Patent');
        $AchievementModel=D('Achievement');
        if($PatentModel->create()){
            //检测成果转化状态是否变化
            if($PatentModel->status=='申请'){
                $PatentModel->tran_status='';
                $PatentModel->price=null;
            }
            //赋值成果汇总表模型类
            $AchievementModel->achievement_id=$achi_id;
            $AchievementModel->title=$PatentModel->title_zh;
            $AchievementModel->institute_name=$PatentModel->publisher;
            $AchievementModel->publish_time=$PatentModel->publish_date;
            $ConditionJ['id']=$achi_id;
            $ConditionA['achievement_id']=$achi_id;
            //SQL操作
            $Result=$PatentModel->where($ConditionJ)->save();
            $AchievementModel->where($ConditionA)->save();
            if($Result>0){
                $this->success('信息修改成功',__ROOT__.'/index.php/Home/Achievement/patent_show/achi_id/'.$achi_id);
            }
            else if($Result==0){
                $this->error('您没有修改任何信息');
            }
            else{
                $this->error('信息修改失败');
            }
        }else{
            $this->error($PatentModel->getError());
        }
    }
}