<?php
//读取文件内容
function smarty_function_openfile($params, $template)
{
	$path = ROOT . '/templates/' . $params['dir'] . $params['name'] . '.html';
	$content = file_get_contents($path);

    return $content;
}
?>