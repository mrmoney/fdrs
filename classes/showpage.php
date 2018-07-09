<?php
/**
 *
 * 使用实例:
 * $p = new showpage;		//建立新对像
 * $p->file="ttt.php";		//设置文件名，默认为当前页
 * $p->set(20,2000,1);		//设置相关参数，共三个，分别为'页面大小'、'总记录数'、'当前页(如果为空则自动读取GET变量)'
 * $p->output(0);			//输出,为0时直接输出,否则返回一个字符串
 * echo $p->limit();		//输出Limit子句。在sql语句中用法为 "SELECT * FROM TABLE LIMIT {$p->limit()}";
 *
 */
class showpage 
{

	public $boolrewrite=false;//是否启用重写
    /**
     * 页面输出结果
     *
     * var string
     */
	public $output;

    /**
     * 使用该类的文件,默认为 PHP_SELF
     *
     * var string
     */
	public $file;

    /**
     * 页数传递变量，默认为 'p'
     *
     * var string
     */
	public $pvar = 'page';

    /**
     * 页面大小
     *
     * var integer
     */
	public $psize=20;

    /**
     * 页面大小
     *
     * var integer
     */
	public $maxtotal=10000;

    /**
     * 当前页面
     *
     * var ingeger
     */
	public $curr;

    /**
     * 要传递的变量数组
     *
     * var array
     */
	public $varstr;

    /**
     * 总页数
     *
     * var integer
     */
    public $tpage;
	
	public function showpage($page_now_name='page')
	{
		$this->pvar=$page_now_name;
	}

