<?php
set_time_limit(0);
require_once('sun.session.php');
Cron::getInstance()->query_mobile_message_reply();
//龙
?>