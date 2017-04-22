<?php
namespace Home\Model;
use Think\Model;
class ConferencepaperModel extends Model{
	protected $_validate=array(
	array('title_zh','require','论文标题不能为空'),
	array('type','require','类型不能为空'),
	array('conference_name','require','会议名称不能为空'),
	array('conference_address','require','会议地址不能为空'),
	array('organizer','require','会议组织者不能为空'),
	array('start_date','require','会议开始日期不能为空'),
	array('end_date','require','会议结束日期不能为空'),
	array('publish_date','require','论文发表日期不能为空'),
	array('start_page','require','论文开始页码不能为空'),
	array('end_page','require','论文结束页码不能为空'),
	array('sub_type','require','论文类型不能为空'),
	array('country','require','国家和地区不能为空'),
	array('city','require','城市不能为空')
	);
}