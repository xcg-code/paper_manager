<?php
namespace Home\Model;
use Think\Model;
class ContributionsModel extends Model{
	protected $_validate=array(
		array('type','require','稿件类别不能为空'),
		array('name','require','稿件名称不能为空'),
		array('filePath','require','未上传稿件'),
	);
}