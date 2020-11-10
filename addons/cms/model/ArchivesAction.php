<?php

namespace addons\cms\model;

use think\Cache;
use think\Db;
use think\Model;
use traits\model\SoftDelete;

/**
 * 文章模型
 */
class ArchivesAction extends Model
{
    protected $name = "cms_archives_action";
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

    protected static $config = [];
}
