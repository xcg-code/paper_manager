<?php

	namespace Home\Controller;

	use Think\Controller;
	class IndexController extends Controller
	{
		public function index($type = "login")
		{
			if ($_SESSION['uid'] != null) {
				$this->redirect('/Home/Profile/profile');
				return;
			}
			$this->assign('type', $type);
			$this->display();
		}

		public function register()
		{
			$UserInfo = D('User');
			if ($UserInfo->create()) {
				$password = $UserInfo->password;
				$UserInfo->password = md5($password);
				$password1 = $_POST['password2'];
				if ($password != $password1) {
					$this->error('密码不一致，请重新注册', __ROOT__ . '/index.php/Home/index.html?type=register');
				}
				$result = $UserInfo->add();

				if ($result) {
					$this->success('注册成功，返回登录页面', __ROOT__ . '/index.php/Home/');
				} else {
					$this->error($UserInfo->getError(), __ROOT__ . '/index.php/Home/index.html?type=register');
				}
			} else {
				$this->error($UserInfo->getError(), __ROOT__ . '/index.php/Home/index.html?type=register');
			}
		}

		public function login()
		{
			session_destroy();
			session_start();
			$login = D('User');
			$user_number = $_POST["userNumber"];
			$pwd = md5($_POST["password"]);
			$condition = array(
				'user_number' => $user_number,
				'password' => $pwd
			);
			$data = $login->where($condition)->find();
			if ($data) {
				session('user', $data);
				session('uid', $data['id']);
				session('userNum', $data['user_number']);
				session('name', $data['user_name']);
				session('position', $data['position']);
				if ($data['position'] == 0) {//管理员角色
					session('sidebar_path', "./Public/tpl/navbar3.html");
				} else if ($data['position'] == 1) {//教师角色
					session('sidebar_path', "./Public/tpl/navbar.html");
				} else if ($data['position'] == 2) {//学生角色
					session('sidebar_path', "./Public/tpl/navbar2.html");
				}
				$this->redirect('/Home/Profile/profile');
			} else {
				$this->error('登录失败，用户名或密码错误');
			}
		}

		public function logout()
		{
			session_destroy();
			$this->success('登出成功，请重新登录！', __ROOT__);
		}

		public function changePwd()
		{
			$newPwd = $_POST["newPassword"];
			$newPwd2 = $_POST['newPassword2'];
			if ($newPwd != $newPwd2) {
				$this->error('密码不一致');
			}
			$user = D('User');
			$user->password = md5($newPwd);
			$condition['id'] = session('uid');
			if ($user->where($condition)->save()) {
				$this->success('修改成功，请重新登录！', __ROOT__);
			}
		}
	}