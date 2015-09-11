<?php
# Author: 温开元<wenkaiyuan.6@163.com 594164084@qq.com>

namespace Admin\Controller;

/**
 * 业务
 * @author 温开元<wenkaiyuan.6@163.com 594164084@qq.com>
 */
class BusinessController extends AdminController {

	/**
	 * 业务列表
	 * @author 温开元<wenkaiyuan.6@163.com 594164084@qq.com>
	 */
	public function index() {
		$title = I('title');
		$map['status'] = array('egt', 0);
		$map['title'] = array('like', '%' . (string) $title . '%');

		if (!is_administrator()) {
			$map['belong_member_id'] = is_login();
		}

		$list = $this->lists('Business', $map);
		int_to_string($list);
		// 记录当前列表页的cookie
		Cookie('__forward__', $_SERVER['REQUEST_URI']);

		$this->assign('_list', $list);
		$this->meta_title = '业务列表';
		$this->display();
	}

	/**
	 * 新增业务
	 * @author 温开元<wenkaiyuan.6@163.com 594164084@qq.com>
	 */
	public function add() {
		if (IS_POST) {
			$Business = D('Business');
			if ($Business->create() !== false) {
				$Business->belong_member_id = is_login();
				if (!$Business->add()) {
					$this->error('添加业务失败');
				} else {
					$this->success('添加业务成功', U('index'));
				}
			} else {
				$this->error($Business->getError());
			}
		} else {
			$this->meta_title = '新增业务';
			$this->display('edit');
		}
	}

	/**
	 * 编辑业务
	 * @author 温开元<wenkaiyuan.6@163.com 594164084@qq.com>
	 */
	public function edit($id = 0) {
		if (IS_POST) {
			$Business = D('Business');
			$data = $Business->create();
			if ($data) {
				if ($Business->save()) {
					//记录行为
					// action_log('update_business', 'business', $data['id'], UID);
					$this->success('更新成功', Cookie('__forward__'));
				} else {
					$this->error('更新失败');
				}
			} else {
				$this->error($Business->getError());
			}
		} else {
			$info = array();
			/* 获取数据 */
			$info = M('Business')->field(true)->find($id);

			if (false === $info) {
				$this->error('获取业务信息错误');
			}
			$this->assign('info', $info);
			$this->meta_title = '编辑业务';
			$this->display();
		}
	}

	/**
	 * 业务状态修改
	 * @author 温开元<wenkaiyuan.6@163.com 594164084@qq.com>
	 */
	public function changeStatus($method = null) {
		$id = array_unique((array) I('id', 0));
		$id = is_array($id) ? implode(',', $id) : $id;
		if (empty($id)) {
			$this->error('请选择要操作的数据!');
		}
		$map['id'] = array('in', $id);
		switch (strtolower($method)) {
			case 'forbidbusiness':
				$this->forbid('Business', $map);
				break;
			case 'resumebusiness':
				$this->resume('Business', $map);
				break;
			case 'deletebusiness':
				$this->delete('Business', $map);
				break;
			default:
				$this->error('参数非法');
		}
	}
}