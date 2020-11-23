<?php

namespace addons\cms\controller\wxapp;

use addons\third\library\Service;
use addons\third\model\Third;
use app\common\library\Auth;
use fast\Http;
use think\Config;
use think\Validate;
use think\DB;


use app\common\controller\Api;
use fast\Random;

use app\admin\model\MedicalPatient;
use app\admin\model\MedicalPatientDoctor;
use app\admin\model\MedicalPatientClock;
use app\admin\model\MedicalPatientqa;
use app\admin\model\MedicalPatientReport;
use app\admin\model\MedicalPoint;

use addons\cms\model\ArchivesAction;

/**
 * 会员
 */
class User extends Base
{
    protected $noNeedLogin = ['index', 'login','loginSimple','loginByMobile','doctor','bindDoctor','getClock','setClock','unsetClock','getQa','setQa', 'getUserStatistics', 'updateSignTime', 'getUserStatistics'];

    protected $token = '';

    public function _initialize()
    {
        $this->token = $this->request->post('token');
        if ($this->request->action() == 'login' && $this->token) {
            $this->request->post(['token' => '']);
        }
        parent::_initialize();

        if (!Config::get('fastadmin.usercenter')) {
            $this->error(__('User center already closed'));
        }

    }

    /**
     * 登录
     */
    public function login()
    {
        $config = get_addon_config('cms');
        $code = $this->request->post("code");
        $rawData = $this->request->post("rawData", '', 'trim');
        if (!$code || !$rawData) {
            $this->error("参数不正确");
        }
        $third = get_addon_info('third');
        if (!$third || !$third['state']) {
            $this->error("请在后台插件管理安装并配置第三方登录插件");
        }
        $userInfo = (array)json_decode($rawData, true);

        $params = [
            'appid'      => $config['wxappid'],
            'secret'     => $config['wxappsecret'],
            'js_code'    => $code,
            'grant_type' => 'authorization_code'
        ];
        $result = Http::sendRequest("https://api.weixin.qq.com/sns/jscode2session", $params, 'GET');
        if ($result['ret']) {
            $json = (array)json_decode($result['msg'], true);
            if (isset($json['openid'])) {
                //如果有传Token
                if ($this->token) {
                    $this->auth->init($this->token);
                    //检测是否登录
                    if ($this->auth->isLogin()) {
                        $third = Third::where(['openid' => $json['openid'], 'platform' => 'wxapp'])->find();
                        if ($third && $third['user_id'] == $this->auth->id) {
                            $this->success("登录成功", ['userInfo' => $this->getUserInfo()]);
                        }
                    }
                }

                $platform = 'wxapp';
                $result = [
                    'openid'        => $json['openid'],
                    'userinfo'      => [
                        'nickname' => $userInfo['nickName'],
                    ],
                    'access_token'  => $json['session_key'],
                    'refresh_token' => '',
                    'expires_in'    => isset($json['expires_in']) ? $json['expires_in'] : 0,
                ];
                $extend = ['gender' => $userInfo['gender'], 'nickname' => $userInfo['nickName'], 'avatar' => $userInfo['avatarUrl']];
                $ret = Service::connect($platform, $result, $extend);
                if ($ret) {
                    $auth = Auth::instance();
                    $this->success("登录成功", ['userInfo' => $auth->getUserinfo()]);
                } else {
                    $this->error("连接失败");
                }
            } else {
                $this->error("登录失败");
            }
        }

        return;
    }


    private function checkUserAccount($mobile){
        if (!$mobile ) {
            return null;
        }
        
        $user = \app\common\model\User::getByMobile($mobile);
        
        if ($user) {
            if ($user->status != 'normal') {
                $this->error(__('Account is locked'));
            }
            //如果已经有账号则直接登录
            $ret = $this->auth->direct($user->id);
        } else {
            $ret = $this->auth->register($mobile, Random::alnum(), '', $mobile, []);
        }
        if ($ret) {
            return $this->auth->getUserinfo();
        }
        return null;
    }

