<?php
namespace Home\Controller;
use Think\Controller;
class ProjectController extends Controller {
	public function my_project($project_type=''){
		parent::is_login();
		//获取项目类别信息
		$TypeModel=M('Project_type');
		$TypeInfo=$TypeModel->select();
		$TypeInfo=get_project_num($TypeInfo);
		//获取项目总个数
		$AllCount=get_all_project_num($TypeInfo);
		//获取检索条件
		$ProjectModel=M('Project');
		$Condition['user_id']=session('uid');
		$SearchAction='';
		if($project_type!=''){
			for($i=0;$i<count($TypeInfo);$i++){
				if($project_type==$TypeInfo[$i]['id']){
					$Condition['type_name']=$TypeInfo[$i]['type_name'];
					break;
				}
			}
			$SearchAction='project_type/'.$project_type;	
		}
		//获取搜索栏内容
		$Search=I('post.search');
        $Condition['project_name|project_num']=array('like','%'.$Search.'%');
		//获取记录数
		$ProjectCount=$ProjectModel->where($Condition)->count();
		//分页数据获取
        $Page= get_page($ProjectCount,10);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show= $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $ProjectInfo=$ProjectModel->where($Condition)->limit($Page->firstRow.','.$Page->listRows)->select();

		$this->assign('TypeInfo',$TypeInfo);
		$this->assign('AllCount',$AllCount);
		$this->assign('ProjectInfo',$ProjectInfo);
		$this->assign('SearchAction',$SearchAction);
		$this->assign('page',$show);// 赋值分页输出
		$this->display();
	}

