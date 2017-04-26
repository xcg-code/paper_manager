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
        $this->assign('LabInfo',$LabInfo);
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
}