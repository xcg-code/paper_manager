<?php
namespace Home\Model;
use Think\Model;
class JournalpaperModel extends Model{
	protected $_validate=array(
	array('title_zh','require','姓名不能为空')
	);
}