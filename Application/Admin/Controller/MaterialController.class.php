<?php
# Author: 温开元<wenkaiyuan.6@163.com 594164084@qq.com>

namespace Admin\Controller;

/**
 * 素材
 * @author 温开元<wenkaiyuan.6@163.com 594164084@qq.com>
 */
class MaterialController extends AdminController {

	/**
	 * 素材列表
	 * @author 温开元<wenkaiyuan.6@163.com 594164084@qq.com>
	 */
	public function index() {
		$title = I('title');
		$map['status'] = array('egt', 0);
		$map['title'] = array('like', '%' . (string) $title . '%');

		$map['business_size_id'] = I('business_size_id');

		$list = $this->lists('Material', $map);
		int_to_string($list);
		type_to_text($list);
		// 记录当前列表页的cookie
		Cookie('__forward__', $_SERVER['REQUEST_URI']);

		$this->assign('_list', $list);
		$this->meta_title = '素材列表';
		$this->display();
	}

	/**
	 * 新增素材
	 * @author 温开元<wenkaiyuan.6@163.com 594164084@qq.com>
	 */
	public function add() {
		if (IS_POST) {
			$Material = D('Material');
			if ($Material->create() !== false) {
				if (!$Material->add()) {
					$this->error('添加素材失败');
				} else {
					$this->success('添加素材成功', U('index', get_http_query_string_array()));
				}
			} else {
				$this->error($Material->getError());
			}
		} else {
			$this->meta_title = '新增素材';
			$this->display('edit');
		}
	}

	/**
	 * 编辑素材
	 * @author 温开元<wenkaiyuan.6@163.com 594164084@qq.com>
	 */
	public function edit($id = 0) {
		if (IS_POST) {
			$Material = D('Material');
			$data = $Material->create();
			if ($data) {
				if ($Material->save()) {
					//记录行为
					// action_log('update_material', 'Material', $data['id'], UID);
					$this->success('更新成功', Cookie('__forward__'));
				} else {
					$this->error('更新失败');
				}
			} else {
				$this->error($Material->getError());
			}
		} else {
			$info = array();
			/* 获取数据 */
			$info = M('Material')->field(true)->find($id);

			if (false === $info) {
				$this->error('获取素材信息错误');
			}
			$this->assign('info', $info);
			$this->meta_title = '编辑素材';
			$this->display();
		}
	}

	/**
	 * 素材状态修改
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
			case 'forbidmaterial':
				$this->forbid('Material', $map);
				break;
			case 'resumematerial':
				$this->resume('Material', $map);
				break;
			case 'deletematerial':
				$this->delete('Material', $map);
				break;
			default:
				$this->error('参数非法');
		}
	}
}