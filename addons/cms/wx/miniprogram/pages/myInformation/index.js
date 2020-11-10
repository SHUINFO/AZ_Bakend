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
    smokeArr:[
      '无','5年以下','5-10年','10-15年','15-20年','20年以上'
    ],

    medicineArr:[
      '信必可',
      '舒利跌',
      '万托林',
      '辅舒酮',
      '令舒'
    ]
  },
  onLoad: function (options) {
    debugger;
    this.setData({ 
      userInfo: app.globalData.userInfo
    });
    console.log('userInfo', app.globalData.userInfo);
  },

  onShow: function () {
  }
})