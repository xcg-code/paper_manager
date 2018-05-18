<?php
namespace Home\Model;
use Think\Model;
class MonographModel extends Model{
	protected $_validate = array(
		array('title_zh', 'require', '专著题目不能为空'),
		array('language', 'require', '语言选择不能为空'),
		array('isbn', 'require', 'ISBN号不能为空'),
		array('publisher', 'require', '出版社名称不能为空'),
		array('publish_date', 'require', '出版时间不能为空'),
	);
}