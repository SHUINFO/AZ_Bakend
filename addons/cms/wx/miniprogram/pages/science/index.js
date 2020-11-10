(global["webpackJsonp"] = global["webpackJsonp"] || []).push([
  ["pages/science/index"], {
    "1ac2": function (t, e, n) {
      "use strict";
      (function (t) {
        Object.defineProperty(e, "__esModule", {
          value: !0
        }), e.default = void 0;
        var r = i(n("a34a")),
          a = i(n("4b90"));

        function i(t) {
          return t && t.__esModule ? t : {
            default: t
          }
        }

        function o(t) {
          return s(t) || l(t) || u(t) || c()
        }

        function c() {
          throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")
        }

        function u(t, e) {
          if (t) {
            if ("string" === typeof t) return f(t, e);
            var n = Object.prototype.toString.call(t).slice(8, -1);
            return "Object" === n && t.constructor && (n = t.constructor.name), "Map" === n || "Set" === n ? Array.from(t) : "Arguments" === n || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n) ? f(t, e) : void 0
          }
        }

        function l(t) {
          if ("undefined" !== typeof Symbol && Symbol.iterator in Object(t)) return Array.from(t)
        }

        function s(t) {
          if (Array.isArray(t)) return f(t)
        }

        function f(t, e) {
          (null == e || e > t.length) && (e = t.length);
          for (var n = 0, r = new Array(e); n < e; n++) r[n] = t[n];
          return r
        }

        function d(t, e, n, r, a, i, o) {
          try {
            var c = t[i](o),
              u = c.value
          } catch (l) {
            return void n(l)
          }
          c.done ? e(u) : Promise.resolve(u).then(r, a)
        }

        function h(t) {
          return function () {
            var e = this,
              n = arguments;
            return new Promise((function (r, a) {
              var i = t.apply(e, n);

              function o(t) {
                d(i, r, a, o, c, "next", t)
              }

              function c(t) {
                d(i, r, a, o, c, "throw", t)
              }
              o(void 0)
            }))
          }
        }
        var g = {
          data: function () {
            return {
              searchValue: null,
              tabChecked: 0,
              triggered: !1,
              listData: [],
              pageDone: !1,
              pageNum: 1,
              scrollViewTop: 0
            }
          },
          mounted: function () {
            this.getData(1, "", 0, !0)
          },
          methods: {
            onSearch: function () {
              this.getData(1, this.searchValue, this.tabChecked, !0)
            },
            onTabChose: function (t) {
              t !== this.tabChecked && (this.tabChecked = t, this.getData(1, this.searchValue, t, !0))
            },
            onScroll: function (t) {
              this.scrollViewTop || (this.scrollViewTop = t.detail.scrollTop)
            },
            onScrollBottom: function () {
              this.pageDone || this.getData(this.pageNum + 1, this.searchValue, this.tabChecked, !1)
            },
            onScrollFlash: function () {
              this.triggered || (this.triggered = !0, this.getData(1, this.searchValue, this.tabChecked, !0))
            },
            getData: function (t, e, n, a) {
              var i = this;
              return h(r.default.mark((function c() {
                var u;
                return r.default.wrap((function (r) {
                  while (1) switch (r.prev = r.next) {
                    case 0:
                      return {
                        pageNum: t, pageSize: 15, searchValue: e, type: n
                      }, i.pageDone = !1, r.next = 4, {
                        code: 200,
                        data: [{
                          id: t + "1",
                          title: "请支持布地格服吸入气雾剂进入医保.",
                          img: "",
                          browse: 10,
                          forward: 12,
                          favorites: 3,
                          like: 0
                        }, {
                          id: t + "2",
                          title: "请支持布地格服吸入气雾剂进入医保.",
                          img: "",
                          browse: 111,
                          forward: 222,
                          favorites: 333,
                          like: 444
                        }, {
                          id: t + "3",
                          title: "医生推荐吸入气雾剂进入医地格服吸入气雾地格服吸入气雾保.",
                          img: "",
                          browse: 12,
                          forward: 32,
                          favorites: 42,
                          like: 13
                        }, {
                          id: t + "4",
                          title: "支持布地入气雾剂进入医保.",
                          img: "",
                          browse: 111,
                          forward: 12,
                          favorites: 11,
                          like: 33
                        }, {
                          id: t + "5",
                          title: "请支持布地格服吸入气雾剂进地格服吸入气雾入医保.",
                          img: "",
                          browse: 32,
                          forward: 32,
                          favorites: 23,
                          like: 434
                        }]
                      };
                    case 4:
                      u = r.sent, u && 200 === u.code && u.data.length ? (a ? (i.listData = u.data, i.scrollViewTop = 0) : i.listData = [].concat(o(i.listData), o(u.data)), i.pageNum = t) : i.pageDone = !0, i.triggered = !1;
                    case 7:
                    case "end":
                      return r.stop()
                  }
                }), c)
              })))()
            },
            goToDetail: function (e) {
              t.navigateTo({
                url: a.default.urlStringify("/pages/articleDetail/index", {
                  id: e.id
                })
              })
            }
          }
        };
        e.default = g
      }).call(this, n("543d")["default"])
    },
    "3ac2": function (t, e, n) {},
    "919c": function (t, e, n) {
      "use strict";
      n.r(e);
      var r = n("a817"),
        a = n("f804");
      for (var i in a)["default"].indexOf(i) < 0 && function (t) {
        n.d(e, t, (function () {
          return a[t]
        }))
      }(i);
      n("f62c");
      var o, c = n("f0c5"),
        u = Object(c["a"])(a["default"], r["b"], r["c"], !1, null, null, null, !1, r["a"], o);
      e["default"] = u.exports
    },
    "99f5": function (t, e, n) {
      "use strict";
      (function (t) {
        n("6cdc");
        r(n("66fd"));
        var e = r(n("919c"));

        function r(t) {
          return t && t.__esModule ? t : {
            default: t
          }
        }
        t(e.default)
      }).call(this, n("543d")["createPage"])
    },
    a817: function (t, e, n) {
      "use strict";
      var r;
      n.d(e, "b", (function () {
        return a
      })), n.d(e, "c", (function () {
        return i
      })), n.d(e, "a", (function () {
        return r
      }));
      var a = function () {
          var t = this,
            e = t.$createElement;
          t._self._c
        },
        i = []
    },
    f62c: function (t, e, n) {
      "use strict";
      var r = n("3ac2"),
        a = n.n(r);
      a.a
    },
    f804: function (t, e, n) {
      "use strict";
      n.r(e);
      var r = n("1ac2"),
        a = n.n(r);
      for (var i in r)["default"].indexOf(i) < 0 && function (t) {
        n.d(e, t, (function () {
          return r[t]
        }))
      }(i);
      e["default"] = a.a
    }
  },
  [
    ["99f5", "common/runtime", "common/vendor"]
  ]
]);