<?php

namespace app\admin\controller;

use app\common\controller\Backend;

/**
 * 微信自动回复管理
 *
 * @icon fa fa-circle-o
 */
class Hospital extends Backend
{

    protected $model = null;
    protected $searchFields = 'name';

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('MedicalHospital');
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
    }
    public function import (){
        parent::import();
    }


    public function department($ids = null){
        if(!$ids){
            $this->success();
        }
        $row = $this->model->get($ids);
        if(!$row){
            $this->success();
        }
        $datalist = explode("\n",$row['department']);
        
        foreach ($datalist as $item) {
            $list[] = [
                'id' => $item,
                'name' =>$item
            ];
        }
        return json(['list' => $list, 'total' => count($list)]);
    }

    public function add()
    {
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            $params['createtime'] = time();
            if ($params) {
                list($province,$city,$area) = explode("/",$params['area']);
                $params['province'] = $province;
                $params['city'] = $city;
                $params['area'] = $area;
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
       $row = $this->model->get($ids);

       if (!$row)
           $this->error(__('No Results were found'));
       if ($this->request->isPost()) {
           $params = $this->request->post("row/a");
           if ($params) {
                list($province,$city,$area) = explode("/",$params['area']);
                $params['province'] = $province;
                $params['city'] = $city;
                $params['area'] = $area;
               $row->save($params);
               $this->success();
           }
           $this->error();
       }
       $this->view->assign("row", $row);
       return $this->view->fetch();
   }

}
