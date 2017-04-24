<?php
namespace Home\Controller;
use Think\Controller;
class ProjectController extends Controller {
	public function my_project(){
		parent::is_login();
		$this->display();
	}
}