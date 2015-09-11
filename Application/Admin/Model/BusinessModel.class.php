<?php
# Author: 温开元 <wenkaiyuan.6@163.com 594164084@qq.com>

namespace Admin\Model;
use Think\Model;

class BusinessModel extends Model {
	/* 自动验证规则 */
	protected $_validate = array(
		array('title', 'require', '业务名称必须', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
		// array('title', '', '业务名称已经存在', self::MUST_VALIDATE, 'unique', self::MODEL_BOTH),
		// array('description', 'require', '描述不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
		array('description', '0,255', '描述不能超过255个字符', self::MUST_VALIDATE, 'length', self::MODEL_BOTH),
		// array('remark', 'require', '备注不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
		array('remark', '0,255', '备注不能超过255个字符', self::MUST_VALIDATE, 'length', self::MODEL_BOTH),
	);

	/* 自动完成规则 */
	protected $_auto = array(
		array('status', 1, self::MODEL_INSERT, 'string'),
	);
}