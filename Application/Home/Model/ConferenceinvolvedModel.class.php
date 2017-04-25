<?php
namespace Home\Model;
use Think\Model;
class ConferencepaperModel extends Model{
	protected $_validate=array(
	array('title_zh','require','会议名称不能为空')
	);
}