<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:93:"/data/wwwroot/az-ips.wxhoutai.com/public/../application/admin/view/general/profile/index.html";i:1598331188;s:76:"/data/wwwroot/az-ips.wxhoutai.com/application/admin/view/layout/default.html";i:1598331185;s:73:"/data/wwwroot/az-ips.wxhoutai.com/application/admin/view/common/meta.html";i:1598331185;s:75:"/data/wwwroot/az-ips.wxhoutai.com/application/admin/view/common/script.html";i:1598331185;}*/ ?>
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
</style>
<div class="row animated fadeInRight">
    <div class="col-md-4">
        <div class="box box-success">
            <div class="panel-heading">
                <?php echo __('Profile'); ?>
            </div>
            <div class="panel-body">
                <form id="update-form" role="form" data-toggle="validator" method="POST" action="<?php echo url('general.profile/update'); ?>">
                    <?php echo token(); ?>
                    <input type="hidden" id="c-avatar" name="row[avatar]" value="<?php echo htmlentities($admin['avatar']); ?>"/>
                    <div class="box-body box-profile">

                        <div class="profile-avatar-container">
                            <img class="profile-user-img img-responsive img-circle plupload" src="<?php echo htmlentities(cdnurl($admin['avatar'])); ?>" alt="">
                            <div class="profile-avatar-text img-circle"><?php echo __('Click to edit'); ?></div>
                            <button id="plupload-avatar" class="plupload" data-input-id="c-avatar"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button>
                        </div>

                        <h3 class="profile-username text-center"><?php echo htmlentities($admin['username']); ?></h3>

                        <p class="text-muted text-center"><?php echo htmlentities($admin['email']); ?></p>
                        <div class="form-group">
                            <label for="username" class="control-label"><?php echo __('Username'); ?>:</label>
                            <input type="text" class="form-control" id="username" name="row[username]" value="<?php echo htmlentities($admin['username']); ?>" disabled/>
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label"><?php echo __('Email'); ?>:</label>
                            <input type="text" class="form-control" id="email" name="row[email]" value="<?php echo htmlentities($admin['email']); ?>" data-rule="required;email"/>
                        </div>
                        <div class="form-group">
                            <label for="nickname" class="control-label"><?php echo __('Nickname'); ?>:</label>
                            <input type="text" class="form-control" id="nickname" name="row[nickname]" value="<?php echo htmlentities($admin['nickname']); ?>" data-rule="required"/>
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label"><?php echo __('Password'); ?>:</label>
                            <input type="password" class="form-control" id="password" placeholder="<?php echo __('Leave password blank if dont want to change'); ?>" autocomplete="new-password" name="row[password]" value="" data-rule="password"/>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success"><?php echo __('Submit'); ?></button>
                            <button type="reset" class="btn btn-default"><?php echo __('Reset'); ?></button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>


    <?php if($isDoctor): ?>
    <div class="col-md-8">
        <div class="box box-success">
            <div class="panel-heading">
                <?php echo __('Detail'); ?>
            </div>
            <div class="panel-body">
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
                            <?php echo build_radios('row[gender]', ['1' => __('Male'), '2' => __('Female')], $row['gender']); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="wxid" class="control-label col-xs-12 col-sm-2"><?php echo __('wxid'); ?>:</label>
                        <div class="col-xs-12 col-sm-8">
                            <input type="text" class="form-control" id="wxid" name="row[wxid]" value="<?php echo $row['wxid']; ?>" />
                        </div>
                    </div>
                
                    <div class="form-group">
                        <label for="content" class="control-label col-xs-12 col-sm-2"><?php echo __('hospital'); ?>:</label>
                        <div class="col-xs-12 col-sm-8">
                            <input id="hospital_id" data-source="hospital/index" value="<?php echo $row['hospital_id']; ?>" class="form-control selectpage" name="row[hospital_id]" type="text" value="">
                        </div>
                    </div>
                
                    <div class="form-group">
                        <label for="title" class="control-label col-xs-12 col-sm-2"><?php echo __('title'); ?>:</label>
                        <div class="col-xs-12 col-sm-8">
                            <input type="text" class="form-control" id="title" name="row[title]" value="<?php echo $row['title']; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="position" class="control-label col-xs-12 col-sm-2"><?php echo __('position'); ?>:</label>
                        <div class="col-xs-12 col-sm-8">
                            <input type="text" class="form-control" id="position" name="row[position]" value="<?php echo $row['position']; ?>" />
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
                
                
                    <div class="form-group">
                        <label for="c-avatar" class="control-label col-xs-12 col-sm-2"><?php echo __('wxgzh_qr'); ?>:</label>
                        <div class="col-xs-12 col-sm-8">
                            <div class="input-group">
                                <input id="c-wxgzh_qr" data-rule="" class="form-control" size="50" name="row[wxgzh_qr]" type="text" value="<?php echo $row['wxgzh_qr']; ?>">
                                <div class="input-group-addon no-border no-padding">
                                    <span><button type="button" id="plupload-wxgzh_qr" class="btn btn-danger plupload" data-input-id="c-wxgzh_qr" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-wxgzh_qr"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                                    <span><button type="button" id="fachoose-wxgzh_qr" class="btn btn-primary fachoose" data-input-id="c-wxgzh_qr" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                                </div>
                                <span class="msg-box n-right" for="c-wxgzh_qr"></span>
                            </div>
                            <ul class="row list-inline plupload-preview" id="p-wxgzh_qr"></ul>
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
    <?php else: ?>
    <div class="col-md-8">
        <div class="panel panel-default panel-intro panel-nav">
            <div class="panel-heading">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#one" data-toggle="tab"><i class="fa fa-list"></i> <?php echo __('Admin log'); ?></a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="one">
                        <div class="widget-body no-padding">
                            <div id="toolbar" class="toolbar">
                                <?php echo build_toolbar('refresh'); ?>
                            </div>
                            <table id="table" class="table table-striped table-bordered table-hover" width="100%">

                            </table>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
    <?php endif; ?>


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