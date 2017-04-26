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
        if($LabModel->create()){
            $LabModel->holder_id=session('uid');
            $LabModel->holder=session('fullname');
            $Result=$LabModel->add();
            if($Result){
                $this->success('创建实验室成功',__ROOT__.'/index.php/Home/Lab/my_lab');
            }else{
                $this->error($LabModel->getError());
            }
        }else{
            $this->error($LabModel->getError());
        }
    }
}