var app = getApp();
Page({

  data: {
    userInfo: null,
    doctorId:0,
    genderArr:[
      {id:1,name:'男性'},
      {id:2,name:'女性'}
    ],
    genderIndex:0,

    relativeArr:[
      {id:1,name:'本人'},
      {id:2,name:'亲属'}
    ],
    relativeIndex:0,
    diseaseArr:[
      '哮喘','慢阻肺','慢性咳嗽','其他呼吸疾病'
    ],
    diseaseIndex:0,

    smokeArr:[
      '无','5年以下','5-10年','10-15年','15-20年','20年以上'
    ],
    smokeIndex:0,
    

    medicineArr:[
      '信必可',
      '舒利跌',
      '万托林',
      '辅舒酮',
      '令舒'
    ],
    medicineIndex:0,
    isProtocolOpen: false, // 协议弹框是否出现
    isProtocolChecked: false, // 是否选中协议单选框
  },

  onLoad: function (options) {
    if(!app.globalData.mobile){
      app.globalData.mobile = wx.getStorageSync('mobile');
    }
    this.setData({ 
      userInfo: app.globalData.userInfo, 
      doctorId: options.doctorId,
      mobile:app.globalData.mobile
    });
  },

  onShow: function () {
    wx.showLoading({
      title: '登录中...',
    })
    let that = this
    //医生
    //  app.loginByMobile('13811110010',that.showForm)
    //运营
    //  app.loginByMobile('11133334445',that.showForm)
    //管理员
    //  app.loginByMobile('13818181818',that.showForm)
    //老病人
    //  app.loginByMobile(this.data.mobile,that.showForm)
    //新病人
    //  app.loginByMobile('13300001111',that.showForm)
// debugger
    app.loginByMobile(this.data.mobile,that.showForm)
    // if (!app.globalData.userInfo) {
    //   app.login();
    // }
  },
  showForm: function(userinfo){
    let that = this;
    if(userinfo && (userinfo['isAdmin'] || !this.data.doctorId)){
      wx.reLaunch({
        url: '/pages/index/index',
      })
    }

    if(userinfo && userinfo.doctorList){
      let r = userinfo.doctorList.some( x => {
        return x.id == that.data.doctorId
      })
      if(r){
        wx.reLaunch({
          url: '/pages/index/index',
        })
      }
    }

    //get doctor info
    this.getDoctor(that.data.doctorId)
  },
  
  getDoctor: function (doctorId) {
    var that = this;
    app.request('/user/doctor', {id:doctorId}, function (data) {
      if(!data.doctorInfo){
        app.error('没有找到医生');
      }
      that.setData({ 
        doctorInfo: data.doctorInfo,
        showForm:true
       });
    }, function (data, ret) {
      app.error(ret.msg);
    });
  },
  bindPickerChange:function(e){
    let that = this;
    let field = e.target.dataset.field;
    let v = e.detail.value;
    that.setData({
      [`${field}Index`]:v
    })
  },
  bindRadioChange:function(e){
    let that = this;
    let field = e.target.dataset.field;
    let v = e.detail.value;
    that.setData({
      [`${field}Index`]:v
    })
  },
  
  getPhoneNumber(e) {
    var that = this;
    wx.cloud.callFunction({
        name: 'getMobile',
        data: {
            weRunData: wx.cloud.CloudID(e.detail.cloudID),
        }
    }).then(res => {

        app.globalData.mobile = res.result;
        // app.globalData.mobile = '13300000001';
        that.setData({
            mobile: app.globalData.mobile,
        })
      wx.setStorageSync('mobile', app.globalData.mobile);
    }).catch(err => {
        console.error(err);
    });
  },

  formSubmit: function (event) {
    var that = this;
    
    if (event.detail.value['row[name]'] == '') {
      app.error('姓名不能为空');
      return;
    }
    if (event.detail.value['row[mobile]'] == '') {
      app.error('手机不能为空');
      return;
    }
    
    event.detail.value['row[mobile]'] = app.globalData.mobile;
    event.detail.value['row[birth_year]'] = (new Date()).getFullYear() - parseInt(event.detail.value['age']);
    // event.detail.value['row[diagnose_at]'] =  (new Date()).getFullYear() - parseInt(event.detail.value['diagnose_year']);
    event.detail.value['row[diagnose_at]'] =  0;
    
    event.detail.value['row[gender]'] = (event.detail.value['row[gender]'])
    ?this.data.genderArr[event.detail.value['row[gender]']].id
    :this.data.genderArr[this.data.genderIndex].id;

    event.detail.value['row[relative]'] = (event.detail.value['row[relative]'])
    ?this.data.relativeArr[event.detail.value['row[relative]']].id
    :this.data.relativeArr[this.data.relativeIndex].id;

    event.detail.value['row[disease]']= (event.detail.value['row[disease]'])
    ?this.data.diseaseArr[event.detail.value['row[disease]']]
    :this.data.diseaseArr[this.data.diseaseIndex];
    
    // event.detail.value['row[medicine]']= (event.detail.value['row[medicine]'])
    // ?this.data.medicineArr[event.detail.value['row[medicine]']]
    // :this.data.medicineArr[this.data.medicineIndex];
    
    // event.detail.value['row[smoke]']= (event.detail.value['row[smoke]'])
    // ?this.data.smokeArr[event.detail.value['row[smoke]']]
    // :this.data.smokeArr[this.data.smokeIndex];

    // wx.switchTab({
    //   url: '/pages/index/index'
    // });

    let data = event.detail.value
// debugger;return;
    data.doctor_id = this.data.doctorId;

    data = data
    
    app.request('/user/bindDoctor', data, function (data) {
      wx.setStorageSync('doctorId', that.data.doctorId);
      app.success('修改成功!', function () {
        app.loginByMobile(app.globalData.mobile, function(){
          wx.switchTab({
            url: '/pages/index/index'
          });
        })
        // setTimeout(function () {
        //   //要延时执行的代码
        //   wx.switchTab({
        //     url: 'index'
        //   });
        // }, 2000); //延迟时间
      });
    }, function (data, ret) {
      app.error(ret.msg);
    });
  },

  onProtocolShow(){
    this.setData({
      isProtocolOpen: true
    })
  },
  // 关闭弹框
  onProtocolClose(){
    this.setData({
      isProtocolOpen: false
    })
  },
  // 弹框确定
  onProtocolSub(){

    this.setData({
      isProtocolOpen: false,
      isProtocolChecked: true,
    })
  },
  // 协议单选框点击
  onProtocolClick(){
    this.setData({
      isProtocolChecked: !this.data.isProtocolChecked,
    })
  }
})