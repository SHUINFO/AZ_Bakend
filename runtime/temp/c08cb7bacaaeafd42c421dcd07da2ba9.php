<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:86:"/data/wwwroot/az-ips.wxhoutai.com/public/../application/admin/view/auth/admin/add.html";i:1598331187;s:76:"/data/wwwroot/az-ips.wxhoutai.com/application/admin/view/layout/default.html";i:1598331185;s:73:"/data/wwwroot/az-ips.wxhoutai.com/application/admin/view/common/meta.html";i:1598331185;s:75:"/data/wwwroot/az-ips.wxhoutai.com/application/admin/view/common/script.html";i:1598331185;}*/ ?>
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
    <?php echo token(); ?>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Group'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <?php echo build_select('group[]', $groupdata, null, ['id'=>'group','class'=>'form-control selectpicker', 'data-rule'=>'required']); ?>
        </div>
    </div>
    <div class="form-group">
        <label for="username" class="control-label col-xs-12 col-sm-2"><?php echo __('Username'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="text" class="form-control" id="username" name="row[username]" value="" data-rule="required;username" />
        </div>
    </div>
    <div class="form-group">
        <label for="email" class="control-label col-xs-12 col-sm-2">手机:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="email" class="form-control" id="email" name="row[email]" value="" data-rule="" />
        </div>
    </div>
    <div class="form-group">
        <label for="nickname" class="control-label col-xs-12 col-sm-2"><?php echo __('Nickname'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="text" class="form-control" id="nickname" name="row[nickname]" autocomplete="off" value="" data-rule="required" />
        </div>
    </div>
    <div class="form-group">
        <label for="password" class="control-label col-xs-12 col-sm-2"><?php echo __('Password'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="password" class="form-control" id="password" name="row[password]" autocomplete="new-password" value="" data-rule="required;password" />
        </div>
    </div>
    <div class="form-group">
        <label for="content" class="control-label col-xs-12 col-sm-2"><?php echo __('Assistant'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="assistant_id" data-source="auth/admin/assistant" class="form-control selectpage" name="row[assistant_id]" type="text" value="">
        </div>
    </div>
    <div class="form-group hidden">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Status'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <?php echo build_radios('row[status]', ['normal'=>__('Normal'), 'hidden'=>__('Hidden')]); ?>
        </div>
    </div>
    <div class="form-group hidden layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
    <input type="hidden" id="doctor_groupid" value="<?php echo $doctor_groupid; ?>" />
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