<?php

namespace app\admin\controller\general;

use app\admin\model\Admin;
use think\Db;
use app\common\controller\Backend;
use fast\Random;
use think\Session;
use think\Validate;

/**
 * 个人配置
 *
 * @icon fa fa-user
 */
class Profile extends Backend
{


  protected $noNeedLogin = ['request', 'createarts', 'createqa', 'createpatient', 'createdoctor', 'createscale', 'createmedicinal', 'createcase'];


  public function _initialize()
  {
    parent::_initialize();
    $this->idx = array(5);
    $this->url_prev = "http://fch.qiban365.com:9099/interface/server/";
    $this->sign = "Neusoft123";

    $this->createarts = 'select a.id,a.title,a.createtime,a.channel_id,b.wx_url as burl,c.wx_url as curl
                      from fa_cms_archives a 
                      left join fa_cms_medicine b
                      on a.id=b.id
                      left join fa_cms_treatment c
                      on a.id=c.id
                      where a.id>?';
    $this->createqa = 'select id,patient_id,doctor_id,question,createtime 
                      from fa_medical_patient_qa 
                      where id>?';
    $this->createpatient = 'select a.id,a.name,a.nickname,a.gender,a.birth_year,a.disease,a.mobile,a.address,a.smoke,a.medicine,a.createtime,b.doctor_id
                      from fa_medical_patient a
                      left join fa_medical_patient_doctor b
                      on a.id=b.patient_id
                      where a.id>?';
    $this->createdoctor = 'select id,mobile,name,createtime
                      from fa_medical_doctor 
                      where id>?';
    $this->createmedicinal = 'select id,patient_id,y as year,m as month,d as day,type
                      from fa_medical_patient_clock 
                      where id>?';
    $this->createcase = 'select id,patient_id,add_day,source,sub_vister,sub_vister_time,check_list,check_list_imgs,prescription,prescription_imgs,case_imgs,createtime
                      from fa_medical_patient_case 
                      where id>?';
    $this->createscale = 'select id,patient_id,type,report,createtime
                      from fa_medical_patient_report 
                      where id>?';
  }

  /**
   * 查看
   */
  public function index()
  {
    //设置过滤方法
    $this->request->filter(['strip_tags']);
    if ($this->request->isAjax()) {
      $model = model('AdminLog');
      list($where, $sort, $order, $offset, $limit) = $this->buildparams();

      $total = $model
        ->where($where)
        ->where('admin_id', $this->auth->id)
        ->order($sort, $order)
        ->count();

      $list = $model
        ->where($where)
        ->where('admin_id', $this->auth->id)
        ->order($sort, $order)
        ->limit($offset, $limit)
        ->select();

      $result = array("total" => $total, "rows" => $list);

      return json($result);
    }

    //判断是否是医生
    // $isDoctor = !$this->auth->check("auth/admin");
    $isDoctor = false;
    $this->view->assign('isDoctor', $isDoctor);

    $this->model = model('MedicalDoctor');
    $row = $this->model->get($this->auth->id);
    if ($isDoctor) {
      $this->view->assign("row", $row);
    }

    return $this->view->fetch();
  }
  /**
   * 更新个人信息
   */
  public function update()
  {
    if ($this->request->isPost()) {
      $this->token();
      $params = $this->request->post("row/a");
      $params = array_filter(array_intersect_key(
        $params,
        array_flip(array('email', 'nickname', 'password', 'avatar'))
      ));
      unset($v);
      if (!Validate::is($params['email'], "email")) {
        $this->error(__("Please input correct email"));
      }
      if (isset($params['password'])) {
        if (!Validate::is($params['password'], "/^[\S]{6,16}$/")) {
          $this->error(__("Please input correct password"));
        }
        $params['salt'] = Random::alnum();
        $params['password'] = md5(md5($params['password']) . $params['salt']);
      }
      $exist = Admin::where('email', $params['email'])->where('id', '<>', $this->auth->id)->find();
      if ($exist) {
        $this->error(__("Email already exists"));
      }
      if ($params) {
        $admin = Admin::get($this->auth->id);
        $admin->save($params);
        //因为个人资料面板读取的Session显示，修改自己资料后同时更新Session
        Session::set("admin", $admin->toArray());
        $this->success();
      }
      $this->error();
    }
    return;
  }


