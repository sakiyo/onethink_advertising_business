<?php
# Author: 温开元<wenkaiyuan.6@163.com 594164084@qq.com>

namespace Admin\Controller;

/**
 * 素材
 * @author 温开元<wenkaiyuan.6@163.com 594164084@qq.com>
 */
class MaterialController extends AdminController {

	/* MaterialType 对应不同的处理方法 */
	private $saveFun = array(
		1 => 'savePicAd',
		2 => 'saveCodeAd',
		3 => 'saveVideoAd',
		4 => 'saveIframeAd',
		5 => 'saveHtmlAd',
	);

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

		//生成面包屑
		$business_title = I('business_title');
		$business_size_title = I('business_size_title');
		if (!empty($business_title) && !empty($business_size_title)) {
			$__crumbs__ = '->' . $business_title . '->' . $business_size_title;
			Cookie('__crumbs__', $__crumbs__);
		}

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
				/* 先取出type值 */
				$material_type = $Material->material_type;

				if (!$Material->add()) {
					$this->error('添加素材失败');
				} else {
					/* 处理属性 */
					# TODO

					$this->success('添加素材成功', U('index', array('business_size_id' => I('business_size_id'))));
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
					// 记录行为
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

			/* 对属性的处理 */
			# TODO
			if (isset($this->saveFun[$info['material_type']])) {
				$fun = $this->saveFun[$info['material_type']];
				$this->$fun($info);
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
		$this->changeStatusMine($method, CONTROLLER_NAME);
	}

	private function savePicAd(&$info) {
		$attribute = json_decode($info['attribute'], true);
		$info_tag_1 = array(
		);
	}
	private function saveCodeAd() {}
	private function saveVideoAd() {}
	private function saveIframeAd() {}
	private function saveHtmlAd() {}

}