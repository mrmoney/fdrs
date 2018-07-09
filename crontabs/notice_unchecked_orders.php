<?php
set_time_limit(0);
require_once('sun.session.php');
//每隔3小时通知所有相关师傅去审核尺寸单
Cron::getInstance()->notice_unchecked_orders();
//龙
?>