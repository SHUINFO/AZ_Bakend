<?php

namespace addons\cms\controller\wxapp;

use addons\cms\model\Block;
use addons\cms\model\Channel;
use app\common\model\Addon;
use fast\Random;
use think\Config;

/**
 * 公共
 */
class Common extends Base
{
    protected $noNeedLogin = '*';

    /**
     * 初始化
     */
    public function init()
    {
        //焦点图
        $bannerList = [];
        $list = Block::getBlockList(['name' => 'indexfocus', 'row' => 5]);
        foreach ($list as $index => $item) {
            $bannerList[] = ['image' => cdnurl($item['image'], true), 'url' => '/', 'title' => $item['title']];
        }

        //首页Tab列表
        $indexTabList = $newsTabList = $productTabList = [['id' => 0, 'title' => '全部']];
        $channelList = Channel::where('status', 'normal')
            ->where('type', 'in', ['list'])
            ->field('id,parent_id,model_id,name,diyname')
            ->order('weigh desc,id desc')
            ->select();
        foreach ($channelList as $index => $item) {
            $data = ['id' => $item['id'], 'title' => $item['name']];
            $indexTabList[] = $data;
            if ($item['model_id'] == 1) {
                $newsTabList[] = $data;
            }
            if ($item['model_id'] == 2) {
                $productTabList[] = $data;
            }
        }

        //配置信息
        $upload = Config::get('upload');
        $upload['cdnurl'] = $upload['cdnurl'] ? $upload['cdnurl'] : cdnurl('', true);
        $upload['uploadurl'] = $upload['uploadurl'] == 'ajax/upload' ? url('api/common/upload', [], '', true) : $upload['uploadurl'];

        $config = [
            'upload' => $upload
        ];

        $data = [
            'bannerList'     => $bannerList,
            'indexTabList'   => $indexTabList,
            'newsTabList'    => $newsTabList,
            'productTabList' => $productTabList,
            'config'         => $config
        ];
        $this->success('', $data);
    }


    //上传图片
    public function upload()
    {
        Config::set('default_return_type', 'json');
        $file = $this->request->file('file');
        if (empty($file)) {
            $this->error(__('No file upload or server upload limit exceeded'));
        }

        //判断是否已经存在附件
        $sha1 = $file->hash();
        $extparam = $this->request->post();

        $upload = Config::get('upload');

        preg_match('/(\d+)(\w+)/', $upload['maxsize'], $matches);
        $type = strtolower($matches[2]);
        $typeDict = ['b' => 0, 'k' => 1, 'kb' => 1, 'm' => 2, 'mb' => 2, 'gb' => 3, 'g' => 3];
        $size = (int)$upload['maxsize'] * pow(1024, isset($typeDict[$type]) ? $typeDict[$type] : 0);
        $fileInfo = $file->getInfo();
        $suffix = strtolower(pathinfo($fileInfo['name'], PATHINFO_EXTENSION));
        $suffix = $suffix && preg_match("/^[a-zA-Z0-9]+$/", $suffix) ? $suffix : 'file';

        $mimetypeArr = explode(',', strtolower($upload['mimetype']));
        $typeArr = explode('/', $fileInfo['type']);

        //禁止上传PHP和HTML文件
        if (in_array($fileInfo['type'], ['text/x-php', 'text/html']) || in_array($suffix, ['php', 'html', 'htm'])) {
            $this->error(__('Uploaded file format is limited'));
        }
        //验证文件后缀
        if ($upload['mimetype'] !== '*' &&
            (
                !in_array($suffix, $mimetypeArr)
                || (stripos($typeArr[0] . '/', $upload['mimetype']) !== false && (!in_array($fileInfo['type'], $mimetypeArr) && !in_array($typeArr[0] . '/*', $mimetypeArr)))
            )
        ) {
            $this->error(__('Uploaded file format is limited'));
        }
        //验证是否为图片文件
        $imagewidth = $imageheight = 0;
        if (in_array($fileInfo['type'], ['image/gif', 'image/jpg', 'image/jpeg', 'image/bmp', 'image/png', 'image/webp']) || in_array($suffix, ['gif', 'jpg', 'jpeg', 'bmp', 'png', 'webp'])) {
            $imgInfo = getimagesize($fileInfo['tmp_name']);
            if (!$imgInfo || !isset($imgInfo[0]) || !isset($imgInfo[1])) {
                $this->error(__('Uploaded file is not a valid image'));
            }
            $imagewidth = isset($imgInfo[0]) ? $imgInfo[0] : $imagewidth;
            $imageheight = isset($imgInfo[1]) ? $imgInfo[1] : $imageheight;
        }
        $replaceArr = [
            '{year}'     => date("Y"),
            '{mon}'      => date("m"),
            '{day}'      => date("d"),
            '{hour}'     => date("H"),
            '{min}'      => date("i"),
            '{sec}'      => date("s"),
            '{random}'   => Random::alnum(16),
            '{random32}' => Random::alnum(32),
            '{filename}' => $suffix ? substr($fileInfo['name'], 0, strripos($fileInfo['name'], '.')) : $fileInfo['name'],
            '{suffix}'   => $suffix,
            '{.suffix}'  => $suffix ? '.' . $suffix : '',
            '{filemd5}'  => md5_file($fileInfo['tmp_name']),
        ];
        $savekey = $upload['savekey'];
        $savekey = str_replace(array_keys($replaceArr), array_values($replaceArr), $savekey);

        $uploadDir = substr($savekey, 0, strripos($savekey, '/') + 1);
        $fileName = substr($savekey, strripos($savekey, '/') + 1);
        //
        $splInfo = $file->validate(['size' => $size])->move(ROOT_PATH . '/public' . $uploadDir, $fileName);
        if ($splInfo) {
            $params = array(
                'admin_id'    => (int)$this->auth->id,
                'user_id'     => 0,
                'filesize'    => $fileInfo['size'],
                'imagewidth'  => $imagewidth,
                'imageheight' => $imageheight,
                'imagetype'   => $suffix,
                'imageframes' => 0,
                'mimetype'    => $fileInfo['type'],
                'url'         => $uploadDir . $splInfo->getSaveName(),
                'uploadtime'  => time(),
                'storage'     => 'local',
                'sha1'        => $sha1,
                'extparam'    => json_encode($extparam),
            );
            $attachment = model("app\common\model\attachment");
            $attachment->data(array_filter($params));
            $attachment->save();
            \think\Hook::listen("upload_after", $attachment);
            //$this->success(__('Upload successful'), null, ['url' => $uploadDir . $splInfo->getSaveName()]);
            $this->success('上传成功', ['url' => $uploadDir . $splInfo->getSaveName()]);
        } else {
            // 上传失败获取错误信息
            $this->error($file->getError());
        }
    }
}
