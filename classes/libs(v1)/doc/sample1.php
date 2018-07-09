<?php
require_once('config.inc.php');
require_once('clsMsDocGenerator.php');
$titleFormat = array(
				'text-align'         => 'center',
				'font-weight'         => 'bold',
				'font-size'                => '18pt',
				'color'                        => 'blue');
$doc = new clsMsDocGenerator();

$doc->addParagraph('是的吧', $titleFormat);
$doc->addParagraph('this is the first paragraph');
$doc->addParagraph('this is the paragraph in justified style', array('text-align' => 'justify'));
$doc->output('doc1.doc');
//龙
?>