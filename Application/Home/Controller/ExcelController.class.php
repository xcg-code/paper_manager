<?php
namespace Home\Controller;
use Think\Controller;
class ExcelController extends Controller {
    //显示上传文件导入页面
    public function add_achi(){
        parent::is_login();
        $this->display();
    }

    //上传模板文件
    public function upload_file(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     20971520 ;// 设置附件上传大小 20MB
        $upload->exts      =     array('xls','xlsx');// 设置附件上传类型
        $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
        $upload->savePath  =     './Excel/'; // 设置附件上传（子）目录
        $upload->saveName = array('uniqid','');
        $upload->autoSub  = false;
        $info   =   $upload->uploadOne($_FILES['main']);
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功
            $FileInfo['name']=$info['name'];
            $FileInfo['path']=$info['savename'];
            $FileInfo['upload_time']=date("Y-m-d H:i:s");
            $FileModel=M('Excel');
            $Result=$FileModel->add($FileInfo);
            if($Result){
                $this->success('文档上传成功');
            }else{
                $this->error('文档上传失败');
            }
        }
    }
}