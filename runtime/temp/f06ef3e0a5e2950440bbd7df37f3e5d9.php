<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:103:"/Applications/XAMPP/xamppfiles/htdocs/az/ips/public/../application/admin/view/wechat/response/edit.html";i:1597130790;s:87:"/Applications/XAMPP/xamppfiles/htdocs/az/ips/application/admin/view/layout/default.html";i:1588765312;s:84:"/Applications/XAMPP/xamppfiles/htdocs/az/ips/application/admin/view/common/meta.html";i:1588765312;s:86:"/Applications/XAMPP/xamppfiles/htdocs/az/ips/application/admin/view/common/script.html";i:1588765312;}*/ ?>
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
                                <form id="edit-form" class="form-horizontal form-ajax" role="form" data-toggle="validator" method="POST" action="">

    <div class="form-group">
        <label for="module" class="control-label col-xs-12 col-sm-2"><?php echo __('Resource title'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="text" class="form-control" id="title" name="row[title]" value="<?php echo $row['title']; ?>" data-rule="required" />
        </div>
    </div>
    <div class="form-group">
        <label for="controller" class="control-label col-xs-12 col-sm-2"><?php echo __('Event key'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input type='text' class="form-control" id="eventkey" name="row[eventkey]" value="<?php echo $row['eventkey']; ?>" data-rule="required" readonly />
        </div>
    </div>
    <div class="form-group">
        <label for="remark" class="control-label col-xs-12 col-sm-2"><?php echo __('Memo'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea class="form-control" id="remark" name="row[remark]"><?php echo $row['remark']; ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label for="content" class="control-label col-xs-12 col-sm-2"><?php echo __('Type'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <?php echo build_radios('row[type]', ['text' => __('Text'), 'app' => __('App')], $row['type']); ?>
        </div>
    </div>
    <div id="expand">

    </div>
    <div class="form-group">
        <div class="col-xs-2"></div>
        <div class="col-xs-12 col-sm-8">
            <?php echo build_radios('row[status]', ['normal'=>__('Normal'), 'hidden'=>__('Hidden')], $row['status']); ?>
        </div>
    </div>
    <div class="form-group hidden layer-footer">
        <div class="col-xs-2"></div>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
    <select name="applist" disabled="true" class="hidden">
        <?php foreach($applist as $k => $v): ?>
            <option value="<?php echo $k; ?>"><?php echo $v['name']; ?></option>
        <?php endforeach; ?>
    </select>
</form>
<script>
    var apps = <?php echo json_encode($applist); ?>;
    var datas = <?php echo $row['content']; ?>;
</script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>