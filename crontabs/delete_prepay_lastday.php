<?php
set_time_limit(0);
require_once('sun.session.php');
Cron::getInstance()->delete_prepay_lastday();
//龙,删除两天前未支付的预支付数据
?>