  public static function request($url, $params = [])
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $apiResponse = curl_exec($ch);
    curl_close($ch);

    return json_decode($apiResponse);
  }


  public function createarts()
  {
    $collection = Db::query($this->createarts, $this->idx);

    $operatime = time();
    $signature = strtolower(Md5($this->sign . $operatime));
    $url = $this->url_prev . "createarts";

    $file = 'log_createarts.txt';
    file_put_contents($file, "");
    $current = "api: " . $url . "; \r\n";
    file_put_contents($file, $current);

    $params = array(
      'signature' => $signature,
      'operatime' => $operatime
    );


    $count = count($collection);
    for ($x = 0; $x < $count; $x++) {
      switch ($collection[$x]['channel_id']) {
        case 3:
          $collection[$x]['artUrl'] = $collection[$x]['burl'];
          break;
        case 4:
          $collection[$x]['artUrl'] = $collection[$x]['curl'];
          break;
        default:
          break;
      }

      $params['artId'] = $collection[$x]['id'];
      $params['artTitle'] = $collection[$x]['title'];
      $params['id'] = $collection[$x]['id'];
      $params['createtime'] = $collection[$x]['createtime'];

      $result = $this->request($url, $params);

      $current = file_get_contents($file);

      if (isset($result->message)) {
        $current .= "message: " . $result->message . "; ";
      }
      if (isset($result->code)) {
        $current .= "code: " . $result->code . "; ";
      }
      $current .= "response: " . json_encode($result) . "; ";

      foreach ($collection[$x] as $key => $value) {
        $current .= $key . ": ";
        $current .= $value . "; ";
      }

      $current .= "operatime: " . $operatime . "; ";
      $current .= "api: " . $url . "; ";
      $current .= "\r\n";

      file_put_contents($file, $current);
    }

    return json("执行结束");
  }


  public function createqa()
  {
    $collection = Db::query($this->createqa, $this->idx);


    $operatime = time();
    $signature = strtolower(Md5($this->sign . $operatime));
    $count = count($collection);
    $url = $this->url_prev . "createqa";

    $file = 'log_createqa.txt';
    file_put_contents($file, "");
    $current = "api: " . $url . "; \r\n";
    file_put_contents($file, $current);

    $params = array(
      'signature' => $signature,
      'operatime' => $operatime
    );

    for ($x = 0; $x < $count; $x++) {
      $params['createtime'] = $collection[$x]['createtime'];
      $params['patientid'] = $collection[$x]['patient_id'];
      $params['doctorid'] = $collection[$x]['doctor_id'];
      $params['question'] = $collection[$x]['question'];
      $params['id'] = $collection[$x]['id'];

      $result = $this->request($url, $params);

      $current = file_get_contents($file);

      if (isset($result->message)) {
        $current .= "message: " . $result->message . "; ";
      }
      if (isset($result->code)) {
        $current .= "code: " . $result->code . "; ";
      }
      $current .= "response: " . json_encode($result) . "; ";

      foreach ($collection[$x] as $key => $value) {
        $current .= $key . ": ";
        $current .= $value . "; ";
      }

      $current .= "operatime: " . $operatime . "; ";
      $current .= "\r\n";

      file_put_contents($file, $current);
    }

    return json("执行结束");
  }


  public function createdoctor()
  {
    $collection = Db::query($this->createdoctor, $this->idx);


    $operatime = time();
    $signature = strtolower(Md5($this->sign . $operatime));
    $count = count($collection);
    $url = $this->url_prev . "createdoctor";


    $file = 'log_createdoctor.txt';
    file_put_contents($file, "");
    $current = "api: " . $url . "; \r\n";
    file_put_contents($file, $current);

    $params = array(
      'signature' => $signature,
      'operatime' => $operatime
    );

    for ($x = 0; $x < $count; $x++) {
      $params['login_name'] = $collection[$x]['mobile'];
      $params['password'] = $collection[$x]['mobile'];
      $params['name'] = $collection[$x]['name'];
      $params['doctorid'] = $collection[$x]['id'];
      $params['id'] = $collection[$x]['id'];

      $result = $this->request($url, $params);

      $current = file_get_contents($file);

      if (isset($result->message)) {
        $current .= "message: " . $result->message . "; ";
      }
      if (isset($result->code)) {
        $current .= "code: " . $result->code . "; ";
      }
      $current .= "response: " . json_encode($result) . "; ";

      foreach ($collection[$x] as $key => $value) {
        $current .= $key . ": ";
        $current .= $value . "; ";
      }

      $current .= "operatime: " . $operatime . "; ";
      $current .= "\r\n";

      file_put_contents($file, $current);
    }

    return json("执行结束");
  }


  public function createpatient()
  {
    $collection = Db::query($this->createpatient, $this->idx);

    $operatime = time();
    $signature = strtolower(Md5($this->sign . $operatime));
    $count = count($collection);
    $url = $this->url_prev . "createpatient";

    $file = 'log_createpatient.txt';
    file_put_contents($file, "");
    $current = "api: " . $url . "; \r\n";
    file_put_contents($file, $current);

    $params = array(
      'signature' => $signature,
      'operatime' => $operatime
    );

    for ($x = 0; $x < $count; $x++) {
      switch ($collection[$x]['gender']) {
        case 1:
          $params['gender'] = "男";
          break;
        case 2:
          $params['gender'] = "女";
          break;
        default:
          break;
      }
      $params['createdate'] = $collection[$x]['createtime'];
      $params['name'] = $collection[$x]['name'];
      $params['nickname'] = $collection[$x]['nickname'];
      $params['year'] = $collection[$x]['birth_year'];
      $params['disease'] = $collection[$x]['disease'];
      $params['mobile'] = $collection[$x]['mobile'];
      $params['address'] = $collection[$x]['address'];
      $params['smoke'] = $collection[$x]['smoke'];
      $params['medicine'] = $collection[$x]['medicine'];
      $params['patientid'] = $collection[$x]['id'];
      $params['id'] = $collection[$x]['id'];
      $params['doctorid'] = $collection[$x]['doctor_id'];

      $result = $this->request($url, $params);

      $current = file_get_contents($file);

      if (isset($result->message)) {
        $current .= "message: " . $result->message . "; ";
      }
      if (isset($result->code)) {
        $current .= "code: " . $result->code . "; ";
      }
      $current .= "response: " . json_encode($result) . "; ";

      foreach ($collection[$x] as $key => $value) {
        $current .= $key . ": ";
        $current .= $value . "; ";
      }

      $current .= "operatime: " . $operatime . "; ";
      $current .= "api: " . $url . "; ";
      $current .= "\r\n";

      file_put_contents($file, $current);
    }

    return json("执行结束");
  }


  public function createmedicinal()
  {
    $collection = Db::query($this->createmedicinal, $this->idx);

    $operatime = time();
    $signature = strtolower(Md5($this->sign . $operatime));
    $count = count($collection);
    $url = $this->url_prev . "createmedicinal";

    $file = 'log_createmedicinal.txt';
    file_put_contents($file, "");
    $current = "api: " . $url . "; \r\n";
    file_put_contents($file, $current);

    $params = array(
      'signature' => $signature,
      'operatime' => $operatime
    );

    for ($x = 0; $x < $count; $x++) {
      $params['patientid'] = $collection[$x]['patient_id'];
      $params['type'] = $collection[$x]['type'];
      $params['year'] = $collection[$x]['year'];
      $params['month'] = $collection[$x]['month'];
      $params['day'] = $collection[$x]['day'];

      $result = $this->request($url, $params);

      $current = file_get_contents($file);

      if (isset($result->message)) {
        $current .= "message: " . $result->message . "; ";
      }
      if (isset($result->code)) {
        $current .= "code: " . $result->code . "; ";
      }
      $current .= "response: " . json_encode($result) . "; ";

      foreach ($collection[$x] as $key => $value) {
        $current .= $key . ": ";
        $current .= $value . "; ";
      }

      $current .= "operatime: " . $operatime . "; ";
      $current .= "api: " . $url . "; ";
      $current .= "\r\n";

      file_put_contents($file, $current);
    }

    return json("执行结束");
  }


  public function createcase()
  {
    $collection = Db::query($this->createcase, $this->idx);

    $operatime = time();
    $signature = strtolower(Md5($this->sign . $operatime));
    $count = count($collection);
    $url = $this->url_prev . "createcase";

    $file = 'log_createcase.txt';
    file_put_contents($file, "");
    $current = "api: " . $url . "; \r\n";
    file_put_contents($file, $current);

    $params = array(
      'signature' => $signature,
      'operatime' => $operatime
    );

    for ($x = 0; $x < $count; $x++) {
      $params['patient_id'] = $collection[$x]['patient_id'];
      $params['add_day'] = $collection[$x]['add_day'];
      $params['source'] = $collection[$x]['source'];
      $params['sub_vister'] = $collection[$x]['sub_vister'];
      $params['sub_vister_time'] = $collection[$x]['sub_vister_time'];
      $params['check_list'] = $collection[$x]['check_list'];
      $params['check_list_imgs'] = $collection[$x]['check_list_imgs'];
      $params['prescription'] = $collection[$x]['prescription'];
      $params['prescription_imgs'] = $collection[$x]['prescription_imgs'];
      $params['case_imgs'] = $collection[$x]['case_imgs'];
      $params['createtime'] = $collection[$x]['createtime'];

      $result = $this->request($url, $params);

      $current = file_get_contents($file);

      if (isset($result->message)) {
        $current .= "message: " . $result->message . "; ";
      }
      if (isset($result->code)) {
        $current .= "code: " . $result->code . "; ";
      }
      $current .= "response: " . json_encode($result) . "; ";

      foreach ($collection[$x] as $key => $value) {
        $current .= $key . ": ";
        $current .= $value . "; ";
      }

      $current .= "operatime: " . $operatime . "; ";
      $current .= "api: " . $url . "; ";
      $current .= "\r\n";

      file_put_contents($file, $current);
    }

    return json("执行结束");
  }


  public function createscale()
  {
    $collection = Db::query($this->createscale, $this->idx);


    $operatime = time();
    $signature = strtolower(Md5($this->sign . $operatime));
    $count = count($collection);
    $url = $this->url_prev . "createscale";

    $file = 'log_createscale.txt';
    file_put_contents($file, "");
    $current = "api: " . $url . "; \r\n";
    file_put_contents($file, $current);

    $params = array(
      'signature' => $signature,
      'operatime' => $operatime
    );

    for ($x = 0; $x < $count; $x++) {
      $params['createtime'] = $collection[$x]['createtime'];
      $params['patientid'] = $collection[$x]['patient_id'];
      $params['type'] = $collection[$x]['type'];
      $params['report'] = json_decode($collection[$x]['report']);

      $result = $this->request($url, $params);

      $current = file_get_contents($file);

      if (isset($result->message)) {
        $current .= "message: " . $result->message . "; ";
      }
      if (isset($result->code)) {
        $current .= "code: " . $result->code . "; ";
      }
      $current .= "response: " . json_encode($result) . "; ";

      foreach ($collection[$x] as $key => $value) {
        $current .= $key . ": ";
        $current .= $value . "; ";
      }

      $current .= "operatime: " . $operatime . "; ";
      $current .= "api: " . $url . "; ";
      $current .= "\r\n";

      file_put_contents($file, $current);
    }

    return json("执行结束");
  }
}
