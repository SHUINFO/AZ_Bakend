<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:85:"/data/wwwroot/az-ips.wxhoutai.com/public/../application/admin/view/patient/index.html";i:1602498286;s:76:"/data/wwwroot/az-ips.wxhoutai.com/application/admin/view/layout/default.html";i:1598331185;s:73:"/data/wwwroot/az-ips.wxhoutai.com/application/admin/view/common/meta.html";i:1598331185;s:75:"/data/wwwroot/az-ips.wxhoutai.com/application/admin/view/common/script.html";i:1598331185;}*/ ?>
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
                                <style>
    .profile-avatar-container {
        position: relative;
        width: 100px;
        margin: 0 auto;
    }

    .profile-avatar-container .profile-user-img {
        width: 100px;
        height: 100px;
    }

    .profile-avatar-container .profile-avatar-text {
        display: none;
    }

    .profile-avatar-container:hover .profile-avatar-text {
        display: block;
        position: absolute;
        height: 100px;
        width: 100px;
        background: #444;
        opacity: .6;
        color: #fff;
        top: 0;
        left: 0;
        line-height: 100px;
        text-align: center;
    }

    .profile-avatar-container button {
        position: absolute;
        top: 0;
        left: 0;
        width: 100px;
        height: 100px;
        opacity: 0;
    }

    #patientDetail{
        line-height: 3;
    }
    
</style>
<div class="row animated fadeInRight">
    
    <div class="col-md-8">
        <div class="panel panel-default panel-intro panel-nav">
            <div class="panel-heading">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#one" data-toggle="tab"><i class="fa fa-list"></i> <?php echo __('Patient'); ?></a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="one">
                        <div class="widget-body no-padding">
                            <div id="toolbar" class="toolbar">
                                <?php echo build_toolbar('refresh,add'); ?>
                            </div>
                            <table id="table" class="table table-striped table-bordered table-hover" 
                                   data-operate-edit="<?php echo $auth->check('hospital/edit'); ?>" 
                                   data-operate-del="<?php echo $auth->check('hospital/del'); ?>" 
                                   width="100%">
                            </table>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>


    <div class="col-md-4">
        <div class="box box-success">
            <div class="panel-heading">
                <?php echo __('Detail'); ?>
            </div>
            <div class="panel-body" id="patientDetail">
                    <div class="box-body box-profile">
                    <h3 class="profile-username text-center" data-rel="name"> -- </h3>
                    <p class="text-muted text-center" data-rel="disease"> -- </p>
                    <div class="row">
                        <div class="col-xs-4">
                            <?php echo __('diagnose_at'); ?>
                        </div>
                        <div class="col-xs-8 text-right" data-rel="diagnose_at">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <?php echo __('address'); ?>
                        </div>
                        <div class="col-xs-8 text-right" data-rel="address">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <?php echo __('smoke'); ?>
                        </div>
                        <div class="col-xs-8 text-right" data-rel="smoke">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <?php echo __('medicine'); ?>
                        </div>
                        <div class="col-xs-8 text-right" data-rel="medicine">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <?php echo __('memo'); ?>
                        </div>
                        <div class="col-xs-8 text-right" data-rel="memo">
                            
                        </div>
                    </div>
            </div>
            </div>
        </div>

    </div>

</div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>