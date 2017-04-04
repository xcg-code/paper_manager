<?php
namespace Home\Model;
use Think\Model;
class UserModel extends Model{
	protected $_validate=array(
	array('fullname','require','姓名不能为空'),
	array('username','require','用户名不能为空'),
	array('password','require','密码不能为空'),
	array('email','require','电子邮件地址不能为空'),
	array('username',',','该用户名已经存在！',1,'unique',1),
	);
}