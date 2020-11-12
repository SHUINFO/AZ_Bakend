<?php

namespace addons\cms\controller\wxapp;

use app\common\controller\Api;
use app\common\library\Auth;
use fast\Http;
use think\Config;
use think\Lang;

class Base extends Api
{
    protected $noNeedLogin = [];
    protected $noNeedRight = ['*'];
    //设置返回的会员字段
    protected $allowFields = ['id', 'username', 'nickname', 'mobile', 'avatar', 'score', 'level', 'bio', 'balance', 'money'];

    public function _initialize()
    {
        parent::_initialize();

        Config::set('default_return_type', 'json');
        Auth::instance()->setAllowFields($this->allowFields);

        //这里手动载入语言包
        Lang::load(ROOT_PATH . '/addons/cms/lang/zh-cn.php');
        Lang::load(APP_PATH . '/index/lang/zh-cn/user.php');
    }

    //远程调用链接
    public static function eastReq($path, $data) {
        $key = "Neusoft123";
        $app_namespace = Config::get("east_soft_url");
        $url = $app_namespace . $path;
        $ti = time();
        $sig = strtolower(md5($key.$ti));
        $data["signature"] = $sig;
        $data["operatime"] = $ti;
        $data["createtime"] = $ti;
        $ret = Http::sendRequestHeader($url, $data, "POST");
        $day = date("Ymd");
        $dir = "logs/".$day."/";
        self::createDir($dir, "0777");
        $r = $data;
        $r["return"] = $ret;
        file_put_contents($dir.$path.".log", json_encode($r));
        return $ret;

    }

    public static function createDir( $dir , $mode = "0777" ) {
        if(strpos($dir , "/" )){
            $dir_path = "" ;
            $dir_info = explode ( "/" , $dir );
            foreach($dir_info  as  $key => $value ){
                $dir_path .= $value ;
                if (!file_exists($dir_path )){
                    @mkdir ( $dir_path , $mode ) or  die ( "建立文件夹时失败了" );
                    @chmod ( $dir_path , $mode );
                } else {
                    $dir_path .= "/" ;
                    continue ;
                }
                $dir_path .= "/" ;
            }
            return $dir_path ;
        } else {
            @mkdir( $dir , $mode ) or die( "建立失败了,请检查权限" );
            @chmod ( $dir , $mode );
            return $dir ;
        }
    }
}
