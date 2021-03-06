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

    //显示待导入数据
    public function achi_upload_check($filename){
        $filepath=substr(THINK_PATH, 0,-9).'Uploads/Excel/'.$filename;
        vendor("PHPExcel.PHPExcel");
        $extension = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));//判断导入表格后缀格式
        
        if ($extension == 'xlsx') {
            $objReader =\PHPExcel_IOFactory::createReader('Excel2007');
            $objPHPExcel =$objReader->load($filepath, $encode = 'utf-8');
        } else if ($extension == 'xls'){
            $objReader =\PHPExcel_IOFactory::createReader('Excel5');
            $objPHPExcel =$objReader->load($filepath, $encode = 'utf-8');
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
        $this->assign('filename',$filename);
        $this->display();
    }

    //批量导入数据库操作
    public function add_achi_db($filename){
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

        //获取Excel数据完成，开始批量添加
        $user_id=session('uid'); //获取用户ID

        for ($i=0; $i < count($data_file); $i++) {
            //生成科研成果ID
            $uniq_id=uniqid(); 
            //科研成果类型参数
            $achi_type='';
            switch ($data_file[$i]['achievement_type']) {
                case '期刊论文':
                $this->JournalPaper($data_file[$i],$user_id,$uniq_id);
                $achi_type='JournalPaper';
                break;
                case '会议论文':
                $this->ConferencePaper($data_file[$i],$user_id,$uniq_id);
                $achi_type='ConferencePaper';
                break;
                case '学术专著':
                $this->Monograph($data_file[$i],$user_id,$uniq_id);
                $achi_type='Monograph';
                break;
                case '专利':
                $this->Patent($data_file[$i],$user_id,$uniq_id);
                $achi_type='Patent';
                break;
                case '会议报告':
                $this->ConferenceReport($data_file[$i],$user_id,$uniq_id);
                $achi_type='ConferenceReport';
                break;
                case '标准':
                $this->Standard($data_file[$i],$user_id,$uniq_id);
                $achi_type='Standard';
                break;
                case '软件著作权':
                $this->Software($data_file[$i],$user_id,$uniq_id);
                $achi_type='Software';
                break;
                case '科研奖励':
                $this->Reward($data_file[$i],$user_id,$uniq_id);
                $achi_type='Reward';
                break;
                case '人才培养':
                $this->Train($data_file[$i],$user_id,$uniq_id);
                $achi_type='Train';
                break;
                case '举办或参加学术会议':
                $this->ConferenceInvolved($data_file[$i],$user_id,$uniq_id);
                $achi_type='ConferenceInvolved';
                break;
                case '成果技术转移':
                $this->TechTrans($data_file[$i],$user_id,$uniq_id);
                $achi_type='TechTrans';
                break;
                case '其他重要研究成果':
                $this->OtherAchievement($data_file[$i],$user_id,$uniq_id);
                $achi_type='OtherAchievement';
                break;
                
                default:
                break;
            }
            //添加科研成果汇总表
            $this->add_all_achi($data_file[$i],$user_id,$uniq_id,$achi_type);
        }
        $this->success('科研成果批量导入成功',__ROOT__.'/index.php/Home/Achievement/my_achievement');
    }

    //导入科研成果汇总表
    public function add_all_achi($data,$user_id,$uniq_id,$achi_type){
        $AchievementModel=D('Achievement');
        $AchievementModel->achievement_id=$uniq_id;
        $AchievementModel->user_id=$user_id;
        $AchievementModel->achievement_type=$achi_type;
        $AchievementModel->title=$data['title'];
        $AchievementModel->institute_name=$data['institute_name'];
        $AchievementModel->publish_time=$data['publish_time'];
        $AchievementModel->add();
    }

    //导入期刊论文
    public function JournalPaper($data,$user_id,$uniq_id){
        $JournalModel=D('Journalpaper');
        $JournalModel->user_id=$user_id;
        $JournalModel->id=$uniq_id;
        $JournalModel->title_zh=$data['title'];
        $JournalModel->publish_date=$data['publish_time'];
        $JournalModel->journal_name=$data['institute_name'];
        $JournalModel->add();
    }

    public function ConferencePaper($data,$user_id,$uniq_id){
        $ConferenceModel=D('Conferencepaper');
        $ConferenceModel->user_id=$user_id;
        $ConferenceModel->id=$uniq_id;
        $ConferenceModel->title_zh=$data['title'];
        $ConferenceModel->publish_date=$data['publish_time'];
        $ConferenceModel->conference_name=$data['institute_name'];
        $ConferenceModel->add();
    }

    public function Monograph($data,$user_id,$uniq_id){
        $MonographModel=D('Monograph');
        $MonographModel->user_id=$user_id;
        $MonographModel->id=$uniq_id;
        $MonographModel->title_zh=$data['title'];
        $MonographModel->publish_date=$data['publish_time'];
        $MonographModel->publisher=$data['institute_name'];
        $MonographModel->add();
    }

    public function Patent($data,$user_id,$uniq_id){
        $PatentModel=D('Patent');
        $PatentModel->user_id=$user_id;
        $PatentModel->id=$uniq_id;
        $PatentModel->title_zh=$data['title'];
        $PatentModel->apply_date=$data['publish_time'];
        $PatentModel->publisher=$data['institute_name'];
        $PatentModel->add();
    }

    public function ConferenceReport($data,$user_id,$uniq_id){
        $ConferencereportModel=D('Conferencereport');
        $ConferencereportModel->user_id=$user_id;
        $ConferencereportModel->id=$uniq_id;
        $ConferencereportModel->title_zh=$data['title'];
        $ConferencereportModel->start_date=$data['publish_time'];
        $ConferencereportModel->conference_zh=$data['institute_name'];
        $ConferencereportModel->add();
    }

    public function Standard($data,$user_id,$uniq_id){
        $StandardModel=D('Standard');
        $StandardModel->user_id=$user_id;
        $StandardModel->id=$uniq_id;
        $StandardModel->title_zh=$data['title'];
        $StandardModel->publish_date=$data['publish_time'];
        $StandardModel->institute=$data['institute_name'];
        $StandardModel->add();

    }

    public function Software($data,$user_id,$uniq_id){
        $SoftwareModel=D('Software');
        $SoftwareModel->user_id=$user_id;
        $SoftwareModel->id=$uniq_id;
        $SoftwareModel->title_zh=$data['title'];
        $SoftwareModel->over_date=$data['publish_time'];
        $SoftwareModel->reg_num=$data['institute_name'];
        $SoftwareModel->add();
    }

    public function Reward($data,$user_id,$uniq_id){
        $RewardModel=D('Reward');
        $RewardModel->user_id=$user_id;
        $RewardModel->id=$uniq_id;
        $RewardModel->title_zh=$data['title'];
        $RewardModel->publish_date=$data['publish_time'];
        $RewardModel->institute=$data['institute_name'];
        $RewardModel->add();
    }

    public function Train($data,$user_id,$uniq_id){
        var_dump($uniq_id);
    }

    public function ConferenceInvolved($data,$user_id,$uniq_id){
        $ConModel=D('Conferenceinvolved');
        $ConModel->user_id=$user_id;
        $ConModel->id=$uniq_id;
        $ConModel->title_zh=$data['title'];
        $ConModel->start_date=$data['publish_time'];
        $ConModel->institute=$data['institute_name'];
        $ConModel->add();
    }

    public function TechTrans($data,$user_id,$uniq_id){
        var_dump($uniq_id);
    }

    public function OtherAchievement($data,$user_id,$uniq_id){
        var_dump($uniq_id);
    }

    //导出我的科研成果信息
    public function achi_export($achi_type='',$achi_year='',$user_id=''){
        $AchievementModel=M('Achievement');
        if($user_id==''){
            $Condition['user_id']=session('uid');
        }else{
            $Condition['user_id']=$user_id;
        }
        $SearchAction='/';
        if($achi_type!=''){
            $Condition['achievement_type']=$achi_type;
            $SearchAction=$SearchAction.'achi_type/'.$achi_type;   
        }
        if($achi_year!=''){
            $start_date=$achi_year.'-01-01';
            $end_date=$achi_year.'-12-31';
            $Condition['publish_time']=array(array('egt',$start_date),array('elt',$end_date));
            $SearchAction=$SearchAction.'achi_year/'.$achi_year;
        }
        //从session获取搜索栏内容
        $Search=I('post.search');
        $Condition['title']=array('like','%'.$Search.'%');
        //数据获取
        $AchievementInfo=$AchievementModel->field('title,achievement_type,institute_name,publish_time')->where($Condition)->order('publish_time desc')->select();
        
        //数据导出
        $this->out($AchievementInfo);
    }

    public function out($AchievementInfo){
        //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
        vendor("PHPExcel.PHPExcel");

        $filename="ImportFile";
        $headArr=array("科研成果名称","科研成果类型","期刊名称(会议名称，发表机构)","发表时间");
        $this->getExcel($filename,$headArr,$AchievementInfo);
    }

    private function getExcel($fileName,$headArr,$data){
            //对数据进行检验
        if(empty($data) || !is_array($data)){
            die("data must be a array");
        }
            //检查文件名
        if(empty($fileName)){
            exit;
        }

        $date = date("Y_m_d",time());
        $fileName .= "_{$date}.xls";

            //创建PHPExcel对象，注意，不能少了\
        $objPHPExcel = new \PHPExcel();
        $objProps = $objPHPExcel->getProperties();

            //设置表头
        $key = ord("A");
        foreach($headArr as $v){
            $colum = chr($key);
            $objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'1', $v);
            $key += 1;
        }

        $column = 2;
        $objActSheet = $objPHPExcel->getActiveSheet();
            foreach($data as $key => $rows){ //行写入
                $span = ord("A");
                foreach($rows as $keyName=>$value){// 列写入
                    $j = chr($span);
                    $objActSheet->setCellValue($j.$column, $value);
                    $span++;
                }
                $column++;
            }

            $fileName = iconv("utf-8", "gb2312", $fileName);
            //重命名表
            // $objPHPExcel->getActiveSheet()->setTitle('test');
            //设置活动单指数到第一个表,所以Excel打开这是第一个表
            $objPHPExcel->setActiveSheetIndex(0);
            header('Content-Type: application/vnd.ms-excel');
            header("Content-Disposition: attachment;filename=\"$fileName\"");
            header('Cache-Control: max-age=0');

            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output'); //文件通过浏览器下载
            exit;
        }

    //导出科研项目信息
        public function project_export($project_type=''){
        //获取项目类别信息
            $TypeModel=M('Project_type');
            $TypeInfo=$TypeModel->select();
        //获取检索条件
            $ProjectModel=M('Project');
			$Condition['user_number'] = session('userNum');
			$Condition['status']=1;
            if($project_type!=''){
                for($i=0;$i<count($TypeInfo);$i++){
                    if($project_type==$TypeInfo[$i]['id']){
                        $Condition['type']=$TypeInfo[$i]['type_name'];
                        break;
                    }
                }  
            }
        //获取待导出科研项目信息
            $ProjectInfo=$ProjectModel->join('INNER JOIN think_project_member ON think_project.id=think_project_member.project_id')
				->field('type,project_name,think_project.project_num,owner,institute,money,content')
				->where($Condition)
				->select();
        //导出数据操作
        //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
            vendor("PHPExcel.PHPExcel");

            $fileName="ImportFile";
            $headArr=array("科研项目类别","科研项目名称","科研项目号","负责人","依托单位","项目资金(万元)","备注");
            //对数据进行检验
            if(empty($ProjectInfo) || !is_array($ProjectInfo)){
                die("data must be a array");
            }
            //检查文件名
            if(empty($fileName)){
                exit;
            }

            $date = date("Y_m_d",time());
            $fileName .= "_{$date}.xls";

            //创建PHPExcel对象，注意，不能少了\
            $objPHPExcel = new \PHPExcel();
            $objProps = $objPHPExcel->getProperties();

            //设置表头
            $key = ord("A");
            foreach($headArr as $v){
                $colum = chr($key);
                $objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'1', $v);
                $key += 1;
            }

            $column = 2;
            $objActSheet = $objPHPExcel->getActiveSheet();
            foreach($ProjectInfo as $key => $rows){ //行写入
                $span = ord("A");
                foreach($rows as $keyName=>$value){// 列写入
                    $j = chr($span);
                    $objActSheet->setCellValue($j.$column, $value);
                    $span++;
                }
                $column++;
            }

            $fileName = iconv("utf-8", "gb2312", $fileName);
            //重命名表
            // $objPHPExcel->getActiveSheet()->setTitle('test');
            //设置活动单指数到第一个表,所以Excel打开这是第一个表
            $objPHPExcel->setActiveSheetIndex(0);
            header('Content-Type: application/vnd.ms-excel');
            header("Content-Disposition: attachment;filename=\"$fileName\"");
            header('Cache-Control: max-age=0');

            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output'); //文件通过浏览器下载
            exit;
        }

    //导出某一科研项目下所有科研成果信息
    public function project_achi_export($id,$achi_type='',$achi_year=''){
        //获取项目下的科研成果信息
        $AchievementModel=M('Achievement');
        //获取项目信息
        $Condition['project_id']=$id;
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

        $AchievementInfo=$AchievementModel->field('title,achievement_type,institute_name,publish_time')->where($Condition)->order('publish_time desc')->select();
        $this->out($AchievementInfo);
    }
}