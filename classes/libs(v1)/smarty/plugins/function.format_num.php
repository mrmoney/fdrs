<?php
function smarty_function_format_num($params, $template)
{
    $num = sprintf($params['format'],$params['num']);
    return $num;
}
?>