// miniprogram/pages/daka.js
const app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    isShowHistory:true,
    historyData:[]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    let patient_id = 0;
    let that = this;

    if(!app.globalData.userInfo){
      app.globalData.userInfo = wx.getStorageSync('userInfo')
    }
    patient_id = (app.globalData.userInfo && app.globalData.userInfo.patient)?app.globalData.userInfo.patient.id:0;
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
    let doctorId = wx.getStorageSync('doctorId');
    this.data.patient_id = patient_id;
    this.data.doctor_id = doctorId;
    this.getQa();
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {

  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  },

  getQa:function(){
    let that = this;
    wx.showLoading();
    let data = {
      patient_id:this.data.patient_id,
      doctor_id:this.data.doctor_id
    }
    app.request('/user/getQa', data, function (data) {
      wx.hideLoading();

      data.list.forEach(x => {
        let c = new Date(x.createtime * 1000);
        let u = new Date(x.updatetime * 1000);
        x.createtime = c.toLocaleString()
        x.updatetime = u.toLocaleString()
        return x;
      })

      that.setData({
       historyData:data.list,
       total: data.total
      })
    }, function (data, ret) {
      wx.hideLoading();
    });

  },
  formSubmit: function (event) {
    var that = this;
    
    if (event.detail.value['question'] == '') {
      app.error('请填写问题');
      return;
    }

    let data = event.detail.value

    data.doctor_id = this.data.doctor_id;
    data.patient_id = this.data.patient_id;

    wx.showLoading({
      title: '提交中',
    })
    app.request('/user/setQa', data, function (data) {
      wx.hideLoading({
        complete: (res) => {},
      })
      wx.showToast({
        title: '提交成功',
      })
      that.setData({
        textData: ''
      })
      that.getQa();
    }, function (data, ret) {
      app.error(ret.msg);
    });
  }
})