    public function loginByMobile()
    {
        $mobile = $this->request->post("mobile");
        if (!$mobile) {
            $this->error("参数不正确");
        }

        
        $user = $this->checkUserAccount($mobile);


        $doctorList = array();
        $admin = \app\admin\model\Admin::get(['email' => $mobile]);
        //如果是管理员，看一下 关联的医生
        if ($admin) {
            $where = array(
                'a.assistant_id' => $admin->id
            );
            $datalist = Db::name("admin")
            ->alias("a")
            ->join("medical_doctor md", "md.admin_id=a.id")
            ->field("md.*")
            ->where($where) 
            ->select();

            for($i=0;$i<count($datalist);$i++){
                $datalist[$i]['avatar'] = cdnurl($datalist[$i]['avatar'], true);
                $doctorList[$datalist[$i]['id']] = $datalist[$i];
            }

            $user['doctorList'] = ($datalist)?$datalist:array();


            $doctor = \app\admin\model\MedicalDoctor::get(['mobile' => $mobile]);
            if($doctor){
                $user['doctor'] = $doctor;
            }
            $user['isAdmin'] = true;
            $user['admin'] = $admin;
        }
        
        $patient = \app\admin\model\MedicalPatient::get(['mobile' => $mobile]);

        if (!$admin && !$patient) {
            $this->error('账号未找到');
        }

        if( $patient){
            $where = array(
                'mpd.patient_id' => $patient->id
            );
            $datalist = Db::name("medical_patient_doctor")
            ->alias("mpd")
            ->join("medical_doctor md", "mpd.doctor_id=md.id")
            ->field("md.*")
            ->where($where) 
            ->select();
                
            for($i=0;$i<count($datalist);$i++){
                $datalist[$i]['avatar'] = cdnurl($datalist[$i]['avatar'], true);
                $doctorList[$datalist[$i]['id']] = $datalist[$i];
            }
        }


        $user['doctorList'] = array_values($doctorList);
        $user['patient'] = $patient;

        $this->success("登录成功", ['userInfo' => $user]);
    }

    public function doctor()
    {
        $id = $this->request->post("id");
        if (!$id) {
            $this->error("参数不正确");
        }

        $doctor = model('app\admin\model\MedicalDoctor')
        ->where(array('medical_doctor.id'=>$id))
        ->with('hospital')
        ->find();

        // $doctor = \app\admin\model\MedicalDoctor::get($id);
        //如果是管理员，看一下 关联的医生
        if ($doctor) {
            $doctor['avatar'] = cdnurl($doctor['avatar'], true);
            $doctor['hospital']['logo'] = cdnurl($doctor['hospital']['logo'], true);
            $this->success("成功", ['doctorInfo' => $doctor]);
        }

        $this->error('医生未找到');
    }

    /**
     * 绑定账号
     */
    public function bindDoctor()
    {
        // $mobile = $this->request->post("mobile");
        //判断是否是新手机号
        $model = model('app\admin\model\MedicalPatient');
        $modelD = model('app\admin\model\MedicalPatientDoctor');


        $params = $this->request->post("row/a");
        $doctor_id = $this->request->post("doctor_id");
        if ($params) {
            $params['diagnose_at'] = 0;
            $mobile = $params['mobile'];
            if(!$mobile) $this->error();
            $row = $model->get(array('mobile'=>$mobile));


            //登记病人
            if($row){
                $ids = $row->id;
                $row->save($params);
            }else{
                $model->save($params);
                $ids = $model->getLastInsID();
            }

            //需要配合写入对方东软的url地址
            $path = "createpatient";
            //$data = $params;
            $data['name'] = $params['name'];
            $data['nickname'] = $params['name'];
            $data['gender'] = ($params['gender'] == "男") ? 1:2;
            $data['year'] = $params['birth_year'];
            $data['disease'] = $params['disease'];
            $data['mobile'] = $params['mobile'];
            $data['address'] = "";
            $data['smoke'] = "";
            $data['medicine'] = isset($params['medicine']) ? $params['medicine'] : '';
            // $data['relative'] = ($params['relative'] == 1) ? "本人" : "亲属";
            $data['relative'] = (int)$params['relative'];
            $data['createdate'] = time();
            $data['patientid'] = $ids;
            $data['doctorid'] = $doctor_id;
            $this->eastReq($path, $data);


            //绑定医生
            $params2 = array(
                'doctor_id'=> $doctor_id,
                'patient_id'=>$ids
            );
            $row2 = $modelD->get($params2);
            if(!$row2){
                $modelD->save($params2);

                //入组加积分
                $this->setPoint($ids,'入组',5);
            }

            $this->success();
        }
        $this->error();
    }


