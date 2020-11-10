const app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    listData:[],
    patient_id:0
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    let that = this

    if(!app.globalData.userInfo){
      app.globalData.userInfo = wx.getStorageSync('userInfo')
    }
    let patient_id = (app.globalData.userInfo && app.globalData.userInfo.patient)?app.globalData.userInfo.patient.id:0;
    
    this.setData({
      patient_id:patient_id
    })

    if(!patient_id){
      this.getPost(1);
    }else{

      debugger
      if(app.globalData.PostListMode){
        this.getPost(app.globalData.PostListMode);
        app.globalData.PostListMode = 0;
      }else{
        this.getPost(0);
      }
      
    }
    
  },

  showPost(e){
    let mode = e.currentTarget.dataset.mode;
    this.getPost(mode * 1);
  },
  getPost(mode){
    let that = this
    let url = '/archives/index';
    let postData = {
      channel: 4
    }
    switch (mode){
      case 0:
        url =  '/archives/recommend';
        let admin_ids = [];
        if(app.globalData.userInfo.doctorList){
          app.globalData.userInfo.doctorList.forEach(x=>{
            admin_ids.push(x.admin_id);
          })
        }
        if(admin_ids && admin_ids.length){
          postData = {
            channel: 4,
            admin_ids: admin_ids
          }
        }
        break;
        case 1:
          url =  '/archives/index';
          break;
          case 2:
            url =  '/archives/my_fav';
            postData = {
              channel: 4
            }
            break;
            default:
              break;
    }
    this.setData({
      tabChecked:mode
    });
    app.request(url, postData, function (data, ret) {
      let vote = wx.getStorageSync("fav") || [];
      data.archivesList.forEach(x => {
        if (vote.indexOf(x.id) > -1) {
          x.has_fav = 1;
        }
        return x;
      });
      
      that.setData({
        listData: data.archivesList,
      });
    }, function (data, ret) {
      app.error(ret.msg);
    });
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
  onShareAppMessage: function (res) {
    if (res.from === 'button') {
      // 来自页面内转发按钮
      console.log(res.target)
    }
    let idx= res.target.dataset.idx;
    let item = this.data.listData[idx];
    return {
      title: item.title,
      imageUrl: item.image,
      path: '/pages/post/detail?id=' + item.id
    }
  },

  gotoDetail: function(e){
    let id = e.currentTarget.dataset.id;
    wx.navigateTo({
      url: '/pages/post/detail?id=' + id,
    })
  },


  action: function(event) {
    let that = this;
    app.action(event);
  },
})