<?php
namespace Home\Model;
use Think\Model;
class JournalpaperModel extends Model{
	protected $_validate = array(
		array('title_zh', 'require', '论文标题不能为空'),
		array('journal_name', 'require', '期刊名称不能为空'),
		array('publish_date', 'require', '发表日期不能为空'),
	);
}