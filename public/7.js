(window.webpackJsonp=window.webpackJsonp||[]).push([[7],{15:function(t,n){t.exports=function(t){t.options.__i18n=t.options.__i18n||[],t.options.__i18n.push('{"ru":{"pageTitle":"Публичная оферта"}}'),delete t.options._Ctor}},16:function(t,n){t.exports=function(t){t.options.__i18n=t.options.__i18n||[],t.options.__i18n.push('{"en":{"pageTitle":"User agreement"}}'),delete t.options._Ctor}},170:function(t,n,e){"use strict";e.r(n);var o=e(2),i=e(3),s=e.n(i),a={components:{Page:o.a},data:function(){return{content:[]}},mounted:function(){var t=this;s.a.get("/oferta").then((function(n){t.content=n.data.content}))}},u=e(0),c=e(58),p=e(59),r=Object(u.a)(a,(function(){var t=this.$createElement,n=this._self._c||t;return n("Page",{attrs:{type:"no-header"}},[n("div",{staticClass:"page-text"},[n("h1",[this._v(this._s(this.$t("pageTitle")))]),this._v("\n\n    "+this._s(this.content)+"\n  ")])])}),[],!1,null,null,null);"function"==typeof c.default&&Object(c.default)(r),"function"==typeof p.default&&Object(p.default)(r);n.default=r.exports},58:function(t,n,e){"use strict";var o=e(15),i=e.n(o);n.default=i.a},59:function(t,n,e){"use strict";var o=e(16),i=e.n(o);n.default=i.a}}]);