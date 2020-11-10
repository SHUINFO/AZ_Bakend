<?php

namespace addons\cms\controller\wxapp;

use addons\cms\model\Comment;
use addons\cms\model\Page;
use addons\cms\model\PatientCase;

/**
 * 我的
 */
class My extends Base
{
    protected $noNeedLogin = ['aboutus'];

    /**
     * 我发表的评论
     */
    public function comment()
    {
        $page = (int)$this->request->request('page');
        $commentList = Comment::
        with('archives')
            ->where(['user_id' => $this->auth->id])
            ->order('id desc')
            ->page($page, 10)
            ->select();
        foreach ($commentList as $index => $item) {
            $item->create_date = human_date($item->createtime);
        }

        $this->success('', ['commentList' => $commentList]);
    }

    /**
     * 关于我们
     */
    public function aboutus()
    {
        $pageInfo = Page::getByDiyname('aboutus');
        if (!$pageInfo || $pageInfo['status'] != 'normal') {
            $this->error(__('单页未找到'));
        }
        $pageInfo = $pageInfo->toArray();
        unset($pageInfo['status'], $pageInfo['showtpl']);
        $this->success('', ['pageInfo' => $pageInfo]);
    }

    //获取最新上传病例日期
    public function getLatelyCaseDay() {
        $patient_id = $this->request->post('patient_id');
        if (!$patient_id) {
            $this->error("参数不正确");
        }
        $pCase = new PatientCase();
        $data = $pCase->where("patient_id", "=", $patient_id)->field("add_day")->order("add_day desc")->limit(1)->find();
        $ti = 0;
        if ($data["add_day"]) {
            $ti = strtotime($data["add_day"]);
        }
        $this->success('成功', ['day' => $ti]);
    }

    //上传病例
    public function updateCase() {
        $params['patient_id'] = $this->request->post('patient_id');
        $params['add_day'] = $this->request->post('add_day');
        $params['source'] = $this->request->post('source');
        $params['sub_vister'] = $this->request->post('sub_vister');
        $params['sub_vister_time'] = $this->request->post('sub_vister_time');
        $params['check_list'] = $this->request->post('check_list');
        $params['check_list_imgs'] = $this->request->post('check_list_imgs');
        $params['prescription'] = $this->request->post('prescription');
        $params['prescription_imgs'] = $this->request->post('prescription_imgs');
        $params['case_imgs'] = $this->request->post('case_imgs');

        if (!$params['patient_id'] || !$params['add_day']) {
            $this->error("参数不正确");
        }
        $params['add_day'] = date("Ymd",strtotime($params['add_day']));
        if ($params['sub_vister_time']) {
            $params['sub_vister_time'] = date("Ymd",strtotime($params['sub_vister_time']));
        }
        $pCase = new PatientCase();
        $r = $pCase->save($params);
        if ($r) {
            $this->success('成功');
        } else {
            $this->error('保存失败，请稍后重试！');
        }
    }

    //获取一个人病例
    public function getMyCase() {
        $patient_id = $this->request->post('patient_id');
        if (!$patient_id) {
            $this->error("参数不正确");
        }
        $pCase = new PatientCase();
        $data = $pCase->where("patient_id", "=", $patient_id)->field("add_day,check_list_imgs,prescription_imgs,case_imgs")->order("add_day desc")->limit(200)->select();
        $ret = [];
        if ($data) {
            foreach ($data as $k => $v) {
                $ret[$k]['imgs'] = [];
                $ret[$k]['add_day'] = strtotime($v['add_day']);
                //检验单照片
                if ($v["check_list_imgs"]) {
                    $imgs = explode(",", $v["check_list_imgs"]);
                    foreach ($imgs as $i) {
                        array_push($ret[$k]['imgs'], $i);
                    }

                }

                //药单照片
                if ($v["prescription_imgs"]) {
                    $imgs = explode(",", $v["prescription_imgs"]);
                    foreach ($imgs as $i) {
                        array_push($ret[$k]['imgs'], $i);
                    }

                }

                //病例照片
                if ($v["case_imgs"]) {
                    $imgs = explode(",", $v["case_imgs"]);
                    foreach ($imgs as $i) {
                        array_push($ret[$k]['imgs'], $i);
                    }

                }
            }
        }

        $this->success('成功', ['data' => $ret]);


    }
}
