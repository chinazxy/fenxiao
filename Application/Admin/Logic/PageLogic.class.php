<?php

namespace Admin\Logic;


class PageLogic {

	// 分页栏每页显示的页数
	public $rollPage = 5;
	// 页数跳转时要带的参数
	public $parameter;
	// 默认列表每页显示行数
	public $listRows = 20;
	// 起始行数
	public $firstRow;
	// 分页总页面数
	protected $totalPages;
	// 总行数
	protected $totalRows;
	// 当前页数
	protected $nowPage;
	// 分页的栏的总页数
	protected $coolPages;
	// 分页显示定制
	protected $config = array('header' => '条记录', 'prev' => '上一页', 'next' => '下一页', 'first' => '首页', 'last' => '末页', 'jump1' => '跳转到第', 'jump2' => '页', 'theme' => ' %totalRow% %header% %nowPage%/%totalPage% 页 %upPage% %downPage% %first%  %prePage%  %linkPage%  %nextPage% %end%');
	// 默认分页变量名
	protected $varPage;

	/**
	  +----------------------------------------------------------
	 * 架构函数
	  +----------------------------------------------------------
	 * @access public
	  +----------------------------------------------------------
	 * @param array $totalRows  总的记录数
	 * @param array $listRows  每页显示记录数
	 * @param array $parameter  分页跳转的参数
	  +----------------------------------------------------------
	 */
	public function __construct($totalRows, $listRows = '', $parameter = '') {
		$this->totalRows = $totalRows;
		$this->parameter = $parameter;
		$this->varPage = C('VAR_PAGE') ? C('VAR_PAGE') : 'p';
		if (!empty($listRows)) {
			$this->listRows = intval($listRows);
		}
		$this->totalPages = ceil($this->totalRows / $this->listRows);  //总页数
		$this->coolPages = ceil($this->totalPages / $this->rollPage);
		$this->nowPage = !empty($_GET[$this->varPage]) ? intval($_GET[$this->varPage]) : 1;
		if (!empty($this->totalPages) && $this->nowPage > $this->totalPages) {
			$this->nowPage = $this->totalPages;
		}
		$this->firstRow = $this->listRows * ($this->nowPage - 1);
	}
    
	public function setConfig($name, $value) {
		if (isset($this->config[$name])) {
			$this->config[$name] = $value;
		}
	}

	/**
	 * 前台使用分页
	 * Transient_1988
	 * 
	 * @return string 
	 */
	public function homeShow() {
		if (0 == $this->totalRows)
			return '';
		$p = $this->varPage;
		$nowCoolPage = ceil($this->nowPage / $this->rollPage);
		$url = $_SERVER['REQUEST_URI'] . (strpos($_SERVER['REQUEST_URI'], '?') ? '' : "?") . $this->parameter;
		$parse = parse_url($url);
		if (isset($parse['query'])) {
			parse_str($parse['query'], $params);
			unset($params[$p]);
			$url = $parse['path'] . '?' . http_build_query($params);
		}
		//上下翻页字符串
		$upRow = $this->nowPage - 1;
		$downRow = $this->nowPage + 1;
		if ($upRow > 0) {
			$upPage = "<a href='" . $url . "&" . $p . "=$upRow' class='nextpage'>" . $this->config['prev'] . "</a>";
		} else {
			$upPage = "";
		}

		if ($downRow <= $this->totalPages) {
			$downPage = "<a href='" . $url . "&" . $p . "=$downRow' class='nextpage'>" . $this->config['next'] . "</a>";
		} else {
			$downPage = "";
		}
		// << < > >>
		if ($nowCoolPage == 1) {
			$theFirst = "";
			$prePage = "";
		} else {
			$preRow = $this->nowPage - $this->rollPage;
			$prePage = "<a href='" . $url . "&" . $p . "=$preRow' class='sl'>...</a>";
			$theFirst = "<a href='" . $url . "&" . $p . "=1' class='nextpage'>" . $this->config['first'] . "</a>";
		}
		if ($nowCoolPage == $this->coolPages) {
			$nextPage = "";
			$theEnd = "";
		} else {
			$nextRow = $this->nowPage + $this->rollPage;
			$theEndRow = $this->totalPages;
			$nextPage = "<a href='" . $url . "&" . $p . "=$nextRow' class='sl'>...</a>";
			$theEnd = "<a href='" . $url . "&" . $p . "=$theEndRow' class='nextpage'>" . $this->config['last'] . "</a>";
		}
		// 1 2 3 4 5
		$linkPage = "";
		for ($i = 1; $i <= $this->rollPage; $i++) {
			$page = ($nowCoolPage - 1) * $this->rollPage + $i;
			if ($page != $this->nowPage) {
				if ($page <= $this->totalPages) {
					$linkPage .= "&nbsp;<a href='" . $url . "&" . $p . "=$page' class='pageoff'>&nbsp;" . $page . "&nbsp;</a>";
				} else {
					break;
				}
			} else {
				if ($this->totalPages != 1) {
					$linkPage .= "&nbsp;<span class='pageon'>&nbsp;" . $page . "&nbsp;</span>";
//                    $linkPage .= "&nbsp;<span class='current'>" . $page . "</span>";
				}
			}
		}
		$pageStr = str_replace(
			array('%header%', '%nowPage%', '%totalRow%', '%totalPage%', '%upPage%', '%downPage%', '%first%', '%prePage%', '%linkPage%', '%nextPage%', '%end%'), array($this->config['header'], $this->nowPage, $this->totalRows, $this->totalPages, $upPage, $downPage, $theFirst, $prePage, $linkPage, $nextPage, $theEnd), '%first%  %upPage%  %prePage%  %linkPage%  %nextPage%  %downPage%  %end%' // 配置需要显示的内容
		);
		return $pageStr;
	}	

