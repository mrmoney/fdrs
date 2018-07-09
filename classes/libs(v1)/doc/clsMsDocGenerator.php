<?php
/**
 * Usage Example:
 * $doc = new clsMsDocGenerator();
 * $doc->addParagraph('this is the first paragraph');
 * $doc->addParagraph('this is the paragraph in justified style', array('text-align' => 'justify'));
 * $doc->output();
 *
 */
class clsMsDocGenerator
{
        var $appName = 'MsDocGenerator';
        var $appVersion = '0.2';

        var $leftMargin = 1.0;
        var $rightMargin = 1.0;
        var $topMargin = 3.0;
        var $bottomMargin = 3.0;

        var $documentBuffer;
        var $formatBuffer;
        var $cssFile;
        var $lastSessionNumber;
        var $lastPageNumber;
        var $atualPageWidth;

        var $tableIsOpen;
        var $tableLastRow;

        /**
         * constructor clsMsDocGenerator(const $pageOrientation = 'PORTRAIT', const $pageType = 'A4',  string $cssFile = '')
         * @param $pageOrientation: The orientation of the pages of the initial session, 'PORTRAIT' or 'LANDSCAPE'
         * @param $pageType: The initial type of the paper of the pages of the session
         * @param $cssFile: extra file with formating configurations, in css file format
         */
        function clsMsDocGenerator($pageOrientation = 'PORTRAIT', $pageType = 'A4', $cssFile = ''){
                $this->documentBuffer = '';
                $this->formatBuffer = '';
                $this->cssFile = $cssFile;
                $this->lastSessionNumber = 0;
                $this->lastPageNumber = 0;
                $this->atualPageWidth = 0;

                $this->tableIsOpen = false;
                $this->tableLastRow = 0;

                $this->newSession($pageOrientation, $pageType);
                $this->newPage();
        }//end clsMsDocGenerator()

        /**
         * public int newSession(const $pageOrientation = 'PORTRAIT', const $pageType = 'A4')
         * @param $pageOrientation: The orientation of the pages of the session, 'PORTRAIT' or 'LANDSCAPE'
         * @param $pageType: The type of the paper of the pages of the session
         * @return int: the number of the new session
         */
        function newSession($pageOrientation = 'PORTRAIT', $pageType = 'A4'){
                $this->lastSessionNumber++;

                if($this->lastSessionNumber != 1){
                        $this->endSession();
                        $this->documentBuffer .= "<br clear=all style='page-break-before:always; mso-break-type:section-break'>\n";
                }

                $this->atualPageWidth = constant($pageType . '_WIDTH');

                $sessionName = "Section" . $this->lastSessionNumber;

                $pageSize = constant($pageType . '_' . $pageOrientation . '_SIZE');
                $pageMargins = constant($pageType . '_' . $pageOrientation . '_MARGIN');

                $this->formatBuffer .= "@page $sessionName\n";
                $this->formatBuffer .= "   {size: $pageSize;\n";
                $this->formatBuffer .= "   margin: $pageMargins;\n";
                $this->formatBuffer .= "   mso-header-margin: 36pt;\n";
                $this->formatBuffer .= "   mso-footer-margin: 36pt;\n";
                $this->formatBuffer .= "   mso-paper-source: 0;}\n";
                $this->formatBuffer .= "div.$sessionName\n";
                $this->formatBuffer .= "  {page: $sessionName;}\n\n";

                $this->documentBuffer .= "<div class=$sessionName>\n";

                return $this->lastSessionNumber;
        }//end newSession()

        /**
         * public int newPage(void)
         * @return int: the number of the new page
         */
        function newPage(){
                $this->lastPageNumber++;
                if($this->lastPageNumber != 1)
                        $this->documentBuffer .= "<br clear=all style='page-break-before:always;'>";
                return $this->lastPageNumber;
        }//end newPage()

        /**
         * public void output(void)
         */
        function output($WoreName)
		{
			$this->endSession();
			header('Content-Type: application/msword; charset=utf-8');
			header ("Content-Disposition: attachment; filename=$WoreName" );  //保存文件名称
			echo '<html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"' . "\n";
			echo '   xmlns:w="urn:schemas-microsoft-com:office:word"' . "\n";
			echo '   xmlns="http://www.w3.org/TR/REC-html40">' . "\n";
			$this->outputHeader();
			$this->outputBody();
			echo '</html>' . "\n";
        }

