<?php
//将价格转换成中文人民币格式
function smarty_function_cnrmb($params, $template)
{
    $money = (isset($params['money'])) ? $params['money'] : 0;
	$cn_rmb = Util::chinese_rmb($money);
    return $cn_rmb;
}
?>