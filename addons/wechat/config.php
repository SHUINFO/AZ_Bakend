<?php

return array (
  0 => 
  array (
    'name' => 'app_id',
    'title' => 'app_id',
    'type' => 'string',
    'content' => 
    array (
    ),
    'value' => 'wx5dd32efa176a4270',
    'rule' => 'required',
    'msg' => '',
    'tip' => '你的微信公众号appid',
    'ok' => '',
    'extend' => '',
  ),
  1 => 
  array (
    'name' => 'secret',
    'title' => 'secret',
    'type' => 'string',
    'content' => 
    array (
    ),
    'value' => 'b00925abbdd2e1f79a7adf099038bdd1',
    'rule' => 'required',
    'msg' => '',
    'tip' => '你的微信公众号appsecret',
    'ok' => '',
    'extend' => '',
  ),
  2 => 
  array (
    'name' => 'token',
    'title' => 'token',
    'type' => 'string',
    'content' => 
    array (
    ),
    'value' => 'kanqunbao',
    'rule' => 'required',
    'msg' => '',
    'tip' => '通信token',
    'ok' => '',
    'extend' => '',
  ),
  3 => 
  array (
    'name' => 'aes_key',
    'title' => 'aes_key',
    'type' => 'string',
    'content' => 
    array (
    ),
    'value' => 'mAwRpB8VSWNCNJ8i1gA9TGlycmPJDyN28rD18BhU12U',
    'rule' => '',
    'msg' => '',
    'tip' => '',
    'ok' => '',
    'extend' => '',
  ),
  4 => 
  array (
    'name' => 'debug',
    'title' => '调试模式',
    'type' => 'radio',
    'content' => 
    array (
      0 => '否',
      1 => '是',
    ),
    'value' => '0',
    'rule' => 'required',
    'msg' => '',
    'tip' => '',
    'ok' => '',
    'extend' => '',
  ),
  5 => 
  array (
    'name' => 'log_level',
    'title' => '日志记录等级',
    'type' => 'select',
    'content' => 
    array (
      'debug' => 'debug',
      'info' => 'info',
      'notice' => 'notice',
      'warning' => 'warning',
      'error' => 'error',
      'critical' => 'critical',
      'alert' => 'alert',
      'emergency' => 'emergency',
    ),
    'value' => 'debug',
    'rule' => 'required',
    'msg' => '',
    'tip' => '',
    'ok' => '',
    'extend' => '',
  ),
  6 => 
  array (
    'name' => 'oauth_callback',
    'title' => '登录回调',
    'type' => 'string',
    'content' => 
    array (
    ),
    'value' => 'https://test.everlive.me/kanqunbao/api/wechat/message',
    'rule' => 'required',
    'msg' => '',
    'tip' => '',
    'ok' => '',
    'extend' => '',
  ),
);
