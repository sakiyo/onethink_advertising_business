<?php
# Author: 温开元 <wenkaiyuan.6@163.com 594164084@qq.com>

namespace Admin\Model;
use Think\Model;

class MaterialModel extends Model {
	/* 自动验证规则 */
	protected $_validate = array(
	);

	/* 自动完成规则 */
	protected $_auto = array(
		array('status', 1, self::MODEL_INSERT, 'string'),
	);
}