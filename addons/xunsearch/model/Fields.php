<?php

namespace addons\xunsearch\model;

use think\Db;
use think\Exception;
use think\Model;


class Fields extends Model
{

    // 表名
    protected $name = 'xunsearch_fields';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'type_text',
        'index_text',
        'phrase_text',
        'non_bool_text',
        'status_text'
    ];

    public static function init()
    {

    }


    public function getTypeList()
    {
        return ['string' => 'string', 'numeric' => 'numeric', 'date' => 'date', 'id' => 'id', 'title' => 'title', 'body' => 'body'];
    }

    public function getIndexList()
    {
        return ['none' => 'none', 'self' => 'self', 'mixed' => 'mixed', 'both' => 'Both'];
    }

    public function getPhraseList()
    {
        return ['yes' => __('Yes'), 'no' => __('No')];
    }

    public function getNonBoolList()
    {
        return ['yes' => __('Yes'), 'no' => __('No')];
    }

    public function getStatusList()
    {
        return ['normal' => __('Normal'), 'hidden' => __('Hidden')];
    }


    public function getTypeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['type']) ? $data['type'] : '');
        $list = $this->getTypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getIndexTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['index']) ? $data['index'] : '');
        $list = $this->getIndexList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getPhraseTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['phrase']) ? $data['phrase'] : '');
        $list = $this->getPhraseList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getNonBoolTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['non_bool']) ? $data['non_bool'] : '');
        $list = $this->getNonBoolList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }


}