    /**
     * 分页设置
     *
     * access public
     * param int $pagesize 页面大小
     * param int $total    总记录数
     * param int $current  当前页数，默认会自动读取
     * return void
     */
    public function set($pagesize=20,$total,$current=false) 
	{
		//global $_SERVER,$_GET;
		$this->tpage = ceil($total/$pagesize);
		if (!$current) { $current = $_REQUEST[$this->pvar]; }
		if ($current > $this->tpage) { $current = $this->tpage; }

		if($this->pvar == 'pageIndex'){ $current++; }//因为miniui的page是从0开始
		if ($current<1) {$current = 1;}
		$this->curr  = $current;
		$this->psize = $pagesize;
		if($this->psize<=0)$this->psize=15;

		if(!$this->boolrewrite)
		{
			$this->file = REQUEST_URI;
			if(!stristr($this->file,$this->pvar . "="))
			{
				if(!stristr($this->file,"?"))
					$this->file.='?' . $this->pvar . '=pageTag';
				else
					$this->file.='&page=pageTag';
			}
			else
			{
				$nowpage=$_REQUEST[$this->pvar];	
				$this->file=str_replace($this->pvar . "=$nowpage",$this->pvar . "=pageTag",$this->file);
			}
		}
		else
		{
			if(stristr($this->file,"?"))
				$this->file.='&' . $this->pvar . '=pageTag';
			else
			{
				if(!stristr($this->file,"javascript"))
				{
					if(!stristr($this->file,"pageTag"))
						$this->file.='?' . $this->pvar . '=pageTag';
				}
			}
		}
		
		$this->file=str_replace('index.php','',$this->file);
		
		$this->output='';
		//$this->output.='现' . $this->curr . '/' . $this->tpage . '页,' . $this->psize . '条/页,共' . $total . '条 ';
//		$this->output.=$total<=20000 
//			? 
//			"<span>现{$this->curr}/{$this->tpage}页,共<label class=\"rstotal\">{$total}</label>条</span>"
//			: '';
		$this->output.='';	
		if ($this->tpage > 1) 
		{
            
			if(stristr($this->file,'javascript:'))
			{
				if ($current>10) 
					$this->output .= '<a class="linkpage" href="#" onclick="' . 
										str_replace("pageTag",($current-10),$this->file) . 
										'" title="前十页"><<</a>';
				if ($current>1) 
					$this->output .= '<a class="linkpage" href="#" onclick="' . 
										str_replace("pageTag",($current-1),$this->file) . 
										'" title="前一页"><</a>';
			}
			else
			{
				if ($current>10) 
					$this->output .= '<a class="linkpage" href="' . 
										str_replace("pageTag",($current-10),$this->file) . 
											'" title="前十页"><<</a>';
				if ($current>1) 
					$this->output .= '<a class="linkpage" href="' . 
										str_replace("pageTag",($current-1),$this->file) . 
											'" title="前一页">上一页</a>';
			}
            $start	= floor($current/10)*10;
            $end	= $start+9;

            if ($start<1)			{$start=1;}
            if ($end>$this->tpage)	{$end=$this->tpage;}

			if(stristr($this->file,'javascript:'))
			{
				for ($i=$start; $i<=$end; $i++) 
				{
					if ($current==$i)
						$this->output .= '<span class="curpage">' . $i . '</span>';    //输出当前页数
					else 
						$this->output .= '<a class="linkpage" href="#" onclick="' . 
								str_replace("pageTag",$i,$this->file) . '">' . 
								$i . '</a>';    //输出页数
				}
	
				if ($current<$this->tpage) 
					$this->output .= '<a class="linkpage" href="#" onclick="' . 
								str_replace("pageTag",($current+1),$this->file) . 
									'" title="下一页">></a>';
				
				if ($this->tpage>10 && ($this->tpage-$current)>=10 ) 
					$this->output .= '<a class="linkpage" href="#" onclick="' . 
								str_replace("pageTag",($current+10),$this->file) . 
									'" title="下十页">>></a>';
				
				if ($current==1)
					$this->output.='<span class="curpage">首页</span>'; 
				else
					$this->output .= '<a class="linkpage" href="#" onclick="' . 
								str_replace("pageTag",1,$this->file) . 
									'" title="第一页">首页</a>';
				
				if ($current== $this->tpage)
					$this->output.='<span class="curpage">尾页</span>'; 
				else
					$this->output .= '<a class="linkpage" href="#" onclick="' . 
								str_replace("pageTag",$this->tpage,$this->file) . 
									'" title="最后页">尾页</a>';
			}
			else
			{
//				if ($current==1)
//					$this->output.='<span class="curpage">首页</span>'; 
//				else
//					$this->output .= '<a class="linkpage" href=' . 
//							str_replace("pageTag",1,$this->file) . ' title="第一页">首页</a>';
				for ($i=$start; $i<=$end; $i++) 
				{
					if ($current==$i)
						$this->output .= '<span class="curpage">' . $i . '</span>';    //输出当前页数
					else 
						$this->output .= '<a class="linkpage" href="' . 
							str_replace("pageTag",$i,$this->file) . '">' . $i . '</a>';    //输出页数
				}
	
				if ($current<$this->tpage) 
					$this->output .= '<a class="linkpage" href=' . 
							str_replace("pageTag",($current+1),$this->file) . ' title="下一页">下一页</a>';
				
				if ($this->tpage>10 && ($this->tpage-$current)>=10 ) 
					$this->output .= '<a class="linkpage" href=' . 
							str_replace("pageTag",($current+10),$this->file) . ' title="下十页">>></a>';
				
				
				
//				if ($current== $this->tpage)
//					$this->output.='<span class="curpage">尾页</span>'; 
//				else
//					$this->output .= '<a class="linkpage" href=' . 
//							str_replace("pageTag",$this->tpage,$this->file) . ' title="最后页">尾页</a>';
			}
		}
	}

    /**
     * 要传递的变量设置
     *
     * access public
     * param array $data   要传递的变量，用数组来表示，参见上面的例子
     * return void
     */	
	public function setvar($data) 
	{
		foreach ($data as $k=>$v) 
		{
			if($this->boolencode)
				$this->strEncode[$k]=$v;
			else
				$this->varstr.='&amp;'.$k.'='.urlencode($v);
		}
	}

    /**
     * 分页结果输出
     *
     * access public
     * param bool $return 为真时返回一个字符串，否则直接输出，默认直接输出
     * return string
     */
	public function output($return = false) 
	{
		if ($return)
			return $this->output;
		else 
		{
			echo $this->output;
			return null;
		}
	}

    /**
     * 生成Limit语句
     *
     * access public
     * return string
     */
    public function limit($return_string=true) 
	{
		if($return_string)
			$limit="limit " . (($this->curr-1)*$this->psize).','.$this->psize;
		else
			$limit=array(($this->curr-1)*$this->psize,$this->psize);//for other db
		return $limit;
	}

} //End Class
?>