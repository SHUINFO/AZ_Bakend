<?php

namespace addons\cms\model;

use think\Cache;
use think\Db;
use think\Model;
use traits\model\SoftDelete;

/**
 * 文章模型
 */
class PatientCase extends Model
{
    protected $name = "medical_patient_case";
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

    protected static $config = [];
}
