<?php

namespace app\admin\model\xunsearch;

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
        self::beforeInsert(function ($row) {
            if (in_array($row['type'], ['id', 'title', 'body'])) {
                $exist = Db::name("xunsearch_fields")->where('project_id', $row['project_id'])->where(['type' => $row['type']])->find();
                if ($exist) {
                    throw new Exception("已经存在同类型的字段：{$exist['name']}");
                }
            }
        });
        self::beforeUpdate(function ($row) {
            $changedData = $row->getChangedData();
            if (isset($changedData['type'])) {
                if (in_array($changedData['type'], ['id', 'title', 'body'])) {
                    $exist = Db::name("xunsearch_fields")->where('project_id', $row['project_id'])->where(['type' => $changedData['type']])->where('id', '<>', $row['id'])->find();
                    if ($exist) {
                        throw new Exception("已经存在同类型的字段：{$exist['name']}");
                    }
                }
            }
        });
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