	//显示项目详情页面
	public function project_show($id,$achi_type='',$achi_year=''){
		parent::is_login();
		//获取项目信息
		$ProjectModel=M('Project');
		$ConditionPro['id']=$id;
		$ProjectInfo=$ProjectModel->where($ConditionPro)->find();
		//获取项目下的科研成果信息
		$AchievementModel=M('Achievement');
		$Condition['user_id']=session('uid');
		//获取项目信息
		$Condition['achievement_id']=$ProjectInfo['achievement_id'];
        $SearchAction='';
        if($achi_type!=''){
            $Condition['achievement_type']=$achi_type;
            $SearchAction='achi_type/'.$achi_type;
        }
        if($achi_year!=''){
            $start_date=$achi_year.'-01-01';
            $end_date=$achi_year.'-12-31';
            $Condition['publish_time']=array(array('egt',$start_date),array('elt',$end_date));
            $SearchAction='achi_year/'.$achi_year;
        }
        //获取搜索栏内容
        $Search=I('post.search');
        $Condition['title']=array('like','%'.$Search.'%');
        //获取记录数
        $AchievementYearCount=$AchievementModel->where($Condition)->count();
        //获取各种科研成果的数目
        $AchievementCount=get_achievement_count($ProjectInfo['achievement_id']);
        //获取不同年份科研成果的数量
        $AchievementYear=get_achievement_year($ProjectInfo['achievement_id']);
        //分页数据获取
        $Page= get_page($AchievementYearCount,5);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show= $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $AchievementInfo=$AchievementModel->where($Condition)->order('publish_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		//获取作者姓名字符串和详情链接
		for($i=0;$i<count($AchievementInfo);$i++){
			$AchievementInfo[$i]['author']=get_author_list($AchievementInfo[$i]['achievement_id']);
            $AchievementInfo[$i]['detail_link']=get_detail_link($AchievementInfo[$i]);
		}
		$this->assign('AchievementInfo',$AchievementInfo);
		$this->assign('AchievementCount',$AchievementCount);
        $this->assign('AchievementYear',$AchievementYear);
        $this->assign('SearchAction',$SearchAction);
        $this->assign('page',$show);// 赋值分页输出
		$this->assign('ProjectInfo',$ProjectInfo);
		$this->display();
	}

	//显示科研项目编辑页面
	public function project_edit($id){
		parent::is_login();
		//获取项目类别信息
        $TypeModel=M('Project_type');
        $TypeInfo=$TypeModel->select();
        $this->assign('TypeInfo',$TypeInfo);
        $this->assign('achi_id',$achi_id);
        //获取项目信息
		$ProjectModel=M('Project');
		$Condition['id']=$id;
		$ProjectInfo=$ProjectModel->where($Condition)->find();
		$this->assign('ProjectInfo',$ProjectInfo);
		$this->display();
	}

	//科研项目编辑数据库操作
	public function project_edit_db($project_id){
		$ProjectModel=D('Project');
        if($ProjectModel->create()){
            $Condition['id']=$project_id;
            $Result=$ProjectModel->where($Condition)->save();
            if($Result){
                $this->success('修改所属项目信息成功',__ROOT__.'/index.php/Home/Project/project_show/id/'.$project_id);
            }else{
                $this->error($ProjectModel->getError());
            }
        }else{
            $this->error($ProjectModel->getError());
        }
	}

	//科研项目删除功能
	public function project_delete($project_id){
		$ProjectModel=M('Project');
        $Condition['id']=$project_id;
        $Result=$ProjectModel->where($Condition)->delete();
        if($Result){
            $this->success('删除所属项目信息成功',__ROOT__.'/index.php/Home/Project/my_project');
        }else{
            $this->error('删除所属项目信息失败');
        }
	}

	//科研项目协作页面
	public function project_git(){
		$GitMemModel=M('GitMember');
		$Condition['user_id']=session('uid');
		$GitId=$GitMemModel->field('git_id')->where($Condition)->select();
		$GitIdList='';
		for($i=0;$i<count($GitId);$i++){
			if($i==count($GitId)-1){
				$GitIdList.=$GitId[$i]['git_id'];
				break;
			}
			$GitIdList.=$GitId[$i]['git_id'].',';	
		}
		//查询已参与的协作科研项目
		$GitModel=M('Git');
		$map['id']=array('in',$GitIdList);
		$GitInfo=$GitModel->where($map)->select();
		for($i=0;$i<count($GitInfo);$i++){
			if($GitInfo[$i]['state']==0){
				$GitInfo[$i]['state']='进行中';
			}else{
				$GitInfo[$i]['state']='已完成';
			}
			
		}
		$this->assign('GitInfo',$GitInfo);
		$this->display();
	}

	//创建新的协作科研项目页面
	public function project_create(){
		//获取项目类别信息
		$TypeModel=M('Project_type');
		$TypeInfo=$TypeModel->select();
		//获取实验室ID
		$MemberModel=M('User');
		$MemberCondi['id']=session('uid');
		$LabId=$MemberModel->where($MemberCondi)->find();
		$LabId=$LabId['lab_id'];
		//获取该实验室下所有人员信息
		$MemberInfo=$MemberModel->where("lab_id='%s'",$LabId)->select();

		$this->assign('TypeInfo',$TypeInfo);
		$this->assign('MemberInfo',$MemberInfo);
		$this->display();
	}

	//创建新的协作科研项目数据库操作()
	public function project_create_db(){
		//添加协作项目基本信息
		$GitModel=M('Git');
		$GitMember=M('GitMember');

		if($GitModel->create()){
			//生成协作科研项目ID
			$uniq_id=uniqid();
			$MemberID=I('post.member');//获取项目成员ID数组
			$GitModel->id=$uniq_id;
			$GitModel->owner=session('fullname');
			//导入项目成员信息到数据库
			for($i=0;$i<count($MemberID);$i++){
				$GitMember->user_id=$MemberID[$i];
				$GitMember->git_id=$uniq_id;
				$GitMember->add();
			}

			$Result=$GitModel->add();//导入协作科研项目信息到数据库
			if($Result){
				$this->success('创建协作科研项目成功',__ROOT__.'/index.php/Home/Project/project_git');
			}else{
				$this->error($GitModel->getError());
			}
		}else{
			$this->error($GitModel->getError());
		}
	}

	//某协作科研项目详情页面
	public function project_git_show($git_id){
		//获取项目信息
		$ProjectModel=M('Git');
		$ProjectInfo=$ProjectModel->where("id='%s'",$git_id)->find();
		//判断当前用户是否为项目负责人
		if(session('fullname')!=$ProjectInfo['owner']){
			$IsAdmin=0;//0表示当前用户不是项目负责人
		}else{
			$IsAdmin=1;//0表示当前用户是项目负责人
		}
		$this->assign('ProjectInfo',$ProjectInfo);
		$this->assign('IsAdmin',$IsAdmin);
		$this->display();
	}
}