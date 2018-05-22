<?php
namespace Home\Model;
use Think\Model;
class MsgRecordModel extends Model{
	protected $_validate = array(
		array('title', 'require', '阶段检查标题不能为空')
	);
}