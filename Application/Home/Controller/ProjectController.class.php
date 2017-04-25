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
		if($project_type!=''){
			for($i=0;$i<count($TypeInfo);$i++){
				if($project_type==$TypeInfo[$i]['id']){
					$Condition['type_name']=$TypeInfo[$i]['type_name'];
					break;
				}
			}		
		}
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
		$this->assign('page',$show);// 赋值分页输出
		$this->display();
	}
}