<?php
# Author: 温开元 <wenkaiyuan.6@163.com 594164084@qq.com>

namespace Admin\Model;
use Think\Model;

class MaterialModel extends Model {

	protected function _initialize() {
		array_push($this->$_auto, array('business_size_id', I('business_size_id'), self::MODEL_BOTH, 'int'));
	}

	/* 自动验证规则 */
	protected $_validate = array(
		array('title', 'require', '素材名称必须', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
		array('sort', '0,255', '必须在0-255范围内', self::MUST_VALIDATE, 'between', self::MODEL_BOTH),
		array('material_type', '/^[1-5]{1}$/', '请选择素材类型', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
	);

	/* 自动完成规则 */
	protected $_auto = array(
		array('status', 1, self::MODEL_INSERT, 'string'),
	);
}