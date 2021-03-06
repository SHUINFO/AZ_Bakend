<?php

namespace addons\cms\controller;

use think\Config;
use think\Log;

/**
 * CMS首页控制器
 * Class Index
 * @package addons\cms\controller
 */
class Index extends Base
{
    public function index()
    {
        Config::set('cms.title', Config::get('cms.title') ? Config::get('cms.title') : __('Home'));
        if ($this->request->isAjax()) {
            $this->success("", "", $this->view->fetch('common/index_list'));
        }
        return $this->view->fetch('/index');
    }

    //选择推荐文章
    public function Recommendation() {
        $params['doctor_id'] = (int)$this->request->post("doctor_id");
        $params['article_id'] = (int)$this->request->post("article_id");
        $params['sign'] = $this->request->post("sign");
        $params['createtime'] = (int)$this->request->post("createtime");
        $params['path'] = "recommendation";
        if (!$params['doctor_id'] || !$params['article_id'] || !$params['sign'] || !$params['createtime']) {
            $this->retMsg($params,-1, "请求参数错误");
        }
        $key = Config::get("shuxin_key");
        $sig = strtolower(md5($key.$params['createtime']));

        if ($sig != $params['sign']) {
            $this->retMsg($params,-1, "签名错误");
        }
        $model = model('app\admin\model\cms\ArchivesRecommend');
        $docetorM = model('app\admin\model\MedicalDoctor');
        $admin = $docetorM->where(["id" => $params['doctor_id']])->field("admin_id")->find();
        if (!$admin) {
            $this->retMsg($params,-1, "该医生信息不存在");
        }

        $data = array();
        $data["admin_id"] = $admin['admin_id'];
        $data["archive_id"] = $params['article_id'];

        $exist = $model->where([
            "admin_id" => $data['admin_id'],
            "archive_id" => $data['archive_id']
            ])->field("id")->find();

        if($exist){
            return $this->retMsg($params);
        }

        $r = $model->save($data);
        if ($r) {
            $this->retMsg($params);
        } else {
            $this->retMsg($params,-1, "保存失败，请稍后重试");
        }

    }

    //提交问答
    public function SubmitQa() {
        $params['doctor_id'] = (int)$this->request->post("doctor_id");
        $params['patient_id'] = (int)$this->request->post("patient_id");

        $params['add_time'] = (int)$this->request->post("add_time");
        $params['answer'] = $this->request->post("answer");

        $params['sign'] = $this->request->post("sign");
        $params['createtime'] = (int)$this->request->post("createtime");

        $params['path'] = "submitqa";
        if (!$params['doctor_id']

            || !$params['patient_id'] 
            || !$params['add_time'] 
            || !$params['answer'] 

            || !$params['sign'] 
            || !$params['createtime']) {
            $this->retMsg($params,-1, "请求参数错误");
        }
        $key = Config::get("shuxin_key");
        $sig = strtolower(md5($key.$params['createtime']));
        if ($sig != $params['sign']) {
            $this->retMsg($params,-1, "签名错误");
        }
        
        $model = model('app\admin\model\MedicalPatientqa');
        $patientM = model('app\admin\model\MedicalPatient');
        $docetorM = model('app\admin\model\MedicalDoctor');

        $admin = $docetorM->where(["id" => $params['doctor_id']])->field("id")->find();
        if (!$admin) {
            $this->retMsg($params,-1, "该医生信息不存在");
        }

        $exist = $patientM->where(["id" => $params['patient_id']])->field("id")->find();
        if (!$exist) {
            $this->retMsg($params,-1, "该患者信息不存在");
        }


        $data = array();
        $data["updatetime"] = $params['createtime'];
        $data["answer"] = $params['answer'];

        $row = $model->where(
            [
                "patient_id" => $params["patient_id"],
                "doctor_id" => $params["doctor_id"],
                "createtime" => $params["add_time"]
            ]
        )->find();
        // $row = $this->model->get($id);

        //重复回答，则直接返回
        if(!$row){
            return $this->retMsg($params,-1, "该问答记录不存在");
        }
        if($row->answer && ($row->answer == $data["answer"])){
            $this->retMsg($params);
        }

        $r = $row->save($data);
        if ($r) {
            $this->retMsg($params);
        } else {
            $this->retMsg($params,-1, "保存失败，请稍后重试");
        }

    }

    public function retMsg($params,$code = 0, $msg = "请求成功") {
        $ret = ['code' => $code, 'msg' => $msg];
        $day = date("Ymd");
        $dir = "logs/".$day."/";

        // self::createDir($dir);
        $r = $params;
        $r["return"] = $ret;
        $path = $params['path'];
        unset($params['path']);
        // file_put_contents($dir.$path.".log", json_encode($r)."\n",FILE_APPEND);

        Log::record(json_encode($r), "info");
        echo json_encode($ret);exit;
    }

    // public static function createDir( $dir , $mode = "0777" ) {
    //     if(strpos($dir , "/" )){
    //         $dir_path = "" ;
    //         $dir_info = explode ( "/" , $dir );

    //         foreach($dir_info  as  $key => $value ){
    //             $dir_path .= $value ;
    //             if (!file_exists($dir_path )){
    //                 @mkdir ( $dir_path , $mode ) or  die ( "建立文件夹时失败了" );
    //                 @chmod ( $dir_path , $mode );
    //             } else {
    //                 $dir_path .= "/" ;
    //                 continue ;
    //             }
    //             $dir_path .= "/" ;
    //         }
    //         return $dir_path ;
    //     } else {
    //         @mkdir( $dir , $mode ) or die( "建立失败了,请检查权限" );
    //         @chmod ( $dir , $mode );
    //         return $dir ;
    //     }
    // }

}
