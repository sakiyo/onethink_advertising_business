<?php
# Author: 温开元<wenkaiyuan.6@163.com 594164084@qq.com>

namespace Admin\Controller;

/**
 * 尺寸
 * @author 温开元<wenkaiyuan.6@163.com 594164084@qq.com>
 */
class BusinessSizeController extends AdminController {

	/**
	 * 尺寸列表
	 * @author 温开元<wenkaiyuan.6@163.com 594164084@qq.com>
	 */
	public function index() {
		$title = I('title');
		$map['status'] = array('egt', 0);
		$map['title'] = array('like', '%' . (string) $title . '%');

		$map['business_id'] = I('business_id');

		$list = $this->lists('BusinessSize', $map);
		int_to_string($list);
		// 记录当前列表页的cookie
		Cookie('__forward__', $_SERVER['REQUEST_URI']);

		//生成面包屑
		$business_title = I('business_title');
		if (!empty($usiness_title)) {
			$__crumbs__ = '->' . I('business_title');
			Cookie('__crumbs__', $__crumbs__);
			Cookie('__crumbs_param__', array(
				'business_id' => I('business_id'),
				'business_title' => I('business_title'),
			));
		}

		$this->assign('_list', $list);
		$this->meta_title = '尺寸列表';
		$this->display();
	}

	/**
	 * 新增尺寸
	 * @author 温开元<wenkaiyuan.6@163.com 594164084@qq.com>
	 */
	public function add() {
		if (IS_POST) {
			$BusinessSize = D('BusinessSize');
			if ($BusinessSize->create() !== false) {
				//拼接宽高为显示头
				if (empty($BusinessSize->title)) {
					$BusinessSize->title = $BusinessSize->width . 'x' . $BusinessSize->height;
				}
				if (!$BusinessSize->add()) {
					$this->error('添加尺寸失败');
				} else {
					$this->success('添加尺寸成功', U('index', array(
						'business_id' => I('business_id'),
					)));
				}
			} else {
				$this->error($BusinessSize->getError());
			}
		} else {
			$this->meta_title = '新增尺寸';
			$this->display('edit');
		}
	}

	/**
	 * 编辑尺寸
	 * @author 温开元<wenkaiyuan.6@163.com 594164084@qq.com>
	 */
	public function edit($id = 0) {
		if (IS_POST) {
			$BusinessSize = D('BusinessSize');
			$data = $BusinessSize->create();
			if ($data) {
				//拼接宽高为显示头
				if (empty($BusinessSize->title)) {
					$BusinessSize->title = $BusinessSize->width . 'x' . $BusinessSize->height;
				}
				if ($BusinessSize->save()) {
					//记录行为
					// action_log('update_business_size', 'BusinessSize', $data['id'], UID);
					$this->success('更新成功', Cookie('__forward__'));
				} else {
					$this->error('更新失败');
				}
			} else {
				$this->error($BusinessSize->getError());
			}
		} else {
			$info = array();
			/* 获取数据 */
			$info = M('BusinessSize')->field(true)->find($id);

			if (false === $info) {
				$this->error('获取尺寸信息错误');
			}
			$this->assign('info', $info);
			$this->meta_title = '编辑尺寸';
			$this->display();
		}
	}

	/**
	 * 尺寸状态修改
	 * @author 温开元<wenkaiyuan.6@163.com 594164084@qq.com>
	 */
	public function changeStatus($method = null) {
		$this->changeStatusMine($method, CONTROLLER_NAME);
	}
}