        /**
         * public void addParagraph(string $content, array $inlineStyle = NULL, string $className = 'normalText')
         * @param $content: content of the paragraph
         * @param $inlineStyle: array of css block properties
         * #param $className: class name of any class defined in extra format file
         */
        function addParagraph($content, $inlineStyle = NULL, $className = 'normalText'){
                $style = '';
                if(is_array($inlineStyle)){
                        foreach($inlineStyle as $key => $value)
                                $style .= "$key: $value;";
                }
                $this->documentBuffer .= "<p class=$className" . ($style != '' ? " style='$style'" : '') . ">".($content == '' ? '<o:p></o:p>' : $content)."</p>\n";
        }//end addParagraph()

        /**
         * public void startTable(array $inlineStyle = NULL, string $className = 'normalTable')
         * @param $inlineStyle: array of css table properties, property => value
         * @param $className: class name of any class defined in extra format file
         */
        function startTable($inlineStyle = NULL, $className = 'normalTable'){
                $style = 'border-collapse:collapse;border:none;mso-border-alt:solid windowtext '.BORDER_ALT.'pt;';
                $style .= 'mso-yfti-tbllook:480;mso-padding-alt:0cm '.PADDING_ALT_RIGHT.'pt 0cm '.PADDING_ALT_LEFT.'pt;';
                $style .= 'mso-border-insideh:'.BORDER_INSIDEH.'pt solid windowtext;mso-border-insidev:'.BORDER_INSIDEV.'pt solid windowtext;';
                if(is_array($inlineStyle)){
                        foreach($inlineStyle as $key => $value)
                                $style .= "$key: $value;";
                }
                $this->documentBuffer .= "<table class=$className style='$style' border='0' cellspacing='0' cellpadding='0'>\n";

                $this->tableIsOpen = true;
        }//end startTable()

        /**
         * public int addTableRow(array $cells, array $aligns = NULL, array $vAligns = NULL, array $inlineStyle = NULL, array $classesName = NULL)
         * @param $cells: array with content of cells of the row
         * @param $aligns: array with align cell constants in html style, a item for each cell item
         * @param $vAligns: array with valign cell constants in html style, a item for each cell item
        * @param $inlineStyle: array of css block properties, property => value
        * @param $classesName: array with class name of any class defined in extra format file, a item for each cell item
         */
        function addTableRow($cells, $aligns = NULL, $vAligns = NULL, $inlineStyle = NULL, $classesName = NULL,$colspan=NULL){
                if(! $this->tableIsOpen)
                        die('ERROR: TABLE IS NOT STARTED');

                if(is_array($classesName) && count($classesName) != count($cells))
                        die('ERROR: COUNT OF CLASSES IS DIFERENT OF COUNT OF CELLS');
                if(is_array($aligns) && count($aligns) != count($cells))
                        die('ERROR: COUNT OF ALIGNS IS DIFERENT OF COUNT OF CELLS');
                if(is_array($vAligns) && count($vAligns) != count($cells))
                        die('ERROR: COUNT OF VALIGNS IS DIFERENT OF COUNT OF CELLS');

                $style = 'border:solid windowtext 1.0pt;border-left:none;mso-border-left-alt:solid windowtext .5pt;';
                $style = 'mso-border-alt: solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;';
                if(is_array($inlineStyle)){
                        foreach($inlineStyle as $key => $value)
                                $style .= "$key: $value;";
                }

                $tableWidth = $this->atualPageWidth * Um_Cent;// - ($this->leftMargin * Um_Cent + $this->rightMargin * Um_Cent);
                //$tableWidth -= (BORDER_ALT*2 + PADDING_ALT_RIGHT + PADDING_ALT_LEFT + BORDER_INSIDEH*2 + BORDER_INSIDEV*2);
                $cellWidth = floor($tableWidth / count($cells));


                $this->documentBuffer .= "<tr style='mso-yfti-irow: $this->tableLastRow'>\n";
                for($i = 0; $i < count($cells); $i++){
                        $align = is_array($aligns) ? $aligns[$i] : 'left';
                        $vAlign = is_array($vAligns) ? $vAligns[$i] : 'top';
                        $className = is_array($classesName) ? " class=$classesName[$i]" : '';

                        $this->documentBuffer .= "<td width=$cellWidth align=$align valign=$vAlign style='$style' ".($className != '' ? " class=$className" : '').">$cells[$i]</td>\n";
                }
                $this->documentBuffer .= "</tr>\n";

                $this->tableLastRow++;
                return $this->tableLastRow;
        }//end addTableHeaderRow()

        /**
         * void endTable(void)
         */
        function endTable(){
                $this->documentBuffer .= "</table>\n";

                $this->tableIsOpen = false;
                $this->tableLastRow = 0;
        }//end endTable()

