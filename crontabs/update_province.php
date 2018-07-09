<?php
set_time_limit(0);
require_once('sun.session.php');
Cron::getInstance()->update_province_for_customer();
//龙
?>