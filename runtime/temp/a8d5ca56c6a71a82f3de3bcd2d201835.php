<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:94:"/data/wwwroot/az-ips.wxhoutai.com/public/../application/admin/view/xunsearch/project/edit.html";i:1598334946;s:76:"/data/wwwroot/az-ips.wxhoutai.com/application/admin/view/layout/default.html";i:1598331185;s:73:"/data/wwwroot/az-ips.wxhoutai.com/application/admin/view/common/meta.html";i:1598331185;s:75:"/data/wwwroot/az-ips.wxhoutai.com/application/admin/view/common/script.html";i:1598331185;}*/ ?>
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
                                <form id="edit-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">
    <input type="hidden" id="project-id" name="" value="<?php echo $row['id']; ?>">
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Name'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-name" class="form-control" name="row[name]" type="text" data-rule="required;username;name" value="<?php echo htmlentities($row['name']); ?>" <?php if($row['isaddon']): ?>readonly<?php endif; ?>>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Title'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-title" class="form-control" name="row[title]" type="text" value="<?php echo htmlentities($row['title']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Charset'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-charset" class="form-control" name="row[charset]" type="text" readonly value="<?php echo htmlentities($row['charset']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Serverindex'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-serverindex" class="form-control" name="row[serverindex]" type="text" value="<?php echo htmlentities($row['serverindex']); ?>">
            <div class="alert alert-danger-light" style="margin-top:5px;">
                端口号(数字)，连接 localhost 的该端口号 (例：8383)<br>
                地址:端口号，冒号连接地址（域名、IP地址）和端口 (例：127.0.0.1:8383)<br>
                文件路径，本机的 unix socket 连接路径 (例：/tmp/index.sock)
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Serversearch'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-serversearch" class="form-control" name="row[serversearch]" type="text" value="<?php echo htmlentities($row['serversearch']); ?>">
            <div class="alert alert-danger-light" style="margin-top:5px;">
                端口号(数字)，连接 localhost 的该端口号 (例：8384)<br>
                地址:端口号，冒号连接地址（域名、IP地址）和端口 (例：127.0.0.1:8384)<br>
                文件路径，本机的 unix socket 连接路径 (例：/tmp/search.sock)
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Logo'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-logo" class="form-control" size="50" name="row[logo]" type="text" value="<?php echo htmlentities($row['logo']); ?>" placeholder="留空将使用默认Logo，建议至少100px*100px">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-image" class="btn btn-danger plupload" data-input-id="c-logo" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-logo"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-image" class="btn btn-primary fachoose" data-input-id="c-logo" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-logo"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-logo"></ul>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Indextpl'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-indextpl" class="form-control" name="row[indextpl]" type="text" value="<?php echo htmlentities($row['indextpl']); ?>" placeholder="留空将使用默认模板">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Listtpl'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-listtpl" class="form-control" name="row[listtpl]" type="text" value="<?php echo htmlentities($row['listtpl']); ?>" placeholder="留空将使用默认模板">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Pagesize'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-pagesize" class="form-control" name="row[pagesize]" type="number" value="<?php echo htmlentities($row['pagesize']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Isfrontend'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input  id="c-isfrontend" name="row[isfrontend]" type="hidden" value="1">
            <a href="javascript:;" data-toggle="switcher" class="btn-switcher" data-input-id="c-isfrontend" data-yes="1" data-no="0" >
                <i class="fa fa-toggle-on text-success <?php if($row['isfrontend'] == '0'): ?>fa-flip-horizontal text-gray<?php endif; ?> fa-2x"></i>
            </a>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Isfuzzy'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input  id="c-isfuzzy" name="row[isfuzzy]" type="hidden" value="<?php echo $row['isfuzzy']; ?>">
            <a href="javascript:;" data-toggle="switcher" class="btn-switcher" data-input-id="c-isfuzzy" data-yes="1" data-no="0" >
                <i class="fa fa-toggle-on text-success <?php if($row['isfuzzy'] == '0'): ?>fa-flip-horizontal text-gray<?php endif; ?> fa-2x"></i>
            </a>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Issynonyms'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input  id="c-issynonyms" name="row[issynonyms]" type="hidden" value="<?php echo $row['issynonyms']; ?>">
            <a href="javascript:;" data-toggle="switcher" class="btn-switcher" data-input-id="c-issynonyms" data-yes="1" data-no="0" >
                <i class="fa fa-toggle-on text-success <?php if($row['issynonyms'] == '0'): ?>fa-flip-horizontal text-gray<?php endif; ?> fa-2x"></i>
            </a>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Isindexhotwords'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input  id="c-isindexhotwords" name="row[isindexhotwords]" type="hidden" value="<?php echo $row['isindexhotwords']; ?>">
            <a href="javascript:;" data-toggle="switcher" class="btn-switcher" data-input-id="c-isindexhotwords" data-yes="1" data-no="0" >
                <i class="fa fa-toggle-on text-success <?php if($row['isindexhotwords'] == '0'): ?>fa-flip-horizontal text-gray<?php endif; ?> fa-2x"></i>
            </a>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Ishotwords'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input  id="c-ishotwords" name="row[ishotwords]" type="hidden" value="<?php echo $row['ishotwords']; ?>">
            <a href="javascript:;" data-toggle="switcher" class="btn-switcher" data-input-id="c-ishotwords" data-yes="1" data-no="0" >
                <i class="fa fa-toggle-on text-success <?php if($row['ishotwords'] == '0'): ?>fa-flip-horizontal text-gray<?php endif; ?> fa-2x"></i>
            </a>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Isrelatedwords'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input  id="c-isrelatedwords" name="row[isrelatedwords]" type="hidden" value="<?php echo $row['isrelatedwords']; ?>">
            <a href="javascript:;" data-toggle="switcher" class="btn-switcher" data-input-id="c-isrelatedwords" data-yes="1" data-no="0" >
                <i class="fa fa-toggle-on text-success <?php if($row['isrelatedwords'] == '0'): ?>fa-flip-horizontal text-gray<?php endif; ?> fa-2x"></i>
            </a>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Status'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            
            <div class="radio">
            <?php if(is_array($statusList) || $statusList instanceof \think\Collection || $statusList instanceof \think\Paginator): if( count($statusList)==0 ) : echo "" ;else: foreach($statusList as $key=>$vo): ?>
            <label for="row[status]-<?php echo $key; ?>"><input id="row[status]-<?php echo $key; ?>" name="row[status]" type="radio" value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['status'])?$row['status']:explode(',',$row['status']))): ?>checked<?php endif; ?> /> <?php echo $vo; ?></label> 
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>

        </div>
    </div>
    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
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