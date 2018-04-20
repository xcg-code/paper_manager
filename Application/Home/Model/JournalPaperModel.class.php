<?php
namespace Home\Model;
use Think\Model;
class JournalPaperModel extends Model{
	protected $_validate=array(
	array('title_zh','require','论文标题不能为空')
	);
}