    /**
     * 绑定账号
     */
    public function bind()
    {
        $account = $this->request->post("account");
        $password = $this->request->post("password");
        if (!$account || !$password) {
            $this->error("参数不正确");
        }

        $account = $this->request->post('account');
        $password = $this->request->post('password');
        $rule = [
            'account'  => 'require|length:3,50',
            'password' => 'require|length:6,30',
        ];

        $msg = [
            'account.require'  => 'Account can not be empty',
            'account.length'   => 'Account must be 3 to 50 characters',
            'password.require' => 'Password can not be empty',
            'password.length'  => 'Password must be 6 to 30 characters',
        ];
        $data = [
            'account'  => $account,
            'password' => $password,
        ];
        $validate = new Validate($rule, $msg);
        $result = $validate->check($data);
        if (!$result) {
            $this->error(__($validate->getError()));
            return false;
        }
        $field = Validate::is($account, 'email') ? 'email' : (Validate::regex($account, '/^1\d{10}$/') ? 'mobile' : 'username');
        $user = \app\common\model\User::get([$field => $account]);
        if (!$user) {
            $this->error('账号未找到');
        }
        $third = Third::where(['user_id' => $user->id, 'platform' => 'wxapp'])->find();
        if ($third) {
            $this->error('账号已经绑定其他小程序账号');
        }

        $third = Third::where(['user_id' => $this->auth->id, 'platform' => 'wxapp'])->find();
        if (!$third) {
            $this->error('未找到登录信息');
        }

        if ($this->auth->login($account, $password)) {
            $third->user_id = $this->auth->id;
            $third->save();
            $this->success("绑定成功", ['userInfo' => $this->getUserInfo()]);
        } else {
            $this->error($this->auth->getError());
        }
    }

    /**
     * 个人资料
     */
    public function profile()
    {
        $user = $this->auth->getUser();
        $username = $this->request->post('username');
        $nickname = $this->request->post('nickname');
        $bio = $this->request->post('bio');
        $avatar = $this->request->post('avatar');
        if (!$username || !$nickname) {
            $this->error("用户名和昵称不能为空");
        }
        $exists = \app\common\model\User::where('username', $username)->where('id', '<>', $this->auth->id)->find();
        if ($exists) {
            $this->error(__('Username already exists'));
        }
        $avatar = str_replace(cdnurl('', true), '', $avatar);
        $user->username = $username;
        $user->nickname = $nickname;
        $user->bio = $bio;
        $user->avatar = $avatar;
        $user->save();
        $this->success('', ['userInfo' => $this->getUserInfo()]);
    }

    /**
     * 保存头像
     */
    public function avatar()
    {
        $user = $this->auth->getUser();
        $avatar = $this->request->post('avatar');
        if (!$avatar) {
            $this->error("头像不能为空");
        }
        $avatar = str_replace(cdnurl('', true), '', $avatar);
        $user->avatar = $avatar;
        $user->save();
        $this->success('', ['userInfo' => $this->getUserInfo()]);
    }

    /**
     * 获取用户信息
     * @return array
     */
    protected function getUserInfo()
    {
        $userinfo = $this->auth->getUserInfo();
        $userinfo['avatar'] = cdnurl($userinfo['avatar'], true);
        return $userinfo;
    }
    
    /**
     * 获取用户信息
     * @return array
     */
    public function getClock()
    {
        $patient_id = $this->request->post("patient_id");
        $y = $this->request->post("y");
        $m = $this->request->post("m");
        $d = $this->request->post("d");
        if (!$patient_id) {
            $this->error("参数不正确");
        }

        $where = array(
            'patient_id' => $patient_id
        );
        if($y){
            $where['y'] = $y; 
        }
        if($m){
            $where['m'] = $m; 
        }
        if($d){
            $where['d'] = $d; 
        }

        $list = model('app\admin\model\MedicalPatientClock')
        ->where($where)
        ->select();

        if ($list) {
            $this->success("成功", ['list' => $list]);
        }
        $this->success("成功", ['list' => array()]);
    }

