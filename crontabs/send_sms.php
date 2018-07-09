<?php
set_time_limit(0);
require_once('sun.session.php');
Cron::getInstance()->send_sms();
//龙
?>