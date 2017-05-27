<?php
function get_level($level){
	$level_array=array(1=>"公司销售部",2=>'特约',3=>'微一',4=>'微二',5=>'微三');
	return $level_array[$level];
}
