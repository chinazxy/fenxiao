<?php
namespace Mobile\Controller;
use Mobile\Logic\UsersLogic;
use Think\Page;
use Think\Verify;
use Think\Template\Driver\Mobile;
use Mobile\Logic\MsgLogic;

class UploadController extends MobileBaseController {
    public function uploadimg()
    {
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =      "./Public/upload/idcard"; // 设置附件上传根目录
        // 上传单个文件
        $info   =   $upload->uploadOne($_FILES['img1']);
        if(!$info) {// 上传错误提示错误信息
            echo json_encode(array('ret' => 0 , 'msg' =>$this->error($upload->getError())));
            return;
        }else{// 上传成功 获取上传文件信息
            echo json_encode(array('ret' => 1 , 'msg' => $info['savepath'].$info['savename']));
            return;
        }
    }

    public function uploadimg2()
    {
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =      "./Public/upload/idcard"; // 设置附件上传根目录
        // 上传单个文件
        $info   =   $upload->uploadOne($_FILES['img2']);
        if(!$info) {// 上传错误提示错误信息
            echo json_encode(array('ret' => 0 , 'msg' =>$this->error($upload->getError())));
            return;
        }else{// 上传成功 获取上传文件信息
            echo json_encode(array('ret' => 1 , 'msg' => $info['savepath'].$info['savename']));
            return;
        }
    }
}

