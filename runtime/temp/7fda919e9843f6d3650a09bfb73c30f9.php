<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:89:"/data/wwwroot/az-ips.wxhoutai.com/public/../application/admin/view/patientqa/history.html";i:1602498286;s:76:"/data/wwwroot/az-ips.wxhoutai.com/application/admin/view/layout/default.html";i:1598331185;s:73:"/data/wwwroot/az-ips.wxhoutai.com/application/admin/view/common/meta.html";i:1598331185;s:75:"/data/wwwroot/az-ips.wxhoutai.com/application/admin/view/common/script.html";i:1598331185;}*/ ?>
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
    .main-timeline{
    overflow:hidden;
    position:relative;
}
.main-timeline:before{
    content:"";
    width:3px;
    height:100%;
    background:#d6d5d5;
    position:absolute;
    top:0;
    left:50%;
}
.main-timeline .timeline{
    padding-right:30px;
    position:relative;
}
.main-timeline .timeline:before,.main-timeline .timeline:after{
    content:"";
    display:block;
    width:100%;
    clear:both;
}
.main-timeline .timeline:first-child:before,.main-timeline .timeline:last-child:before{
    content:"";
    width:13px;
    height:13px;
    border-radius:50%;
    border:2px solid #d6d5d5;
    background:#eee;
    margin:0 auto;
    position:absolute;
    top:0;
    left:0;
    right:-3px;
}
.main-timeline .timeline:last-child:before{
    top:auto;
    bottom:0;
}


.main-timeline .timeline:nth-child(2n){
    padding:0 0 0 30px;
}
.main-timeline .timeline:nth-child(2n) .year{
    border-radius:3px 0 0 3px;
    right:auto;
    left:22%;
}
.main-timeline .timeline:nth-child(2n) .year:before{
    border:18px solid transparent;
    border-right:none;
    border-left:18px solid #737ab4;
    left:auto;
    right:-18px;
}
.main-timeline .timeline:nth-child(2n) .timeline-content{
    float:right;
    margin:0 0 0 20px;
}
.main-timeline .timeline:nth-child(2n) .timeline-content:after{
    border-left:none;
    border-right:20px solid #eee;
    right:auto;
    left:-20px;
}

/* .main-timeline .timeline:nth-child(2n+1){
    padding:0 0 0 30px;
}
.main-timeline .timeline:nth-child(2n+1) .year{
    border-radius:3px 0 0 3px;
    right:auto;
    left:32%;
}
.main-timeline .timeline:nth-child(2n+1) .year:before{
    border:18px solid transparent;
    border-right:none;
    border-left:18px solid #737ab4;
    left:auto;
    right:-18px;
}
.main-timeline .timeline:nth-child(2n+1) .timeline-content{
    float:right;
    margin:0 0 0 20px;
}
.main-timeline .timeline:nth-child(2n+1) .timeline-content:after{
    border-left:none;
    border-right:20px solid #eee;
    right:auto;
    left:-20px;
} */


.main-timeline .timeline-icon{
    width:18px;
    height:18px;
    border-radius:50%;
    background:#eee;
    border:2px solid #d6d5d5;
    box-sizing:content-box;
    margin:auto;
    position:absolute;
    top:0;
    left:0;
    bottom:0;
    right:-4px;
}
.main-timeline .timeline-icon:before{
    content:"";
    display:block;
    width:8px;
    height:8px;
    border-radius:50%;
    background:#737ab4;
    margin:auto;
    position:absolute;
    top:0;
    left:0;
    bottom:0;
    right:0;
}
.main-timeline .year{
    display:inline-block;
    border-radius:0 3px 3px 0;
    padding:8px 30px 8px 20px;
    margin:0;
    font-size:14px;
    color:#eee;
    background:#737ab4;
    text-align:center;
    position:absolute;
    top:50%;
    right:22%;
    transform:translateY(-50%);
}
.main-timeline .year:before{
    content:"";
    border-right:18px solid #737ab4;
    border-top:18px solid transparent;
    border-bottom:18px solid transparent;
    position:absolute;
    top:0;
    left:-18px;
}
.main-timeline .timeline-content{
    width:46.5%;
    padding:33px 40px;
    margin:0 20px 0 0;
    background:#eee;
    position:relative;
}
.main-timeline .timeline-content:after{
    content:"";
    border-left:20px solid #eee;
    border-top:20px solid transparent;
    border-bottom:20px solid transparent;
    position:absolute;
    top:50%;
    right:-20px;
    transform:translateY(-50%);
}
.main-timeline .timeline:before{
    background:inherit;
}
.main-timeline .title{
    float:left;
    font-size:24px;
    font-weight:bold;
    color:#504f54;
    margin:0 15px 15px 0;
    line-height:1.1;
}
.main-timeline .post{
    display:inline-block;
    font-size:14px;
    color:#999;
    margin-top:6px;
}
.main-timeline .description{
    clear:both;
    font-size:14px;
    color:#7d7b7b;
    line-height:24px;
    margin:0;
}
</style>

<div class="row">
    <div class="col-md-12">
        <div class="box box-success">
                <div class="panel-body" >
                <div class="main-timeline">
                <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): if( count($list)==0 ) : echo "" ;else: foreach($list as $k=>$vo): ?>
                <div class="timeline ">
                    <span class="timeline-icon"></span> 
                    <span class="year"><?php echo $vo['createtime']; ?></span> 
                    <div class="timeline-content"> 
                    <div class="description">问:<?php echo $vo['question']; ?></div> 

                    <div class="description">
                        <?php if($vo['answer']): ?>
                        <?php echo $vo['answer']; else: ?>
                        <a href="patientqa/edit/ids/<?php echo $vo['id']; ?>" class="btn btn-xs btn-success btn-editone btn-dialog" data-original-title="编辑">去回答</a>
                        <?php endif; ?>
                    </div> 

                    </div> 
                </div>
                <?php endforeach; endif; else: echo "" ;endif; ?>
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