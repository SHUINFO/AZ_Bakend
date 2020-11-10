<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:101:"/Applications/XAMPP/xamppfiles/htdocs/az/ips/public/../application/admin/view/wechat/doctor/edit.html";i:1597142525;s:87:"/Applications/XAMPP/xamppfiles/htdocs/az/ips/application/admin/view/layout/default.html";i:1588765312;s:84:"/Applications/XAMPP/xamppfiles/htdocs/az/ips/application/admin/view/common/meta.html";i:1588765312;s:86:"/Applications/XAMPP/xamppfiles/htdocs/az/ips/application/admin/view/common/script.html";i:1588765312;}*/ ?>
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
                                <form id="add-form" class="form-horizontal form-ajax" role="form" data-toggle="validator" method="POST" action="">
    <div class="form-group">
        <label for="module" class="control-label col-xs-12 col-sm-2"><?php echo __('Name'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="text" class="form-control" id="title" name="row[name]" value="<?php echo $row['name']; ?>" data-rule="required" />
        </div>
    </div>
    <div class="form-group">
        <label for="module" class="control-label col-xs-12 col-sm-2"><?php echo __('Mobile'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="text" class="form-control" id="title" name="row[mobile]" value="<?php echo $row['mobile']; ?>" />
        </div>
    </div>
    <div class="form-group">
        <label for="content" class="control-label col-xs-12 col-sm-2"><?php echo __('Gender'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <?php echo build_radios('row[gender]', ['1' => __('M'), '2' => __('F')], $row['gender']); ?>
        </div>
    </div>

    <div class="form-group">
        <label for="content" class="control-label col-xs-12 col-sm-2"><?php echo __('Category'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <?php echo build_radios('row[category]', ['category1' => __('category1'), 'category2' => __('category2')], $row['category']); ?>
        </div>
    </div>
    
    <div class="form-group">
        <label for="c-avatar" class="control-label col-xs-12 col-sm-2"><?php echo __('Avatar'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-avatar" data-rule="" class="form-control" size="50" name="row[avatar]" type="text" value="<?php echo $row['avatar']; ?>">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-avatar" class="btn btn-danger plupload" data-input-id="c-avatar" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-avatar"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-avatar" class="btn btn-primary fachoose" data-input-id="c-avatar" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-avatar"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-avatar"></ul>
        </div>
    </div>
    
    <div class="form-group">
        <label for="c-wxgroup_qr" class="control-label col-xs-12 col-sm-2"><?php echo __('wxgroup_qr'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-wxgroup_qr" data-rule="" class="form-control" size="50" name="row[wxgroup_qr]" type="text" value="<?php echo $row['wxgroup_qr']; ?>">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-wxgroup_qr" class="btn btn-danger plupload" data-input-id="c-wxgroup_qr" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-wxgroup_qr"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-wxgroup_qr" class="btn btn-primary fachoose" data-input-id="c-wxgroup_qr" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-wxgroup_qr"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-wxgroup_qr"></ul>
        </div>
    </div>

    <div class="form-group hide layer-footer">
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