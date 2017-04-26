<?php
namespace Home\Controller;
use Think\Controller;
class LabController extends Controller {
    public function lab_apply(){
    	parent::is_login();
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
}