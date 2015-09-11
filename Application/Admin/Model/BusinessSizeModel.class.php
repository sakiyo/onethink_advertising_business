<?php
# Author: 温开元 <wenkaiyuan.6@163.com 594164084@qq.com>

namespace Admin\Model;
use Think\Model;

class BusinessSizeModel extends Model {
	/* 自动验证规则 */
	protected $_validate = array(
		array('width', 'require', '尺寸宽度必须', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
		array('height', 'require', '尺寸高度必须', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
		array('width', 'number', '尺寸宽度必须为数字', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
		array('height', 'number', '尺寸高度必须为数字', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
		array('business_id', 'require', '业务ID必须', self::MUST_VALIDATE, 'regex', self::MODEL_INSERT),
		array('business_id', 'number', '业务ID必须为数字', self::MUST_VALIDATE, 'regex', self::MODEL_INSERT),
	);

	/* 自动完成规则 */
	protected $_auto = array(
		array('status', 1, self::MODEL_INSERT, 'string'),
	);
}