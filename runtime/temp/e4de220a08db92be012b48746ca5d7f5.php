<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"/data/wwwroot/az-ips.wxhoutai.com/addons/cms/view/hook/user_sidenav_after.html";i:1600485345;}*/ ?>
<ul class="list-group">
    <li class="list-group-heading"><?php echo __('内容管理'); ?></li>
    <!--如果需要直接跳转对应的模型(比如我的新闻,我的产品,发布新闻,发布产品)，可以在链接后加上 ?model_id=模型ID -->
    <?php if(isset($sidenav) && in_array('myarchives', $sidenav)): ?>
    <li class="list-group-item <?php echo $actionname=='my'?'active':''; ?>"><a href="<?php echo url('index/cms.archives/my'); ?>"><i class="fa fa-newspaper-o fa-fw"></i> <?php echo __('我发布的文章'); ?></a></li>
    <?php endif; if(isset($sidenav) && in_array('postarchives', $sidenav)): ?>
    <li class="list-group-item <?php echo $actionname=='post'?'active':''; ?>"><a href="<?php echo url('index/cms.archives/post'); ?>"><i class="fa fa-pencil fa-fw"></i> <?php echo __('发布文章'); ?></a></li>
    <?php endif; if(isset($sidenav) && in_array('myorder', $sidenav)): ?>
    <li class="list-group-item <?php echo $controllername=='cms.order'&&$actionname=='index'?'active':''; ?>"><a href="<?php echo url('index/cms.order/index'); ?>"><i class="fa fa-shopping-bag fa-fw"></i> <?php echo __('我的消费订单'); ?></a></li>
    <?php endif; if(isset($sidenav) && in_array('mycomment', $sidenav)): ?>
    <li class="list-group-item <?php echo $controllername=='cms.comment'&&$actionname=='index'?'active':''; ?>"><a href="<?php echo url('index/cms.comment/index'); ?>"><i class="fa fa-comments fa-fw"></i> <?php echo __('我发表的评论'); ?></a></li>
    <?php endif; ?>
</ul>
