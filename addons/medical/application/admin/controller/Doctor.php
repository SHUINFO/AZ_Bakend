<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Controller;
use think\Request;
use EasyWeChat\Foundation\Application;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

define('ADMIN_GROUP_ID',6);
define('ASSISTANT_GROUP_ID',8);
define('ASSISTANT_DOCTOR_ID',9);
/**
 * 微信配置管理
 *
 * @icon fa fa-circle-o
 */
class Doctor extends Backend
{

    protected $model = null;
    protected $searchFields = 'name,mobile';
    protected $role = '';

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('MedicalDoctor');

        $groupList = $this->auth->getChildrenGroupIds(true);
        if (in_array(ADMIN_GROUP_ID, $groupList))
        {
            $this->role = 'admin';
        }
        else if (in_array(ASSISTANT_GROUP_ID, $groupList))
        {
            $this->role = 'assistant';
        }
        else if (in_array(ASSISTANT_DOCTOR_ID, $groupList))
        {
            $this->role = 'doctor';
        }
        

    }

    public function import (){
        parent::import();
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

            $where_ex = array();
            if($this->role  == 'doctor'){

            }
            if($this->role  == 'assistant'){
                $where_ex['admin.assistant_id'] =  $this->auth->id;
            }


            $total = $this->model
                ->with('hospital,admin')
                ->where($where)
                ->where($where_ex)
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->with('hospital,admin')
                ->where($where)
                ->where($where_ex)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }



    public function list()
    {
        if ($this->request->isAjax()) {
            $name = $this->request->get('name');
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $where = array(
                'name' => array('LIKE' , "%$name%")
            );
            $list = $this->model
                ->where($where)
                ->limit(0, 10)
                ->select();

            $list = collection($list)->toArray();
            return json($list);
        }
    }

   /**
    * 添加
    */
   public function add()
   {
       if ($this->request->isPost()) {
           $params = $this->request->post("row/a");
           $params['createtime'] = time();
           if ($params) {
               $this->model->save($params);

            $id =  $this->model->id;
            try
            {
                $r = $this->getQrcode('DR' . $id);
                $row = $this->model->get($id);
                $params = array(
                    'id' => $id,
                    'wxgzh_qr' => $r
                );
                $row->save($params);
            }
            //捕获异常
            catch(Exception $e){}

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
   public function edit($ids = NULL,$admin_id=NULL,$mobile=NULL)
   {
       if($mobile){
        $row = $this->model->get(['mobile' => $mobile]);
       }else{
        $row = $this->model->get($ids);
       }

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
       $this->view->assign("row", $row);
       return $this->view->fetch();
   }

   private function getQrcode($sceneValue){
    $app = new Application(get_addon_config('wechat'));
    $sceneValue = $sceneValue;
    $q = $app->qrcode->forever($sceneValue);

    $ticket = $q->ticket;
    $q = $app->qrcode->url($ticket);
    return $q;
   }


   public function export()
    {
        if ($this->request->isPost()) {
            set_time_limit(0);
            $ids = $this->request->post('ids');
            
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // $sheet = $excel->setActiveSheetIndex(0);
            $sheet->setTitle('标题');
            
            $whereIds = $ids == 'all' ? '1=1' : ['id' => ['in', explode(',', $ids)]];
            $this->request->get(['ids' => $ids]);
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            
 
    $result = $this->model->field('id,name,mobile,	wxgzh_qr')->order('id desc')
    ->where($where)
    ->select();


    foreach ($result as $key => &$val) {

        $count = $this->model->field('id,name,mobile,	wxgzh_qr')->order('id desc')->count();
        $i=$key+2;//表格是从2开始的
        if ($count>=1){

            // $row = SubjectService::getResult($val['id'],'');//score--1学历背景 2企业背景 3收入水平 4发展潜力 5管理经验  6英语水平
            $row = $val;

            //dump($row);exit();
            $sheet->setCellValue('A'.$i,$val['id']);
            $sheet->setCellValue('B'.$i,$val['name']);
            $sheet->setCellValue('C'.$i,$val['mobile']);
            $sheet->setCellValue('D'.$i,$val['wxgzh_qr']);
        }
        else{
            $sheet->setCellValue('A'.$i,$val['id']);
            $sheet->setCellValue('B'.$i,$val['name']);
            $sheet->setCellValue('C'.$i,$val['mobile']);
            $sheet->setCellValue('D'.$i,$val['wxgzh_qr']);
        }

    }


            // Redirect output to a client’s web browser (Excel2007)
            $title = date("YmdHis");
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $title . '.xlsx"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');
    
            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');exit;

            // $objWriter = \PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            // $objWriter->save('php://output');exit;
            return;
        }
    }



   public function out(){
 
    $result = $this->model->field('id,name,mobile,	wxgzh_qr')->order('id desc')->select();
    // $this->model
    // ->where($where)
    // ->order($sort, $order)
    // ->limit($offset, $limit)
    // ->select();
    $filename = "用户测评数据";

    // $objWriter = new Xlsx();
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // vendor('PHPExcel.PHPExcel');
    // $objPHPExcel = new \PHPExcel();
    // //设置保存版本格式
    // $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);

    //设置表头
    $sheet->setCellValue('A1','id');
    $sheet->setCellValue('B1','姓名');
    $sheet->setCellValue('C1','手机');
    $sheet->setCellValue('D1','公众号');

    //改变此处设置的长度数值
    $sheet->getColumnDimension('A')->setWidth(10);
    $sheet->getColumnDimension('B')->setWidth(12);
    //输出表格
    $str = '没有记录';

    foreach ($result as $key => &$val) {

        $count = $this->model->field('id,name,mobile,	wxgzh_qr')->order('id desc')->count();
        $i=$key+2;//表格是从2开始的
        if ($count>=1){

            // $row = SubjectService::getResult($val['id'],'');//score--1学历背景 2企业背景 3收入水平 4发展潜力 5管理经验  6英语水平
            $row = $val;

            //dump($row);exit();
            $sheet->setCellValue('A'.$i,$val['id']);
            $sheet->setCellValue('B'.$i,$val['name']);
            $sheet->setCellValue('C'.$i,$val['mobile']);
            $sheet->setCellValue('D'.$i,$val['wxgzh_qr']);
            // $sheet->setCellValue('E'.$i,$row['totalscore']);
            // $sheet->setCellValue('F'.$i,$row['score'][0]);
            // $sheet->setCellValue('G'.$i,$row['score'][1]);
            // $sheet->setCellValue('H'.$i,$row['score'][2]);
            // $sheet->setCellValue('I'.$i,$row['score'][3]);
            // $sheet->setCellValue('J'.$i,$row['score'][4]);
            // $sheet->setCellValue('K'.$i,$row['score'][5]);
            // $sheet->setCellValue('L'.$i,$advan);
            // $sheet->setCellValue('M'.$i,$inferi);
            // $sheet->setCellValue('N'.$i,$colllist);
        }
        else{
            $sheet->setCellValue('A'.$i,$val['id']);
            $sheet->setCellValue('B'.$i,$val['name']);
            $sheet->setCellValue('C'.$i,$val['mobile']);
            $sheet->setCellValue('D'.$i,$val['wxgzh_qr']);
            // $sheet->setCellValue('E'.$i,$str);
            // $sheet->setCellValue('F'.$i,$str);
            // $sheet->setCellValue('G'.$i,$str);
            // $sheet->setCellValue('H'.$i,$str);
            // $sheet->setCellValue('I'.$i,$str);
            // $sheet->setCellValue('J'.$i,$str);
            // $sheet->setCellValue('K'.$i,$str);
            // $sheet->setCellValue('L'.$i,$str);
            // $sheet->setCellValue('M'.$i,$str);
            // $sheet->setCellValue('N'.$i,$str);
        }

    }
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
    header("Content-Type:application/force-download");
    header("Content-Type:application/vnd.ms-execl");
    header("Content-Type:application/octet-stream");
    header("Content-Type:application/download");
    header('Content-Disposition:attachment;filename='.$filename.'.xls');
    header("Content-Transfer-Encoding:binary");
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
   }
}
