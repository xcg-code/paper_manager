<?php
namespace Home\Controller;
use Think\Controller;
class LabController extends Controller {
    public function lab_apply(){
    	parent::is_login();
        //检测是否已经有实验室
        $UserModel=M('User');
        $Condition['id']=session('uid');
        $UserInfo=$UserModel->where($Condition)->find();
        if($UserInfo['lab_id']!='' && $UserInfo['lab_status']==1){
            $this->error('您已加入一个实验室');
        }
        //读取实验室列表
        $LabModel=M('Lab');
        $LabInfo=$LabModel->select();
        //获取申请状态
        if($UserInfo['lab_status']==0 && $UserInfo['lab_id']!=''){
            $UserInfo['state']='待审核';
        }
        if($UserInfo['lab_status']==2){
            $UserInfo['state']='被驳回';
        }
        $this->assign('LabInfo',$LabInfo);
        $this->assign('UserInfo',$UserInfo);
        $this->display();
    }

    //显示创建实验室页面
    public function lab_add(){
        parent::is_login();
        $this->display();
    }

    //创建实验室数据库操作
    public function lab_add_db(){
        $LabModel=D('Lab');
        $UserModel=M('User');
        if($LabModel->create()){
            $uniq_id=uniqid();
            $LabModel->id=$uniq_id;
            $LabModel->holder_id=session('uid');
            $LabModel->holder=session('fullname');
            //赋值用户模型类
            $UserModel->lab_id=$uniq_id;
            $UserModel->lab_name=$LabModel->name;
            $Condition['id']=session('uid');
            //SQL事务
            $LabModel->startTrans();
            $Result=$LabModel->add();
            $ResultUser=$UserModel->where($Condition)->save();
            if($Result && $ResultUser){
                $LabModel->commit();
                $this->success('创建实验室成功',__ROOT__.'/index.php/Home/Lab/my_lab');
            }else{
                $LabModel->rollback();
                $this->error($LabModel->getError());
            }
        }else{
            $this->error($LabModel->getError());
        }
    }

    //申请加入实验室
    public function sub_apply($lab_id){
        //获取实验室信息
        $LabModel=M('Lab');
        $ConditionLab['id']=$lab_id;
        $LabInfo=$LabModel->where($ConditionLab)->find();
        //填充用户实验室信息
        $UserModel=M('User');
        $Condition['id']=session('uid');
        $UserModel->lab_id=$lab_id;
        $UserModel->lab_name=$LabInfo['name'];
        $UserModel->lab_status=0;//申请为待审核状态
        $Result=$UserModel->where($Condition)->save();
        if($Result){
            $this->success('提交加入实验室申请成功，请等待审核');
        }else{
            $this->success('提交加入实验室申请失败');
        }
    }

    //显示我的实验室页面
    public function my_lab(){
        parent::is_login();
        //没有实验室报错
        $UserModel=M('User');
        $ConUser['id']=session('uid');
        $UserInfo=$UserModel->where($ConUser)->find();
        if($UserInfo['lab_status']!=1){
            $this->error('您未加入任何实验室');
        }
        //获取实验室申请数量
        $ConApply['lab_id']=$UserInfo['lab_id'];
        $ConApply['lab_status']=0;
        $NumInfo['apply']=$UserModel->where($ConApply)->count();
        //获取实验室人员信息
        $ConNum['lab_id']=$UserInfo['lab_id'];
        $ConNum['lab_status']=1;
        $MemberInfo=$UserModel->where($ConNum)->select(); //实验室人员信息
        //获取实验室人员用户ID
        $MemberID=get_lab_user_id($MemberInfo);
        //获取实验室科研成果数量
        $NumInfo['achi_num']=get_lab_achi_num($MemberID);
        //获取实验室科研项目数量
        $NumInfo['project_num']=get_lab_project_num($MemberID);
        //获取实验室人员数量
        $NumInfo['num']=count($MemberInfo);
        //获取不同类别实验室人员信息

        //读取实验室信息
        $LabModel=M('Lab');
        $ConLab['id']=$UserInfo['lab_id'];
        $LabInfo=$LabModel->where($ConLab)->find();
        $this->assign('UserInfo',$UserInfo);
        $this->assign('NumInfo',$NumInfo);
        $this->assign('MemberInfo',$MemberInfo);
        $this->assign('LabInfo',$LabInfo);
        $this->display();
    }

    //显示审核申请页面
    public function check_apply($lab_id){
        parent::is_login();
        $UserModel=M('User');
        $Condition['lab_id']=$lab_id;
        $Condition['lab_status']=0;
        $ApplyInfo=$UserModel->where($Condition)->select();
        $this->assign('ApplyInfo',$ApplyInfo);
        $this->display();
    }

    //审核申请数据库操作
    public function check_apply_db($user_id,$type){
        $UserModel=M('User');
        $Condition['id']=$user_id;
        if($type=='yes'){
            $UserModel->lab_status=1;
        }else if($type=='no'){
            $UserModel->lab_status=2;
        }
        $Result=$UserModel->where($Condition)->save();
        if($Result){
            $this->success('审核操作成功');
        }else{
            $this->error('审核操作失败');
        }
    }

    //显示人员管理页面
    public function member($lab_id){
        parent::is_login();
        $this->display();
    }
}