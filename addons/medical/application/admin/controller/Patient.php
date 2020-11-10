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
class Patient extends Backend
{

    protected $model = null;
    protected $searchFields = 'name,mobile';

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('MedicalPatient');
        $this->modelD = model('MedicalPatientDoctor');
        $this->view->assign('levelList',
            ['1' => __('三级特等'), 
            '2' => __('三级甲等'),
            '3' => __('三级乙等'),
            '4' => __('三级丙等'),
            '5' => __('二级甲等'),
            '6' => __('二级乙等'),
            '7' => __('二级丙等'),
            '8' => __('一级甲等'),
            '9' => __('一级乙等'),
            '10' => __('一级丙等')
            ]
        );

        if (!$this->auth->isSuperAdmin()) {
            $tmp = collection(
                model('Admin')
                ->field('id')
                ->where(array('assistant_id'=>$this->auth->id))
                ->select()
            )->toArray();

            $admin_ids = array($this->auth->id);
            foreach($tmp as $v){
                $admin_ids[] = $v['id'];
            }


            $where = array(
                'admin_id' => array('IN',$admin_ids )
            );
            $datalist = Db::name("medical_patient_doctor")
            ->alias("mpd")
            ->join("medical_doctor md", "md.id=mpd.doctor_id")
            ->field("mpd.patient_id")
            ->where($where) 
            ->select();
    
            $patient_ids = array();
            foreach($datalist as $v){
                $patient_ids[] = $v['patient_id'];
            }
            $this->patientIds = $patient_ids;
        }
        
    }


    public function index()
    {
        //设置过滤方法
        if ($this->auth->isSuperAdmin()) {
            $this->request->filter(['strip_tags']);
            if ($this->request->isAjax()) {
                $this->relationSearch = true;
                //如果发送的来源是Selectpage，则转发到Selectpage
                if ($this->request->request('keyField')) {
                    return $this->selectpage();
                }
                list($where, $sort, $order, $offset, $limit) = $this->buildparams();
                $total = $this->model
                    ->where($where)
                    ->order($sort, $order)
                    ->count();
    
                $list = $this->model
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();
    
                $list = collection($list)->toArray();
                $result = array("total" => $total, "rows" => $list);
    
                return json($result);
            }
            return $this->view->fetch();
        }else{

            $this->request->filter(['strip_tags']);
            if ($this->request->isAjax()) {
                $this->relationSearch = true;
                //如果发送的来源是Selectpage，则转发到Selectpage
                if ($this->request->request('keyField')) {
                    return $this->selectpage();
                }
                list($where, $sort, $order, $offset, $limit) = $this->buildparams();
                $total = $this->model
                    ->where($where)
                    ->where('id', 'in', $this->patientIds)
                    ->order($sort, $order)
                    ->count();
    
                $list = $this->model
                    ->where($where)
                    ->where('id', 'in', $this->patientIds)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();
    
                $list = collection($list)->toArray();
                $result = array("total" => $total, "rows" => $list);
    
                return json($result);
            }
            return $this->view->fetch();
        }

    }
    public function add()
    {
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            $params['createtime'] = time();
            if ($params) {
                $doctor_id = $params['doctor_id'];
                unset($params['doctor_id']);
                
                $this->model->save($params);

                $patient_id =  $this->model->getLastInsID();
                $params2 = array(
                    'doctor_id'=> $doctor_id,
                    'patient_id'=> $patient_id
                );
                $this->modelD->save($params2);


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
       $row = $this->model->get($ids);

       if (!$row)
           $this->error(__('No Results were found'));
       if ($this->request->isPost()) {
           $params = $this->request->post("row/a");
           if ($params) {
                // list($province,$city,$area) = explode("/",$params['area']);
                // $params['province'] = $province;
                // $params['city'] = $city;
                // $params['area'] = $area;

                $doctor_id = $params['doctor_id'];
                unset($params['doctor_id']);
                $params2 = array(
                    'doctor_id'=> $doctor_id,
                    'patient_id'=>$ids
                );
                $row2 = $this->modelD->get($params2);
                if(!$row2){
                    $this->modelD->save($params2);
                }

               $row->save($params);
               $this->success();
           }
           $this->error();
       }

       $row = $row->toArray();
       $row2 =  collection($this->modelD->field('doctor_id')->where(array('patient_id'=>$row['id']))->select())->toArray();

       $doctor_ids = array();

       foreach($row2 as $v){
        $doctor_ids[] = $v['doctor_id'];
       }
       if($doctor_ids){
        $row['doctor_id'] = $doctor_ids[0];
       }else{
        $row['doctor_id'] =0;
       }
       $row['doctor_ids'] = $doctor_ids;

       $this->view->assign("row", $row);
       $this->view->assign("doctor_ids", $doctor_ids);
       return $this->view->fetch();
   }

}
