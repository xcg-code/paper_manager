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
                $this->success('上传文档成功，请检查信息是否正确！',__ROOT__.'/index.php/Home/Excel/achi_upload_check/filename/'.$info['savename']);
            }else{
                $this->error('文档上传失败');
            }
        }
    }

    public function achi_upload_check($filename){
        $filename=substr(THINK_PATH, 0,-9).'Uploads/Excel/'.$filename;
        vendor("PHPExcel.PHPExcel");
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));//判断导入表格后缀格式
        
        if ($extension == 'xlsx') {
            $objReader =\PHPExcel_IOFactory::createReader('Excel2007');
            $objPHPExcel =$objReader->load($filename, $encode = 'utf-8');
        } else if ($extension == 'xls'){
            $objReader =\PHPExcel_IOFactory::createReader('Excel5');
            $objPHPExcel =$objReader->load($filename, $encode = 'utf-8');
        }
        $sheet =$objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();//取得总行数
        $highestColumn =$sheet->getHighestColumn(); //取得总列数
        $data_file=array();
        for ($i = 2; $i <= $highestRow; $i++) {
            $data=array();
            $data['title'] =$objPHPExcel->getActiveSheet()->getCell("A" . $i)->getValue();
            $data['achievement_type'] =$objPHPExcel->getActiveSheet()->getCell("B" .$i)->getValue();
            $data['institute_name'] =$objPHPExcel->getActiveSheet()->getCell("C" .$i)->getValue();
            $data['publish_time'] = date('Y-m-d', \PHPExcel_Shared_Date::ExcelToPHP($objPHPExcel->getActiveSheet()->getCell("D" .$i)->getValue()));
            $data_file[]=$data;
        }
        $this->assign('result',$data_file);
        $this->display();
    }
}