<?php
# Author: �¿�Ԫ<wenkaiyuan.6@163.com 594164084@qq.com>

namespace Admin\Controller;

/**
 * �ߴ�
 * @author �¿�Ԫ<wenkaiyuan.6@163.com 594164084@qq.com>
 */
class BusinessSizeController extends AdminController {

	/**
	 * �ߴ��б�
	 * @author �¿�Ԫ<wenkaiyuan.6@163.com 594164084@qq.com>
	 */
	public function index() {
		$title = I('title');
		$map['status'] = array('egt', 0);
		$map['title'] = array('like', '%' . (string) $title . '%');

		$map['business_id'] = I('business_id');

		$list = $this->lists('BusinessSize', $map);
		int_to_string($list);
		// ��¼��ǰ�б�ҳ��cookie
		Cookie('__forward__', $_SERVER['REQUEST_URI']);

		//�������м
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
		$this->meta_title = '�ߴ��б�';
		$this->display();
	}

	/**
	 * �����ߴ�
	 * @author �¿�Ԫ<wenkaiyuan.6@163.com 594164084@qq.com>
	 */
	public function add() {
		if (IS_POST) {
			$BusinessSize = D('BusinessSize');
			if ($BusinessSize->create() !== false) {
				//ƴ�ӿ��Ϊ��ʾͷ
				if (empty($BusinessSize->title)) {
					$BusinessSize->title = $BusinessSize->width . 'x' . $BusinessSize->height;
				}
				if (!$BusinessSize->add()) {
					$this->error('��ӳߴ�ʧ��');
				} else {
					$this->success('��ӳߴ�ɹ�', U('index', array(
						'business_id' => I('business_id'),
					)));
				}
			} else {
				$this->error($BusinessSize->getError());
			}
		} else {
			$this->meta_title = '�����ߴ�';
			$this->display('edit');
		}
	}

	/**
	 * �༭�ߴ�
	 * @author �¿�Ԫ<wenkaiyuan.6@163.com 594164084@qq.com>
	 */
	public function edit($id = 0) {
		if (IS_POST) {
			$BusinessSize = D('BusinessSize');
			$data = $BusinessSize->create();
			if ($data) {
				//ƴ�ӿ��Ϊ��ʾͷ
				if (empty($BusinessSize->title)) {
					$BusinessSize->title = $BusinessSize->width . 'x' . $BusinessSize->height;
				}
				if ($BusinessSize->save()) {
					//��¼��Ϊ
					// action_log('update_business_size', 'BusinessSize', $data['id'], UID);
					$this->success('���³ɹ�', Cookie('__forward__'));
				} else {
					$this->error('����ʧ��');
				}
			} else {
				$this->error($BusinessSize->getError());
			}
		} else {
			$info = array();
			/* ��ȡ���� */
			$info = M('BusinessSize')->field(true)->find($id);

			if (false === $info) {
				$this->error('��ȡ�ߴ���Ϣ����');
			}
			$this->assign('info', $info);
			$this->meta_title = '�༭�ߴ�';
			$this->display();
		}
	}

	/**
	 * �ߴ�״̬�޸�
	 * @author �¿�Ԫ<wenkaiyuan.6@163.com 594164084@qq.com>
	 */
	public function changeStatus($method = null) {
		$this->changeStatusMine($method, CONTROLLER_NAME);
	}
}