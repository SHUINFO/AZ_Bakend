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
    diseaseArr:[
      '哮喘','慢阻肺'
    ],
    diseaseIndex:0,
    medicineArr:[
      '信必可','XXX'
    ],
    medicineIndex:0
  },

  onLoad: function (options) {
    app.globalData.mobile = '13800010003';
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
     app.loginByMobile(this.data.mobile,that.showForm)
    //新病人
    //  app.loginByMobile('13300001111',that.showForm)

    that.showForm();
return
    if (!app.globalData.userInfo) {
      app.login();
    }
  },
  showForm: function(userinfo){
    let that = this;
    if(userinfo && (userinfo['isAdmin'] || !this.data.doctorId)){
      wx.reLaunch({
        url: '/page/index/index',
      })
    }

    if(userinfo && userinfo.doctorList){
      let r = userinfo.doctorList.some( x => {
        return x.id == that.data.doctorId
      })
      if(r){
        wx.reLaunch({
          url: '/page/index/index',
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
    debugger;
    let that = this;
    let field = e.target.dataset.field;
    let v = e.detail.value;
    that.setData({
      [`${field}Index`]:v
    })
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

    event.detail.value['row[gender]'] = this.data.genderArr[event.detail.value['row[gender]']].id;
    event.detail.value['row[disease]'] = this.data.diseaseArr[event.detail.value['row[disease]']];
    event.detail.value['row[medicine]'] = this.data.medicineArr[event.detail.value['row[medicine]']];
    // wx.switchTab({
    //   url: '/page/index/index'
    // });

    let data = event.detail.value

    data.doctor_id = this.data.doctorId;

    data = data
    
    app.request('/user/bindDoctor', data, function (data) {
      // that.setData({ userInfo: data.userInfo });
      // app.globalData.userInfo = data.userInfo;
      app.success('修改成功!', function () {
        setTimeout(function () {
          //要延时执行的代码
          wx.switchTab({
            url: 'index'
          });
        }, 2000); //延迟时间
      });
    }, function (data, ret) {
      app.error(ret.msg);
    });
  },
})