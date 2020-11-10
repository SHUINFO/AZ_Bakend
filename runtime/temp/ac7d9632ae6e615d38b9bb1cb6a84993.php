<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:83:"/data/wwwroot/az-ips.wxhoutai.com/public/../application/admin/view/patient/add.html";i:1598362399;s:76:"/data/wwwroot/az-ips.wxhoutai.com/application/admin/view/layout/default.html";i:1598331185;s:73:"/data/wwwroot/az-ips.wxhoutai.com/application/admin/view/common/meta.html";i:1598331185;s:75:"/data/wwwroot/az-ips.wxhoutai.com/application/admin/view/common/script.html";i:1598331185;}*/ ?>
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
            <input type="text" class="form-control" id="title" name="row[name]" value="" data-rule="required" />
        </div>
    </div>
    <div class="form-group">
        <label for="module" class="control-label col-xs-12 col-sm-2"><?php echo __('Mobile'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="text" class="form-control" id="title" name="row[mobile]" value="" />
        </div>
    </div>
    <div class="form-group">
        <label for="content" class="control-label col-xs-12 col-sm-2"><?php echo __('Gender'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="radio" name="row[gender]" value="1" id="type-text" checked />
            <label for="type-text"><?php echo __('Male'); ?></label>
            <input type="radio" name="row[gender]" value="2" id="type-app" />
            <label for="type-app"><?php echo __('Female'); ?></label>
        </div>
    </div>


    <div class="form-group">
        <label for="content" class="control-label col-xs-12 col-sm-2"><?php echo __('doctor'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="doctor_id" data-source="doctor/index" class="form-control selectpage" name="row[doctor_id]" type="text" value="">
        </div>
    </div>

    <div class="form-group">
        <label for="birth_year" class="control-label col-xs-12 col-sm-2"><?php echo __('Birth_year'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="text" class="form-control" id="age" name="row[birth_year]" value="" />
        </div>
    </div>
    
    <!-- <div class="form-group">
        <label for="content" class="control-label col-xs-12 col-sm-2"><?php echo __('disease'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="radio" name="row[gender]" value="1" id="type-text" checked />
            <label for="type-text"><?php echo __('Male'); ?></label>
            <input type="radio" name="row[gender]" value="2" id="type-app" />
            <label for="type-app"><?php echo __('Female'); ?></label>
        </div>
    </div> -->


    <div class="form-group">
        <label for="disease" class="control-label col-xs-12 col-sm-2"><?php echo __('disease'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="text" class="form-control" id="disease" name="row[disease]" value="" />
        </div>
    </div>

    <div class="form-group">
        <label for="diagnose_at" class="control-label col-xs-12 col-sm-2"><?php echo __('diagnose_at'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="text" class="form-control" id="diagnose_at" name="row[diagnose_at]" value="" />
        </div>
    </div>

    <div class="form-group">
        <label for="content" class="control-label col-xs-12 col-sm-2"><?php echo __('medicine'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="radio" name="row[medicine]" value="1" id="type-text" checked />
            <label for="type-text"><?php echo __('medicine 1'); ?></label>
            <input type="radio" name="row[medicine]" value="2" id="type-app" />
            <label for="type-app"><?php echo __('medicine 2'); ?></label>
        </div>
    </div>


    <div class="form-group">
        <label for="address" class="control-label col-xs-12 col-sm-2"><?php echo __('address'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea name="row[address]" class="form-control"  rows="3"></textarea>
        </div>
    </div>
    
    <div class="form-group">
        <label for="smoke" class="control-label col-xs-12 col-sm-2"><?php echo __('smoke'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="text" class="form-control" id="smoke" name="row[smoke]" value="" />
        </div>
    </div>
	
    <div class="form-group">
        <label for="memo" class="control-label col-xs-12 col-sm-2"><?php echo __('memo'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea name="row[memo]" class="form-control"  rows="10"></textarea>
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