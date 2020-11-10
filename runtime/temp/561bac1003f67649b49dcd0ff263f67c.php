<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:88:"/data/wwwroot/az-ips.wxhoutai.com/public/../application/admin/view/cms/archives/add.html";i:1598363247;s:76:"/data/wwwroot/az-ips.wxhoutai.com/application/admin/view/layout/default.html";i:1598331185;s:73:"/data/wwwroot/az-ips.wxhoutai.com/application/admin/view/common/meta.html";i:1598331185;s:75:"/data/wwwroot/az-ips.wxhoutai.com/application/admin/view/common/script.html";i:1598331185;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">

<link rel="shortcut icon" href="/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="/assets/css/backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/assets/js/html5shiv.js"></script>
  <script src="/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config); ?>
    };
</script>
    </head>

    <body class="inside-header inside-aside <?php echo defined('IS_DIALOG') && IS_DIALOG ? 'is-dialog' : ''; ?>">
        <div id="main" role="main">
            <div class="tab-content tab-addtabs">
                <div id="content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <section class="content-header hide">
                                <h1>
                                    <?php echo __('Dashboard'); ?>
                                    <small><?php echo __('Control panel'); ?></small>
                                </h1>
                            </section>
                            <?php if(!IS_DIALOG && !\think\Config::get('fastadmin.multiplenav')): ?>
                            <!-- RIBBON -->
                            <div id="ribbon">
                                <ol class="breadcrumb pull-left">
                                    <li><a href="dashboard" class="addtabsit"><i class="fa fa-dashboard"></i> <?php echo __('Dashboard'); ?></a></li>
                                </ol>
                                <ol class="breadcrumb pull-right">
                                    <?php foreach($breadcrumb as $vo): ?>
                                    <li><a href="javascript:;" data-url="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a></li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                            <!-- END RIBBON -->
                            <?php endif; ?>
                            <div class="content">
                                <form id="add-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">
    <input type="hidden" name="row[style]" value=""/>
    <div class="row">
        <div class="col-md-9 col-sm-12">
            <div class="panel panel-default panel-intro">
                <div class="panel-heading">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#basic" data-toggle="tab">基础信息</a></li>
                    </ul>
                </div>
                <div class="panel-body">

                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade active in" id="basic">
                            <div class="form-group">
                                <label for="c-channel_id" class="control-label col-xs-12 col-sm-2"><?php echo __('Channel_id'); ?>:</label>
                                <div class="col-xs-12 col-sm-8">
                                    <select id="c-channel_id" data-rule="required" class="form-control selectpicker" data-live-search="true" name="row[channel_id]">
                                        <?php echo $channelOptions; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group hidden">
                                <label for="c-channel_ids" class="control-label col-xs-12 col-sm-2"><?php echo __('Channel_ids'); ?>:</label>
                                <div class="col-xs-12 col-sm-8">
                                    <select id="c-channel_ids" data-rule="" class="form-control selectpicker" multiple data-live-search="true" name="row[channel_ids][]">
                                        <?php echo $secondChannelOptions; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group hidden">
                                <label for="c-user_id" class="control-label col-xs-12 col-sm-2"><?php echo __('User_id'); ?>:</label>
                                <div class="col-xs-12 col-sm-8">
                                    <input id="c-user_id" type="text" class="form-control selectpage" data-source="user/user/index" placeholder="发布会员,可为空" data-field="nickname" name="row[user_id]"/>
                                </div>
                            </div>
                            <div class="form-group hidden">
                                <label for="c-special_ids" class="control-label col-xs-12 col-sm-2"><?php echo __('Special_ids'); ?>:</label>
                                <div class="col-xs-12 col-sm-8">
                                    <input id="c-special_ids" type="text" class="form-control selectpage" data-source="cms/special/index" data-multiple="true" placeholder="所属专题,可为空" data-field="title" name="row[special_ids]"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="c-title" class="control-label col-xs-12 col-sm-2"><?php echo __('Title'); ?>:</label>
                                <div class="col-xs-12 col-sm-8">
                                    <input id="c-title" data-rule="required" class="form-control" name="row[title]" type="text" value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="c-image" class="control-label col-xs-12 col-sm-2"><?php echo __('Image'); ?>:</label>
                                <div class="col-xs-12 col-sm-8">
                                    <div class="input-group">
                                        <input id="c-image" class="form-control" size="50" name="row[image]" type="text" value="" placeholder="缩略图可以直接从正文进行提取,可以为空">
                                        <div class="input-group-addon no-border no-padding">
                                            <span><button type="button" id="plupload-image" class="btn btn-danger plupload" data-input-id="c-image" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-image"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                                            <span><button type="button" id="fachoose-image" class="btn btn-primary fachoose" data-input-id="c-image" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                                        </div>
                                        <span class="msg-box n-right" for="c-image"></span>
                                    </div>
                                    <ul class="row list-inline plupload-preview" id="p-image"></ul>
                                </div>
                            </div>

                            <div class="form-group  hidden">
                                <label for="c-image" class="control-label col-xs-12 col-sm-2"><?php echo __('Images'); ?>:</label>
                                <div class="col-xs-12 col-sm-8">
                                    <div class="input-group">
                                        <input id="c-images" class="form-control" size="50" name="row[images]" type="text" value="" placeholder="组图可以直接从正文进行提取,可以为空">
                                        <div class="input-group-addon no-border no-padding">
                                            <span><button type="button" id="plupload-images" class="btn btn-danger plupload" data-input-id="c-images" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="true" data-preview-id="p-images"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                                            <span><button type="button" id="fachoose-images" class="btn btn-primary fachoose" data-input-id="c-images" data-mimetype="image/*" data-multiple="true"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                                        </div>
                                        <span class="msg-box n-right" for="c-images"></span>
                                    </div>
                                    <ul class="row list-inline plupload-preview" id="p-images"></ul>
                                </div>
                            </div>
                            <div class="form-group  hidden">
                                <label for="c-tags" class="control-label col-xs-12 col-sm-2"><?php echo __('Tags'); ?>:</label>
                                <div class="col-xs-12 col-sm-8">
                                    <input id="c-tags" data-rule="" class="form-control" placeholder="输入后空格确认" name="row[tags]" type="text" value="">
                                </div>
                            </div>

                            <div class="form-group  hidden">
                                <label for="c-diyname" class="control-label col-xs-12 col-sm-2"><?php echo __('Diyname'); ?>:</label>
                                <div class="col-xs-12 col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><?php echo addon_url('cms/archives/index', [':diyname'=>'']); ?></button>
                                        </div>
                                        <input type="text" id="c-diyname" data-rule="diyname" name="row[diyname]" class="form-control" placeholder="请输入自定义的名称,为空将使用主键ID"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="c-content" class="control-label col-xs-12 col-sm-2"><?php echo __('Content'); ?>:</label>
                                <div class="col-xs-12 col-sm-8">
                                    <textarea id="c-content" data-rule="" class="form-control editor" name="row[content]" rows="15"></textarea>
                                </div>
                            </div>
                            <div id="extend"></div>
                        </div>
                    </div>
                    <div class="form-group layer-footer">
                        <label class="control-label col-xs-12 col-sm-2"></label>
                        <div class="col-xs-12 col-sm-8">
                            <button type="submit" class="btn btn-success btn-embossed disabled"><i class="fa fa-check"></i> <?php echo __('OK'); ?></button>
                            <button type="button" class="btn btn-info btn-embossed btn-continue"><i class="fa fa-pencil"></i> <?php echo __('Publish and continue'); ?></button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="col-md-3 col-sm-12  hidden">
            <div class="panel panel-default panel-intro">
                <div class="panel-heading">
                    <div class="panel-lead"><em>相关信息</em></div>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="extra">
                            <div class="form-group">
                                <label for="c-views" class="control-label col-xs-12 col-sm-2 col-md-3"><?php echo __('Views'); ?>:</label>
                                <div class="col-xs-12 col-sm-8 col-md-8">
                                    <div class="input-group margin-bottom-sm">

                                        <input id="c-views" data-rule="required" class="form-control" name="row[views]" placeholder="<?php echo __('Views'); ?>" type="number" value="0">
                                        <span class="input-group-addon"><i class="fa fa-eye text-success"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="c-comments" class="control-label col-xs-12 col-sm-2 col-md-3"><?php echo __('Comments'); ?>:</label>
                                <div class="col-xs-12 col-sm-8 col-md-8">
                                    <div class="input-group margin-bottom-sm">

                                        <input id="c-comments" data-rule="required" class="form-control" name="row[comments]" placeholder="<?php echo __('Comments'); ?>" type="number" value="0">
                                        <span class="input-group-addon"><i class="fa fa-comment text-info"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="c-likes" class="control-label col-xs-12 col-sm-2 col-md-3"><?php echo __('Likes'); ?>:</label>
                                <div class="col-xs-12 col-sm-8 col-md-8">
                                    <div class="input-group margin-bottom-sm">

                                        <input id="c-likes" data-rule="required" class="form-control" name="row[likes]" placeholder="<?php echo __('Likes'); ?>" type="number" value="0">
                                        <span class="input-group-addon"><i class="fa fa-thumbs-up text-danger"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="c-dislikes" class="control-label col-xs-12 col-sm-2 col-md-3"><?php echo __('Dislikes'); ?>:</label>
                                <div class="col-xs-12 col-sm-8 col-md-8">
                                    <div class="input-group margin-bottom-sm">
                                        <input id="c-dislikes" data-rule="required" class="form-control" name="row[dislikes]" placeholder="<?php echo __('Dislikes'); ?>" type="number" value="0">
                                        <span class="input-group-addon"><i class="fa fa-thumbs-down text-gray"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="c-weigh" class="control-label col-xs-12 col-sm-2 col-md-3"><?php echo __('Weigh'); ?>:</label>
                                <div class="col-xs-12 col-sm-8 col-md-8">
                                    <input id="c-weigh" data-rule="required" class="form-control" name="row[weigh]" placeholder="<?php echo __('Weigh'); ?>" type="number" value="0">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="panel panel-default panel-intro">
                <div class="panel-heading">
                    <div class="panel-lead"><em>状态</em></div>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="status">
                            <div class="form-group">
                                <label for="c-flag" class="control-label col-xs-12 col-sm-2 col-md-3"><?php echo __('Flag'); ?>:</label>
                                <div class="col-xs-12 col-sm-8 col-md-8">

                                    <!--@formatter:off-->
                                    <select id="c-flag" class="form-control selectpicker" multiple="" name="row[flag][]">
                                        <?php if(is_array($flagList) || $flagList instanceof \think\Collection || $flagList instanceof \think\Paginator): if( count($flagList)==0 ) : echo "" ;else: foreach($flagList as $key=>$vo): ?>
                                        <option value="<?php echo $key; ?>" <?php if(in_array(($key), explode(',',""))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                                        <?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                    <!--@formatter:on-->

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-2 col-md-3"><?php echo __('Status'); ?>:</label>
                                <div class="col-xs-12 col-sm-8 col-md-8">
                                    <!--@formatter:off-->
                                    <select id="c-status" class="form-control selectpicker" name="row[status]">
                                        <?php if(is_array($statusList) || $statusList instanceof \think\Collection || $statusList instanceof \think\Paginator): if( count($statusList)==0 ) : echo "" ;else: foreach($statusList as $key=>$vo): ?>
                                        <option value="<?php echo $key; ?>" <?php if(in_array(($key), explode(',',""))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                                        <?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                    <!--@formatter:on-->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-2 col-md-3"><?php echo __('Isguest'); ?>:</label>
                                <div class="col-xs-12 col-sm-8 col-md-8">
                                    <input id="c-isguest" name="row[isguest]" type="hidden" value="10">
                                    <a href="javascript:;" data-toggle="switcher" class="btn-switcher" data-input-id="c-isguest" data-yes="1" data-no="0">
                                        <i class="fa fa-toggle-on text-success fa-2x"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-2 col-md-3"><?php echo __('Iscomment'); ?>:</label>
                                <div class="col-xs-12 col-sm-8 col-md-8">
                                    <input id="c-iscomment" name="row[iscomment]" type="hidden" value="10">
                                    <a href="javascript:;" data-toggle="switcher" class="btn-switcher" data-input-id="c-iscomment" data-yes="1" data-no="0">
                                        <i class="fa fa-toggle-on text-success fa-2x"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-2 col-md-3"><?php echo __('Publish'); ?>:</label>
                                <div class="col-xs-12 col-sm-8 col-md-8">
                                    <div class='input-group date'>
                                        <input type='text' name="row[publishtime]" data-date-format="YYYY-MM-DD HH:mm:ss" value="<?php echo date('Y-m-d H:i:s'); ?>" class="form-control datetimepicker"/>
                                        <span class="input-group-addon">
                                            <span class="fa fa-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>