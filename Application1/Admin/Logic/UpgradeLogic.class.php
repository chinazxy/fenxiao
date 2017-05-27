<?php
namespace Admin\Logic;

use Think\Model\RelationModel;
 //用户等级
class UpgradeLogic extends RelationModel
{
    public $app_path;
    public $version_txt_path;
    public $curent_version;    
  
    
    /**
     * 析构函数
     */
    function  __construct() {
               
   }       
  
    public  function checkVersion() { 
        return false;        
    }
  
    public  function OneKeyUpgrade(){
      
        return false; 
    }
    
 
  
    public function downloadFile($fileUrl,$md5File)
    {                    
        return false;
    }            
    
 
    public  function UpgradeLog($to_key_num){
        return false;
    }
} 
?>