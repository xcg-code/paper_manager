<?php
namespace Home\Model;
use Think\Model;
class ConferencepaperModel extends Model{
	protected $_validate = array(
		array('title_zh', 'require', '论文标题不能为空'),
		array('type', 'require', '会议论文类型不能为空'),
		array('conference_name', 'require', '会议名称不能为空'),
		array('start_date', 'require', '会议开始时间不能为空'),
		array('end_date', 'require', '会议结束时间不能为空'),
		array('publish_date', 'require', '发表日期不能为空'),
	);
}