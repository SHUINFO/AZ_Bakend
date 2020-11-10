Component({
  properties: {
      // 星期几为第一天(0为星期日)
      weekstart: {
        type: Number,
        default: 0
      },
      // 标记的日期
      markDays: {
        type: Array,
        default: function _default() {
          return [];
        }
      },
      //是否展示月份切换按钮
      headerBar: {
        type: Boolean,
        default: true
      },
      // 是否展开
      open: {
        type: Boolean,
        default: true
      },
      //未来日期是否不可点击
      disabledAfter: {
        type: Boolean,
        default: true
      }
    },
    data:{
      weektext: ["日", "一", "二", "三", "四", "五", "六"],
      y: new Date().getFullYear(),
      // 年
      m: new Date().getMonth() + 1,
      // 月
      dates: [],
      // 当前月的日期数据
      positionTop: 0,
      choose: ""
    },
    attached: function(){
      this.setData({
        choose : this.getToday().date,
        dates : this.monthDay(this.data.y, this.data.m),
        weekDay:this.data.weektext.slice(this.data.weekstart).concat(this.data.weektext.slice(0, this.data.weekstart)),
      })
      this.setData({
        height: this.data.dates.length / 7 * 80 + "rpx"
      })
      this.render()
    },
    methods: {
      render:function(){
        let that = this;
        let f0 = this.formatMonth(this.data.m);

        let M_F = new Date(this.data.y + '-' + (this.data.m + 1)+ '-01');
        // MF

        let l0 = [];
        this.data.dates.forEach( (item , index) => {
          var m0 = that.isWorkDay(item.year, item.month, item.date)
          var m1 = that.isMarkDay(item.year, item.month, item.date)
          var m2 = Number(item.date)
          var m3 = that.isMarkDay(item.year, item.month, item.date)
          l0.push({
            $orig: item,
            m0: true,
            m1: m1,
            m2: m2,
            m3: m3
          }) 
        })
        this.setData({
          f0:f0,
          l0:l0,
          y:this.data.y
        })

      },
      formatMonth: function formatMonth(num) {
        var month = ["一", "二", "三", "四", "五", "六", "七", "八", "九", "十", "十一", "十二"];
        return month[num - 1];
      },
      formatNum: function formatNum(num) {
        var res = Number(num);
        return res < 10 ? "0" + res : res;
      },
      getToday: function getToday() {
        var date = new Date();
        var y = date.getFullYear();
        var m = date.getMonth();
        var d = date.getDate();
        var week = new Date().getDay();
        var weekText = ["日", "一", "二", "三", "四", "五", "六"];
        var formatWeek = "星期" + weekText[week];
        var today = {
          date: y + "-" + this.formatNum(m + 1) + "-" + this.formatNum(d),
          week: formatWeek
        };
        return today;
      },
      // 获取当前月份数据
      monthDay: function monthDay(y, month) {
        var dates = [];
        var m = Number(month);
        var firstDayOfMonth = new Date(y, m - 1, 1).getDay(); // 当月第一天星期几
  
        var lastDateOfMonth = new Date(y, m, 0).getDate(); // 当月最后一天
  
        var lastDayOfLastMonth = new Date(y, m - 2, 0).getDate(); // 上一月的最后一天
  
        var weekstart = this.data.weekstart == 7 ? 0 : this.data.weekstart;
  
        var startDay = function () {
          // 周初有几天是上个月的
          if (firstDayOfMonth == weekstart) {
            return 0;
          } else if (firstDayOfMonth > weekstart) {
            return firstDayOfMonth - weekstart;
          } else {
            return 7 - weekstart + firstDayOfMonth;
          }
        }();
  
        var endDay = 7 - (startDay + lastDateOfMonth) % 7; // 结束还有几天是下个月的
  
        for (var i = 1; i <= startDay; i++) {
          dates.push({
            date: this.formatNum(lastDayOfLastMonth - startDay + i),
            day: weekstart + i - 1 || 7,
            month: m - 1 >= 0 ? this.formatNum(m - 1) : 12,
            year: m - 1 >= 0 ? y : y - 1
          });
        }
  
        for (var j = 1; j <= lastDateOfMonth; j++) {
          dates.push({
            date: this.formatNum(j),
            day: j % 7 + firstDayOfMonth - 1 || 7,
            month: this.formatNum(m),
            year: y,
            isCurM: true //是否当前月份
  
          });
        }
  
        for (var k = 1; k <= endDay; k++) {
          dates.push({
            date: this.formatNum(k),
            day: (lastDateOfMonth + startDay + weekstart + k - 1) % 7 || 7,
            month: m + 1 <= 11 ? this.formatNum(m + 1) : 0,
            year: m + 1 <= 11 ? y : y + 1
          });
        } // console.log(dates);
  
  
        return dates;
      },
      isWorkDay: function isWorkDay(y, m, d) {
        //是否工作日
        var ymd = "".concat(y, "/").concat(m, "/").concat(d);
        var formatDY = new Date(ymd.replace(/-/g, "/"));
        var week = formatDY.getDay();
  
        if (week == 0 || week == 6) {
          return false;
        } else {
          return true;
        }
      },
      isFutureDay: function isFutureDay(y, m, d) {
        //是否未来日期
        var ymd = "".concat(y, "/").concat(m, "/").concat(d);
        var formatDY = new Date(ymd.replace(/-/g, "/"));
        var showTime = formatDY.getTime();
        var curTime = new Date().getTime();
  
        if (showTime > curTime) {
          return true;
        } else {
          return false;
        }
      },
      // 标记日期
      isMarkDay: function isMarkDay(y, m, d) {
        var flag = false;
  
        for (var i = 0; i < this.data.markDays.length; i++) {
          var dy = "".concat(y, "-").concat(m, "-").concat(d);
  
          if (this.data.markDays[i] == dy) {
            flag = true;
            break;
          }
        }
        return flag;
      },
      isToday: function isToday(y, m, d) {
        var checkD = y + "-" + m + "-" + d;
        var today = this.getToday().date;
  
        if (checkD == today) {
          return true;
        } else {
          return false;
        }
      },
      // 点击回调
      selectOne: function(e) {
        let i = e.target.dataset.item.$orig;
        var date = "".concat(i.year, "-").concat(i.month, "-").concat(i.date);
        var selectD = new Date(date).getTime();
        var curTime = new Date().getTime();
        var week = new Date(date).getDay();
        var weekText = ["日", "一", "二", "三", "四", "五", "六"];
        var formatWeek = "星期" + weekText[week];
        var response = {
          date: date,
          week: formatWeek
        };
  
        if (!i.isCurM) {
          // console.log('不在当前月范围内');
          return false;
        }
debugger

        // if( (Math.ceil(selectD / 8640000)) != (Math.ceil(curTime / 8640000)) ){
        //   return false;
        // }

        if (selectD > curTime) {
          return false;
          
          if (this.data.disabledAfter) {
            console.log("未来日期不可选");
            return false;
          } else {
            this.data.choose = date;
            this.triggerEvent('myevent', response)
            // this.$emit("onDayClick", response);
          }
        } else {
          this.data.choose = date;
          // this.$emit("onDayClick", response);
          this.triggerEvent('myevent', response)
        }
        this.changYearMonth(i.year,i.month);
        this.render();
      },
      //改变年月
      changYearMonth: function changYearMonth(y, m) {
        this.data.dates = this.monthDay(y, m);
        this.data.y = y;
        this.data.m = m;
      },
      changeMonth: function(e) {
        let type = e.currentTarget.dataset.type;
        if (type == "pre") {
          if (this.data.m + 1 == 2) {
            this.data.m = 12;
            this.data.y = this.data.y - 1;
          } else {
            this.data.m = this.data.m - 1;
          }
        } else {
          if (this.data.m + 1 == 13) {
            this.data.m = 1;
            this.data.y = this.data.y + 1;
          } else {
            this.data.m = this.data.m + 1;
          }
        }
  
        this.data.dates = this.monthDay(this.data.y, this.data.m);
        this.render();
      }
    }
  }
)
  