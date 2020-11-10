<?php

namespace addons\medical;

use app\common\library\Menu;
use think\Addons;

/**
 * 插件
 */
class Medical extends Addons
{

    /**
     * 插件安装方法
     * @return bool
     */
    public function install()
    {
        
        $menu = [
            [
                'name'    => 'hospital',
                'title'   => '医院管理',
                'icon'    => 'fa fa-list fa-tw',
                'sublist' => [
                    ['name' => 'hospital/index', 'title' => '查看'],
                    ['name' => 'hospital/add', 'title' => '添加'],
                    ['name' => 'hospital/edit', 'title' => '修改'],
                    ['name' => 'hospital/del', 'title' => '删除']
                ]
            ],
            [
                'name'    => 'doctor',
                'title'   => '医生管理',
                'icon'    => 'fa fa-cog',
                'sublist' => [
                    ['name' => 'doctor/index', 'title' => '查看'],
                    ['name' => 'doctor/add', 'title' => '添加'],
                    ['name' => 'doctor/edit', 'title' => '修改'],
                    ['name' => 'doctor/del', 'title' => '删除'],
                    ['name' => 'doctor/multi', 'title' => '批量更新'],
                ]
            ],
            [
                'name'    => 'patient',
                'title'   => '患者管理',
                'icon'    => 'fa fa-list fa-tw',
                'sublist' => [
                        
                    ['name' => 'patient/index', 'title' => '查看'],
                    ['name' => 'patient/add', 'title' => '添加'],
                    ['name' => 'patient/edit', 'title' => '修改'],
                    ['name' => 'patient/del', 'title' => '删除']
                ]
            ],
            [
                'name'    => 'patientqa',
                'title'   => '咨询管理',
                'icon'    => 'fa fa-list fa-tw',
                'sublist' => [
                        
                    ['name' => 'patientqa/index', 'title' => '查看'],
                    ['name' => 'patientqa/add', 'title' => '添加'],
                    ['name' => 'patientqa/edit', 'title' => '回复'],
                    ['name' => 'patientqa/history', 'title' => '历史'],
                    ['name' => 'patientqa/del', 'title' => '删除']
                ]
            ]
        ];
        Menu::create($menu);
        return true;
    }

    /**
     * 插件卸载方法
     * @return bool
     */
    public function uninstall()
    {
        Menu::delete('hospital');
        Menu::delete('doctor');
        Menu::delete('patient');
        return true;
    }

    /**
     * 插件启用方法
     */
    public function enable()
    {
        Menu::enable('hospital');
        Menu::enable('doctor');
        Menu::enable('patient');
    }

    /**
     * 插件禁用方法
     */
    public function disable()
    {
        Menu::disable('hospital');
        Menu::disable('doctor');
        Menu::disable('patient');
    }

    /**
     * 实现钩子方法
     * @return mixed
     */
    public function testhook($param)
    {
        // 调用钩子时候的参数信息
        print_r($param);
        // 当前插件的配置信息，配置信息存在当前目录的config.php文件中，见下方
        print_r($this->getConfig());
        // 可以返回模板，模板文件默认读取的为插件目录中的文件。模板名不能为空！
        //return $this->fetch('view/info');
    }

}