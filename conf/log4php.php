<?php
return array(
        'rootLogger' => array(
            'appenders' => array('default'),
        ),
        'appenders' => array(
            'default' => array(
                'class' => 'LoggerAppenderFile',
                'layout' => array(
                    'class' => 'LoggerLayoutSimple'
                ),
                'params' => array(
                    'file' => 'cache/web.log',
                    'append' => true
                )
            )
        )
    );//log4php的php配置方式,这个性能更好
?>