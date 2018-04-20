<?php

	namespace Home\Controller;

	use Think\Controller;

	class JournalPaperController extends Controller
	{
		//添加期刊论文数据库操作
		public function journal_paper_add_db()
		{
			$JournalModel = D('Journalpaper');
			$id = session("uid");
			if ($JournalModel->create()) {
				$JournalModel->user_id = $id;
				$uniq_id = uniqid();
				$JournalModel->id = $uniq_id;
				$Inclu = '';//收录情况
				foreach ($JournalModel->inbox_status as $value) {
					$Inclu = $Inclu . $value . ';';
				}
				$JournalModel->inbox_status = $Inclu;
				$result = $JournalModel->add();
				if ($result) {
					$this->success('数据添加成功！');
				} else {
					$this->error('数据添加错误！');
				}
			} else {
				$this->error($JournalModel->getError());
			}
		}

	}