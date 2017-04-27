<?php
namespace Home\Controller;
use Think\Controller;
class FavoriteController extends Controller {
    public function fav_achi(){
        parent::is_login();
        $FavModel=M('Favorite');
        $ConFav['user_id']=session('uid');
        $ConFav['type']='Achievement';
        $FavInfo=$FavModel->field('achievement_id')->where($ConFav)->select();
        //获取对应的详细科研成果信息
        $AchiModel=M('Achievement');
        for($i=0;$i<count($FavInfo);$i++){
            $ConAchi['achievement_id']=$FavInfo[$i]['achievement_id'];
            $AchiInfo=$AchiModel->where($ConAchi)->find();
            $FavInfo[$i]['title']=$AchiInfo['title'];
            $FavInfo[$i]['institute_name']=$AchiInfo['institute_name'];
            $FavInfo[$i]['publish_time']=$AchiInfo['publish_time'];
            $FavInfo[$i]['author']=get_author_list($AchiInfo['achievement_id']);
            $FavInfo[$i]['detail_link']=get_detail_link($AchiInfo);
        }
        $this->assign('FavInfo',$FavInfo);
        $this->display();
    }
}