    /**
     * 获取用户信息
     * @return array
     */
    public function setClock()
    {
        $patient_id = $this->request->post("patient_id");
        $y = $this->request->post("y");
        $m = $this->request->post("m");
        $d = $this->request->post("d");
        $type = $this->request->post("type");
        if (!$patient_id) {
            $this->error("参数不正确");
        }

        $params = array(
            'patient_id' => $patient_id
        );
        if($y){
            $params['y'] = $y; 
        }
        if($m){
            $params['m'] = $m; 
        }
        if($d){
            $params['d'] = $d; 
        }
        if($type){
            $params['type'] = $type; 
        }

        if ($params["m"] < 10 ) {
            $m = "0".$params["m"];
        }
        if ($params["d"] < 10 ) {
            $d = "0".$params["d"];
        }
        $params['sign_time'] = strtotime($y.$m.$d);

        $model = model('app\admin\model\MedicalPatientClock');
        $model->save($params);

        $this->setPoint($patient_id,'用药打卡',1);

        //数据发送东软
        $path = "createmedicinal";
        $data = [
            "patient_id" => $patient_id,
            "year" => $y,
            "month" => $m,
            "day" => $d,
            "type" => $type,
            "id" => $model->id
        ];

        $this->eastReq($path, $data);

        $this->success("成功");
    }


    
    public function unsetClock()
    {
        $patient_id = $this->request->post("patient_id");
        $y = $this->request->post("y");
        $m = $this->request->post("m");
        $d = $this->request->post("d");
        $type = $this->request->post("type");
        if (!$patient_id) {
            $this->error("参数不正确");
        }

        $params = array(
            'patient_id' => $patient_id
        );
        if($y){
            $params['y'] = $y; 
        }
        if($m){
            $params['m'] = $m; 
        }
        if($d){
            $params['d'] = $d; 
        }
        if($type){
            $params['type'] = $type; 
        }

        $record = \app\admin\model\MedicalPatientClock::get($params);

        model('app\admin\model\MedicalPatientClock')->where($params)->delete();

        $this->setPoint($patient_id,'取消用药打卡',-1);


        if($record && $record->id){
            $path = "deletemedicinal";
            $data = [
                "patient_id" => $patient_id,
                "id" => $record->id,
            ];
            $this->eastReq($path, $data);
        }

        $this->success("成功");
    }



    public function getQa()
    {
        $patient_id = $this->request->post("patient_id");
        $doctor_id = $this->request->post("doctor_id");
        
        if (!$patient_id || !$doctor_id) {
            $this->error("参数不正确");
        }
        $where = array(
            'patient_id' => $patient_id,
            'doctor_id' => $doctor_id
        );

        $total = model('app\admin\model\MedicalPatientqa')
        ->where($where)
        ->count();

        $list = model('app\admin\model\MedicalPatientqa')
        ->where($where)
        ->order("id desc")
        ->select();

        if ($list) {
            $this->success("成功", ['list' => $list,'total' => $total]);
        }
        $this->success("成功", ['list' => array(),'total' => 0]);
    }



    public function setQa()
    {
        $patient_id = $this->request->post("patient_id");
        $doctor_id = $this->request->post("doctor_id");
        $question = $this->request->post("question");

        if (!$patient_id || !$doctor_id|| !$question) {
            $this->error("参数不正确");
        }
        $params = array(
            'patient_id'=>$patient_id,
            'doctor_id'=>$doctor_id,
            'question'=>$question,
        );
        $params['createtime'] = time();
        if ($params) {
            model('app\admin\model\MedicalPatientqa')->save($params);

            //数据发送东软
            $path = "createqa";
            $data = [
                "patientid" => $patient_id,
                "doctorid" => $doctor_id,
                "question" => $question,
                "createtime" => $params['createtime'],
                "id" => model('app\admin\model\MedicalPatientqa')->getLastInsID(),
            ];
            $this->eastReq($path, $data);

            $this->success();
        }
    }


    public function getReport()
    {
        $patient_id = $this->request->post("patient_id");
        $type = $this->request->post("type");
        
        if (!$patient_id) {
            $this->error("参数不正确");
        }
        $where = array(
            'patient_id' => $patient_id,
            'type' => $type
        );
        if($type){
            $where['type'] =  $type;
        }

        $total = model('app\admin\model\MedicalPatientReport')
        ->where($where)
        ->count();

        $list = model('app\admin\model\MedicalPatientReport')
        ->where($where)
        ->order("id desc")
        ->select();

        if ($list) {
            for($i=0;$i<count($list);$i++){
                $list[$i]['report'] = htmlspecialchars_decode($list[$i]['report']);
            }
            $this->success("成功", ['list' => $list,'total' => $total]);
        }
        $this->success("成功", ['list' => array(),'total' => 0]);
    }



    public function setReport()
    {
        $patient_id = $this->request->post("patient_id");
        $type = $this->request->post("type");
        $report = $this->request->post("report");

        if (!$patient_id || !$type|| !$report) {
            $this->error("参数不正确");
        }
        $params = array(
            'patient_id'=>$patient_id,
            'type'=>$type,
            'report'=>$report,
        );
        $params['createtime'] = time();
        if ($params) {
            model('app\admin\model\MedicalPatientReport')->save($params);
            $this->setPoint($patient_id,'健康评估',2);

            //评估量表增加对应数据提交
            $path = "createscale";
            $data = [
                "patientid" => $patient_id,
                "type" => $type,
                "report" => $report,
            ];
            $this->eastReq($path, $data);


            $this->success();
        }
    }




