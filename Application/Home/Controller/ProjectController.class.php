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
}