	/**
	  +----------------------------------------------------------
	 * 分页显示输出
	  +----------------------------------------------------------
	 * @access public
	  +----------------------------------------------------------
	 */
	public function show() {
		if (0 == $this->totalRows)
			return '';
		$p = $this->varPage;
		$nowCoolPage = ceil($this->nowPage / $this->rollPage);
		// dump($nowCoolPage);
		$url = $_SERVER['REQUEST_URI'] . (strpos($_SERVER['REQUEST_URI'], '?') ? '' : "?") . $this->parameter;
		$parse = parse_url($url);
		if (isset($parse['query'])) {
			parse_str($parse['query'], $params);
			unset($params[$p]);
			$url = $parse['path'] . '?' . http_build_query($params);
		}
		//上下翻页字符串
		$upRow = $this->nowPage - 1;
		$downRow = $this->nowPage + 1;
		if ($upRow > 0) {
			$upPage = "<a href='" . $url . "&" . $p . "=$upRow'>" . $this->config['prev'] . "</a>";
		} else {
			$upPage = "";
		}

		if ($downRow <= $this->totalPages) {
			$downPage = "<a href='" . $url . "&" . $p . "=$downRow'>" . $this->config['next'] . "</a>";
		} else {
			$downPage = "";
		}
		// << < > >>
		if ($nowCoolPage == 1) {
			$theFirst = "";
			$prePage = "";
		} else {
			$preRow = $this->nowPage - $this->rollPage;
			$prePage = "<a href='" . $url . "&" . $p . "=$preRow' >上" . $this->rollPage . "页</a>";
			$theFirst = "<a href='" . $url . "&" . $p . "=1' >" . $this->config['first'] . "</a>";
		}
		if ($nowCoolPage == $this->coolPages) {
			$nextPage = "";
			$theEnd = "";
		} else {
			$nextRow = $this->nowPage + $this->rollPage;
			$theEndRow = $this->totalPages;
			$nextPage = $nextRow > $theEndRow ? '' : "<a href='" . $url . "&" . $p . "=$nextRow' >下" . $this->rollPage . "页</a>";
			$theEnd = "<a href='" . $url . "&" . $p . "=$theEndRow' >" . $this->config['last'] . "</a>";
		}
		// 1 2 3 4 5
		$linkPage = "";
		for ($i = 1; $i <= $this->rollPage; $i++) {
			$page = ($nowCoolPage - 1) * $this->rollPage + $i;
			if ($page != $this->nowPage) {
				if ($page <= $this->totalPages) {
					$linkPage .= "<a href='" . $url . "&" . $p . "=$page'>&nbsp;" . $page . "&nbsp;</a>";
				} else {
					break;
				}
			} else {
				if ($this->totalPages != 1) {
					$linkPage .= "<span class='current'>&nbsp;" . $page . "&nbsp;</span>";
//                    $linkPage .= "&nbsp;<span class='current'>" . $page . "</span>";
				}
			}
		}

		$this->config['theme'] = '
            <span class="pageTota"> %totalRow% %header% %nowPage%/%totalPage% 页 </span> 
            %upPage% %downPage% %first%  %prePage%  %linkPage%  %nextPage% %end%   
           <input type="hidden" value="' . $url . '" class="go_page_url" />';
		if ($this->totalPages > 5) {
			$this->config['theme'] .= '<span>%jump1% <input type="text" name="p" class="go_page" value="%nowPage%" style="width:30px;" /> 
            %jump2%    
            <input type="submit" style="width: 40px;" onclick="jumpPageAll(this)" value="GO" />
            <script>function jumpPageAll(obj){var page = $(obj).parent().find(".go_page").val();var url = $(obj).parent().parent().find(".go_page_url").val();window.location.href=url+"&p="+page;}</script>
           </span>'; // 设置样式
		}
		$pageStr = str_replace(
			array('%jump1%', '%jump2%', '%header%', '%nowPage%', '%totalRow%', '%totalPage%', '%upPage%', '%downPage%', '%first%', '%prePage%',
			'%linkPage%', '%nextPage%', '%end%'), array($this->config['jump1'], $this->config['jump2'], $this->config['header'], $this->nowPage, $this->totalRows,
			$this->totalPages, $upPage, $downPage, $theFirst, $prePage, $linkPage,
			$nextPage, $theEnd), $this->config['theme']
		);
		return $pageStr;
	}

}