    public function getPoint()
    {
        $patient_id = $this->request->post("patient_id");
        $type = $this->request->post("type");
        
        if (!$patient_id) {
            $this->error("参数不正确");
        }
        $where = array(
            'patient_id' => $patient_id
        );
        if($type){
            $where['type'] =  $type;
        }

        $sum = model('app\admin\model\MedicalPoint')
        ->where($where)
        ->sum('point');

        $list = model('app\admin\model\MedicalPoint')
        ->where($where)
        ->order("id desc")
        ->select();

        if ($list) {
            $this->success("成功", ['list' => $list,'sum' => $sum]);
        }
        $this->success("成功", ['list' => array(),'total' => 0]);
    }



    private function setPoint($patient_id,$type,$point)
    {
        $params = array(
            'patient_id'=>$patient_id,
            'type'=>$type,
            'point'=>$point,
        );
        $params['createtime'] = time();
        if ($params) {
            model('app\admin\model\MedicalPoint')->save($params);
        }
    }

    public function setPoint1()
    {
        $patient_id = $this->request->post("patient_id");
        $type = $this->request->post("type");
        $point = $this->request->post("point");
        $params = array(
            'patient_id'=>$patient_id,
            'type'=>$type,
            'point'=>$point,
        );
        $params['createtime'] = time();
        if ($params) {
            model('app\admin\model\MedicalPoint')->save($params);
        }
    }

    //获取更多信息
    public function getUserStatistics()
    {

        $patient_id = $this->request->post("patient_id");
        $user_id = $this->auth->id;
        if (!$patient_id || !$user_id) {
            $this->error("参数不正确");
        }

        //获取自然周起止时间
        $strat_week =  mktime(0, 0 , 0,date("m"),date("d")-date("w")+1,date("Y"));
        $end_week =  mktime(23,59,59,date("m"),date("d")-date("w")+7,date("Y"));

        //获取签到率
        $mC = new MedicalPatientClock();
        $mc = $mC->where("patient_id", "=", $patient_id)
            ->where("sign_time", ">=", $strat_week)
            ->where("sign_time", "<=", $end_week)
            ->count();
        $signP = ceil(($mc*100)/14);

        //获取总积分数
        $mP = new MedicalPoint();
        $mp = $mP->where("patient_id", "=", $patient_id)
            ->sum("point");

        //获取评估数需要确认
        $mPat = new MedicalPatientReport();
        $m1 = $mPat->where("patient_id", "=", $patient_id)
            ->where("createtime", ">=", $strat_week)
            ->where("createtime", "<=", $end_week)
            ->count();
        $m2 = 0;
        if ($m1 > 1) {
            $m2 = 100;
        }

        //获取本周内留言次数
        $mQ = new MedicalPatientqa();
        $mq_count = $mQ->where("patient_id", "=", $patient_id)
            ->where("createtime", ">=", $strat_week)
            ->where("createtime", "<=", $end_week)
            ->count();

        //获取本周内总的阅读文章数
        $aA = new ArchivesAction();
        $read_count = $aA->where("user_id", "=", $user_id)
            ->where("createtime", ">=", $strat_week)
            ->where("createtime", "<=", $end_week)
            ->where("action", "=", "view")
            ->count();

        $resp = [
            'point' => $mp,
            'sign' => $signP,
            'assess' => $m2,
            'leave_message' => $mq_count,
            'read_count' => $read_count,
        ];

        $this->success("成功", $resp);


    }

    public function updateSignTime() {
        $mC = new MedicalPatientClock();
        $rows = $mC->all();
        foreach ( $rows as $v) {
            $mC1 = new MedicalPatientClock();
            if ($v["y"] && $v["m"] && $v["d"]) {

                if ($v["m"] < 10 ) {
                    $v["m"] = "0".$v["m"];
                }
                if ($v["d"] < 10 ) {
                    $v["d"] = "0".$v["d"];
                }
                $ymd = $v["y"]."-". $v["m"]."-".$v["d"];
                $p["sign_time"] = strtotime($ymd);

                $mC1->where("id", "=", $v['id'])->setField($p);
            }
        }
    }

    
}
