<?php
namespace Home\Controller;
use Think\Controller;
class ProjectController extends Controller {
	public function my_project(){
		parent::is_login();
		//获取项目类别信息
		$TypeModel=M('Project_type');
		$TypeInfo=$TypeModel->select();
		$ProjectModel=M('Project');
		$Condition['user_id']=session('uid');
		$ProjectInfo=$ProjectModel->where($Condition)->select();
		$this->assign('TypeInfo',$TypeInfo);
		$this->display();
	}
}