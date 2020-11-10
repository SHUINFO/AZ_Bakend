
CREATE TABLE IF NOT EXISTS `__PREFIX__medical_patient` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '姓名',
  `nickname` varchar(255) DEFAULT NULL COMMENT '昵称',
  `gender` int(11) NOT NULL DEFAULT '0' COMMENT '性别',
  `birth_year` int(11) DEFAULT NULL COMMENT '出生年份',
  `disease` varchar(255) NOT NULL COMMENT '疾病',
  `diagnose_at` int(11) DEFAULT NULL COMMENT '确诊年份',
  `mobile` varchar(32) DEFAULT NULL COMMENT '手机号',
  `address` varchar(255) DEFAULT NULL COMMENT '住址',
  `smoke` varchar(255) DEFAULT NULL COMMENT '吸烟情况',
  `memo` text DEFAULT NULL COMMENT '备注',
  `medicine` varchar(255) DEFAULT NULL COMMENT '药物',
  `createtime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='病人信息表';


CREATE TABLE IF NOT EXISTS `__PREFIX__medical_patient_qa` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `patient_id` int(10) NOT NULL COMMENT '病人id',
  `doctor_id` int(10) DEFAULT NULL COMMENT '医生id',
  `replier_id` int(10) DEFAULT NULL,
  `question` text DEFAULT NULL COMMENT '问题',
  `answer` text DEFAULT NULL COMMENT '回答',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='病人咨询表';


CREATE TABLE IF NOT EXISTS `__PREFIX__medical_doctor` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `admin_id` int(10) NOT NULL COMMENT '管理员id',
  `hospital_id` int(10) NOT NULL COMMENT '医院id',
  `department` varchar(255) NOT NULL COMMENT '科室',
  `department_id` int(10) NOT NULL COMMENT '科室id',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '姓名',
  `avatar` varchar(1025) DEFAULT NULL COMMENT '头像',
  `mobile` varchar(20) DEFAULT NULL COMMENT '手机',
  `gender` int(11) NOT NULL DEFAULT '0' COMMENT '性别',
  `wxgroup_name` varchar(255) DEFAULT NULL,
  `wxgzh_qr` varchar(1024) DEFAULT NULL,
  `wxgroup_qr` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL COMMENT '分类',
  `title` varchar(255) DEFAULT NULL COMMENT '职称',
  `position` varchar(255) DEFAULT NULL COMMENT '医院职务',
  `wxid` varchar(255) DEFAULT NULL COMMENT '微信号',
  `createtime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='医生表';


CREATE TABLE IF NOT EXISTS `__PREFIX__medical_hospital` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `logo` varchar(1025) DEFAULT NULL COMMENT 'LOGO',
  `province` varchar(255) DEFAULT NULL COMMENT '省',
  `city` varchar(255) DEFAULT NULL COMMENT '市',
  `area` varchar(255) DEFAULT NULL COMMENT '区',
  `level` int(11) NOT NULL DEFAULT '0' COMMENT '等级',
  `department` text DEFAULT NULL COMMENT '科室',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='医院';


CREATE TABLE IF NOT EXISTS `__PREFIX__medical_hospital_department` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `hospital_id` int(10) NOT NULL COMMENT '医院id',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='医院科室';



CREATE TABLE IF NOT EXISTS `__PREFIX__medical_medicine` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `strength` varchar(255) NOT NULL DEFAULT '' COMMENT '规格',
  `memo` text DEFAULT NULL COMMENT '备注',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='药品';




CREATE TABLE IF NOT EXISTS `__PREFIX__medical_patient_doctor` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `doctor_id` int(10) NOT NULL COMMENT '医生id',
  `patient_id` int(10) NOT NULL COMMENT '病人id',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='病人医生关系表';


ALTER TABLE `__PREFIX__admin` ADD `assistant_id` INT NULL DEFAULT '0' AFTER `id`;


CREATE TABLE IF NOT EXISTS `__PREFIX__medical_patient_clock` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `patient_id` int(10) NOT NULL COMMENT '病人id',
  `date` date COMMENT '打卡日期',
  `y` int COMMENT '年',
  `m` int COMMENT '月',
  `d` int COMMENT '日',
  `type` varchar(32) DEFAULT NULL COMMENT '类型',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='病人打卡表';


CREATE TABLE IF NOT EXISTS `__PREFIX__medical_patient_report` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `patient_id` int(10) NOT NULL COMMENT '病人id',
  `type` varchar(255) NOT NULL DEFAULT '' COMMENT '问卷类型',
  `report` text COMMENT '内容',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='病人问卷表';
