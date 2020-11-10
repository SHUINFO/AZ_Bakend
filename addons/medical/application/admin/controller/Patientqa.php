<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use app\admin\model\Admin;
use think\DB;

/**
 * 微信自动回复管理
 *
 * @icon fa fa-circle-o
 */
class Patientqa extends Backend
{
    protected $model = null;
    protected $searchFields = '';

    public function _initialize()
    {
        parent::_initialize();
        $this->relationSearch = true;
        $this->model = model('MedicalPatientqa');
        if (!$this->auth->isSuperAdmin()) {
            $where = array(
                'assistant_id' => array('IN',$this->auth->id )
            );
            $datalist = Db::name("admin")
            ->alias("a")
            ->join("medical_doctor md", "md.admin_id=a.id")
            ->field("md.id")
            ->where($where) 
            ->select();

            $doctor_ids = array();
            foreach($datalist as $v){
                $doctor_ids[] = $v['id'];
            }


            $where = array(
                'admin_id' => $this->auth->id
            );
            $datalist = Db::name("medical_doctor")
            ->field("id")
            ->where($where) 
            ->select();
            foreach($datalist as $v){
                $doctor_ids[] = $v['id'];
            }

            $this->doctorIds = $doctor_ids;
        }
    }

    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            $this->relationSearch = true;
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();

            // if (!$this->auth->isSuperAdmin()) {
            //     $total = $this->model
            //         ->with(["patient","doctor"])
            //         ->where($where)
            //         ->where(array('doctor_id'=> array('IN' , $this->doctorIds)))
            //         ->order($sort, $order)
            //         ->count();
        
            //     $list = $this->model
            //         ->with(["patient","doctor"])
            //         ->where($where)
            //         ->where(array('doctor_id'=> array('IN' , $this->doctorIds)))
            //         ->order($sort, $order)
            //         ->limit($offset, $limit)
            //         ->select();

            // }else{

            //     $total = $this->model
            //         ->with(["patient","doctor"])
            //         ->where($where)
            //         ->order($sort, $order)
            //         ->count();

            //     $list = $this->model
            //         ->with(["patient","doctor"])
            //         ->where($where)
            //         ->order($sort, $order)
            //         ->limit($offset, $limit)
            //         ->select();
            // }
    
            $total = $this->model
            ->with(["patient","doctor"])
            ->where($where)
            ->order($sort, $order)
            ->count();

        $list = $this->model
            ->with(["patient","doctor"])
            ->where($where)
            ->order($sort, $order)
            ->limit($offset, $limit)
            ->select();
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);
    
            return json($result);
        }
        return $this->view->fetch();
    }



    public function add()
    {
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            $params['createtime'] = time();
            if ($params) {
                // list($province,$city,$area) = explode("/",$params['area']);
                // $params['province'] = $province;
                // $params['city'] = $city;
                // $params['area'] = $area;
                $this->model->save($params);
                $this->success();
                $this->content = $params;
            }
            $this->error();
        }
        return $this->view->fetch();
    }
    /**
     * 编辑
     */
   public function edit($ids = NULL)
   {
       $where = array();
       $where['medical_patientqa.id']=['IN',$ids];

       $row =$this->model
       ->alias('qa')
       ->with(["patient"])
       ->where($where)
       ->find();


    //    $where['qa.id']=['IN',$ids];

    //    $tb_qa = new Model('medical_patient_qa');
    //    $tb_p = new Model('medical_patient');

    //    $row = $tb_qa->alias('qa')->where($where)
    //    ->join('tb_p as p on p.id = qa.patient_id')
    //    ->find();




       if (!$row)
           $this->error(__('No Results were found'));
       if ($this->request->isPost()) {
           $params = $this->request->post("row/a");
           if ($params) {
               $row->save($params);
               $this->success();
           }
           $this->error();
       }

       $row['name'] = $row['patient_id'];
       $this->view->assign("row", $row);
       return $this->view->fetch();
   }

   function history($patient_id = NULL){
        if(!$patient_id)  $patient_id = $this->request->post("patient_id");
        if (!$patient_id) {
            $this->error(__('patient not found'));
        }

        $where = array();
        $where['patient_id']=['=',$patient_id];



        if (!$this->auth->isSuperAdmin()) {
            // $total = $this->model
            //     ->with(["patient","doctor"])
            //     ->where($where)
            //     ->where(array('doctor_id'=> array('IN' , $this->doctorIds)))
            //     ->order($sort, $order)
            //     ->count();
    
            // $list = $this->model
            //     ->with(["patient","doctor"])
            //     ->where($where)
            //     ->where(array('doctor_id'=> array('IN' , $this->doctorIds)))
            //     ->order($sort, $order)
            //     ->limit($offset, $limit)
            //     ->select();

        $list =$this->model
        ->where($where)
        ->where(array('doctor_id'=> array('IN' , $this->doctorIds)))
        ->order('createtime desc')
        ->limit(20)
        ->select();

        $total =$this->model
        ->where($where)
        ->where(array('doctor_id'=> array('IN' , $this->doctorIds)))
        ->order('createtime desc')
        ->count();

        }else{

   
            $list =$this->model
            ->where($where)
            ->order('createtime desc')
            ->limit(20)
            ->select();
    
            $total =$this->model
            ->where($where)
            ->order('createtime desc')
            ->count();
        }



        

        $list = collection($list)->toArray();
        for($i=0;$i<count($list);$i++){
            $list[$i]['createtime'] = date('Y-m-d H:i:s',$list[$i]['createtime'] );
        }

        if ($this->request->isPost()) {
            $this->success('', null, $list);
        }
        $this->view->assign("list", $list);
        $this->view->assign("total", $total);
        $this->view->assign("total2", 3);
        return $this->view->fetch();
    }
}