        /**
         * private void endSession(void)
         */
        function endSession(){
                $this->documentBuffer .= "</div>\n";
        }//end newSession()

        /**
         * private void prepareDefaultHeader(void)
         */
        function prepareDefaultHeader(){
                $this->formatBuffer .= 'p.normalText, li.normalText, div.normalText' . "\n";
                $this->formatBuffer .= '   {mso-style-parent: "";' . "\n";
                $this->formatBuffer .= '   margin: 0cm;' . "\n";
                $this->formatBuffer .= '   margin-bottom: 6pt;' . "\n";
                $this->formatBuffer .= '   mso-pagination: widow-orphan;' . "\n";
                $this->formatBuffer .= '   font-size: 12.0pt;' . "\n";//设置行高
				$this->formatBuffer .= '   line-height: 24.0pt;' . "\n";
                $this->formatBuffer .= '   font-family: "雅黑";' . "\n";
                $this->formatBuffer .= '   mso-fareast-font-family: "雅黑";}' . "\n";
				$this->formatBuffer .= '   line-height: 12.0pt;' . "\n";

                if($this->cssFile != ''){
                        if(file_exists($this->cssFile))
                                $this->formatBuffer .= file_get_contents($this->cssFile);
                }
        }//end prepareDefaultHeader()

        /**
         * private void outputHeader(void)
         */
        function outputHeader(){
                echo '<head>' . "\n";
                echo '<meta http-equiv=Content-Type content="text/html; charset=UTF-8">' . "\n";
                echo '<meta name=ProgId content=Word.Document>' . "\n";
                echo '<meta name=Generator content="'.$this->appName.' '.$this->appVersion.'">' . "\n";
                echo '<meta name=Originator content="'.$this->appName.' '.$this->appVersion.'">' . "\n";

                echo '<style>' . "\n";
                echo '<!--' . "\n";
                echo '/* Style Definitions */' . "\n";

                $this->prepareDefaultHeader();

                echo $this->formatBuffer . "\n";

                echo '-->' . "\n";
                echo '</style>' . "\n";
                echo '</head>' . "\n";
        }//end outputHeader()

        /**
         * private void outputBody(void)
         */
        function outputBody(){
                echo "<body lang=PT-BR style='tab-interval:35.4pt'>\n";

                echo $this->documentBuffer . "\n";

                echo "</body>\n";
        }//end outputBody()
}//end class clsMsDocGenerator


/****************************************************
 * constant definition
 ***************************************************/
define('Um_Cent', 28.35);//1cm = 28.35pt

//paper sizes
define('A4_WIDTH', 21.0);
define('A4_HEIGHT', 29.7);
define('A5_WIDTH', 14.8);
define('A5_HEIGHT', 21.0);
define('LETTER_WIDTH', 21.59);
define('LETTER_HEIGHT', 27.94);
define('OFFICE_WIDTH', 21.59);
define('OFFICE_HEIGHT', 35.56);


//table values
define('BORDER_ALT', 0.5);
define('PADDING_ALT_RIGHT', 5.4);
define('PADDING_ALT_LEFT', 5.4);
define('BORDER_INSIDEH', 0.5);
define('BORDER_INSIDEV', 0.5);

//remove in new version
define('A4_PORTRAIT_SIZE', '21.0cm 842.0pt');
define('A4_LANDSCAPE_SIZE', '842.0pt 21.0cm');
define('A4_PORTRAIT_MARGIN', '70.85pt 3.0cm 70.85pt 3.0cm');
define('A4_LANDSCAPE_MARGIN', '3.0cm 70.85pt 3.0cm 70.85pt');

define('LETTER_PORTRAIT_SIZE', '612.0pt 792.0pt');
define('LETTER_LANDSCAPE_SIZE', '792.0pt 612.0pt');
define('LETTER_PORTRAIT_MARGIN', '70.85pt 3.0cm 70.85pt 3.0cm');
define('LETTER_LANDSCAPE_MARGIN', '3.0cm 70.85pt 3.0cm 70.85pt');

/****************************************************
 * function definition
 ***************************************************/

if(! function_exists('file_get_contents')){
  function file_get_contents($filename, $useIncludePath = '', $context = ''){
    if(empty($useIncludePath)){
      return implode('',file($filename));
    }elseif(empty($content)){
      return implode('',file($filename, $useIncludePath));
    }else{
      return implode('',file($filename, $useIncludePath, $content));
    }
  }//end file_get_contents()
}//end if
//龙
?>