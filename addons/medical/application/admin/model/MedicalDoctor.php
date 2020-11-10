<?php

namespace app\admin\model;

use think\Model;

class MedicalDoctor extends Model
{

    // 表名,不含前缀
    public $name = 'medical_doctor';
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    // 追加属性
    protected $append = [
    ];

    /**
     * 读取指定配置名称的值
     * @param string $name
     * @return string
     */
    public static function value($name)
    {
        $item = self::get(['name' => $name]);
        return $item ? $item->value : '';
    }
    public function hospital()
    {
        return $this->belongsTo('MedicalHospital', 'hospital_id', 'id', [], 'LEFT')->field('name as hospital')->setEagerlyType(0);
    }
    public function admin()
    {
        return $this->belongsTo('Admin', 'admin_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
