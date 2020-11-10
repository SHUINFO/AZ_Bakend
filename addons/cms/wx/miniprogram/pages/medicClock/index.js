var app = getApp();
let d = new Date();
function formatNum(num) {
  var res = Number(num);
  return res < 10 ? "0" + res : res;
}
Page({
  data: {
    markDays:[d.getFullYear() + '-' + formatNum(d.getMonth() + 1) + '-' + formatNum(d.getDate()) ] ,
    y:d.getFullYear(),
    m:d.getMonth() + 1,
    d:d.getDate()
  },
  onLoad: function (options) {
    if(!app.globalData.userInfo){
      app.globalData.userInfo = wx.getStorageSync('userInfo')
    }
    let patient_id = (app.globalData.userInfo && app.globalData.userInfo.patient)?app.globalData.userInfo.patient.id:0;
    if(!patient_id){
      wx.showModal({
        showCancel:false,
        content:'您还没有入组，无法咨询',
        success (res) {
          if (res.confirm) {
            wx.reLaunch({
              url: '/pages/index/index',
            })
          }
        }
      })
    }

    this.setData({
      patient_id:patient_id
    })


    this.getClock();
  },
  onShow: function () {
  },
  onMyEvent:function(e){
    this.setData({
      markDays:[e.detail.date]
    })
    // this.data.markDays = [e.detail.date];
    let tmp = e.detail.date.split('-')
    this.data.dateStr = e.detail.date
    this.data.y = tmp[0]
    this.data.m = tmp[1] * 1
    this.data.d = tmp[2]
    this.getClock();
  },

  getClock: function () {
    let that = this;

    let data = {
      patient_id:this.data.patient_id,
      y:this.data.y,
      m:this.data.m,
      d:this.data.d
    }

    app.request('/user/getClock', data, function (data) {
      let list = data.list;
      if(!list) return;
      let _data = {
        'amDone':false,
        'pmDone':false
      }
      list.forEach( x => {
        _data[x.type + 'Done'] = true;
      })
      that.setData(_data)
    }, function (data, ret) {
    });
  },
  setClock: function (e) {
    let type = e.currentTarget.dataset.type;

    let date = this.data.dateStr;
    let selectD = new Date(date).getTime();
    let curTime = new Date().getTime();
    let isToday = true;

    if( (Math.ceil(selectD / 8640000)) != (Math.ceil(curTime / 8640000)) ){
      isToday = false;
    }
debugger
    if(type == 'pm' && isToday && ((new Date).getHours() < 12)){
      return wx.showModal({
        showCancel:false,
        content:'请遵照医嘱用药间隔时长进行用药'
      })
    }
    // if(type == 'am' && ((new Date).getHours() > 12)){
    //   return wx.showModal({
    //     showCancel:false,
    //     content:'已过打卡时间点'
    //   })
    // }


    let that = this;
    let data = {
      patient_id:this.data.patient_id,
      y:this.data.y,
      m:this.data.m,
      d:this.data.d,
      type:type
    }

    wx.showLoading();
    app.request('/user/setClock', data, function (data) {
      wx.hideLoading();

      that.setData({
        [`${type}Done`]:true
      })
    }, function (data, ret) {
      wx.hideLoading();
    });
  },


  unsetClock: function (e) {
    
    let type = e.currentTarget.dataset.type;

    let that = this;
    let data = {
      patient_id:this.data.patient_id,
      y:this.data.y,
      m:this.data.m,
      d:this.data.d,
      type:type
    }

    wx.showLoading();
    app.request('/user/unsetClock', data, function (data) {
      wx.hideLoading();
debugger
      that.setData({
        [`${type}Done`]:false
      })
    }, function (data, ret) {
      wx.hideLoading();
    });
  },


})