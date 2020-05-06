(window.webpackJsonp=window.webpackJsonp||[]).push([[2],{10:function(t,e,n){"use strict";var r={props:["height","classes"]},s=n(0),i=Object(s.a)(r,(function(){var t=this.$createElement,e=this._self._c||t;return e("svg",{staticClass:"fill-current",class:this.classes,attrs:{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",height:this.height}},[e("path",{attrs:{d:"M11.85 17.56a1.5 1.5 0 0 1-1.06.44H10v.5c0 .83-.67 1.5-1.5 1.5H8v.5c0 .83-.67 1.5-1.5 1.5H4a2 2 0 0 1-2-2v-2.59A2 2 0 0 1 2.59 16l5.56-5.56A7.03 7.03 0 0 1 15 2a7 7 0 1 1-1.44 13.85l-1.7 1.71zm1.12-3.95l.58.18a5 5 0 1 0-3.34-3.34l.18.58L4 17.4V20h2v-.5c0-.83.67-1.5 1.5-1.5H8v-.5c0-.83.67-1.5 1.5-1.5h1.09l2.38-2.39zM18 9a1 1 0 0 1-2 0 1 1 0 0 0-1-1 1 1 0 0 1 0-2 3 3 0 0 1 3 3z"}})])}),[],!1,null,null,null);e.a=i.exports},167:function(t,e,n){"use strict";n.r(e);var r=n(12),s=n(7),i=n(4),o=n(2),a={props:["save","editing"]},c=n(0),u=n(66),l=n(67),d=Object(c.a)(a,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return t.editing?n("div",{staticClass:"save-button-holder"},[n("button",{on:{click:function(e){return t.$emit("save")}}},[t._v("\n        "+t._s(t.save?t.save:t.$t("save"))+"\n    ")])]):t._e()}),[],!1,null,null,null);"function"==typeof u.default&&Object(u.default)(d),"function"==typeof l.default&&Object(l.default)(d);var p=d.exports,v=n(54),f=n(1);function h(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),n.push.apply(n,r)}return n}function _(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}var m={components:{SaveButton:p,IconEmail:v.a},data:function(){return{editing:!1,value:""}},mounted:function(){this.value=this.user.email},methods:{edit:function(){this.editing=!0,setTimeout((function(){document.getElementById("edit-email").focus()}),10)},unedit:function(t){var e=this;this.value=t.target.value,setTimeout((function(){e.editing=!1}),10)},save:function(){var t=this;this.value!=this.user.email&&(this.$store.dispatch("errors/clear"),this.$store.dispatch("auth/saveEmail",this.value).then((function(){t.hasError("email")?t.edit():(t.$store.dispatch("message/show",t.$t("emailSaved")),t.$store.getters["auth/needVerification"]&&t.$router.push({name:"verify"}))})))}},computed:function(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?h(Object(n),!0).forEach((function(e){_(t,e,n[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):h(Object(n)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))}))}return t}({},Object(f.b)("errors",{hasError:"has",getError:"getFirst"}),{},Object(f.c)("auth",{user:function(t){return t.user}}))},g=n(68),b=n(69),w=Object(c.a)(m,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("div",{staticClass:"block with-errors"},[n("div",{staticClass:"title"},[n("IconEmail",{attrs:{height:"20",classes:"settings-icon vertical-center"}}),t._v(" "),n("div",[t._v(t._s(t.$t("email")))]),t._v(" "),t.editing?t._e():n("div",{staticClass:"change",on:{click:t.edit}},[t._v(t._s(t.$t("change")))])],1),t._v(" "),t.editing?t._e():n("div",{staticClass:"value",on:{click:t.edit}},[t._v(t._s(t.user.email))]),t._v(" "),n("div",{staticClass:"bottom"},[t.editing?n("div",{staticClass:"input-item text-right",class:{error:t.hasError("email")}},[n("input",{attrs:{type:"email",id:"edit-email"},domProps:{value:t.value},on:{focusout:t.unedit}})]):t._e(),t._v(" "),t.hasError("email")?n("div",{staticClass:"error-text"},[t._v("\n                "+t._s(t.$t("errors."+t.getError("email")))+"\n            ")]):t._e(),t._v(" "),t.editing&&!t.hasError("email")?n("div",{staticClass:"warning-text"},[t._v("\n                "+t._s(t.$t("warning"))+"\n            ")]):t._e(),t._v(" "),n("SaveButton",{attrs:{editing:t.editing},on:{save:t.save}})],1)])])}),[],!1,null,null,null);"function"==typeof g.default&&Object(g.default)(w),"function"==typeof b.default&&Object(b.default)(w);var O=w.exports;function y(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),n.push.apply(n,r)}return n}function j(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}var P={components:{SaveButton:p},data:function(){return{editing:!1,value:""}},mounted:function(){this.value=this.user.name},methods:{edit:function(){this.editing=!0},unedit:function(t){var e=this;this.value=t.target.value,setTimeout((function(){e.editing=!1}),10)},save:function(){var t=this;this.value!=this.user.name&&(this.$store.dispatch("errors/clear"),this.$store.dispatch("auth/saveName",this.value).then((function(){t.hasError("name")?(t.editable=!0,document.getElementById("edit-name").focus()):t.$store.dispatch("message/show",t.$t("nameSaved"))})))}},computed:function(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?y(Object(n),!0).forEach((function(e){j(t,e,n[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):y(Object(n)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))}))}return t}({bindedValue:function(){return this.editing?this.value:this.user.name}},Object(f.b)("errors",{hasError:"has",getError:"getFirst"}),{},Object(f.c)("auth",{user:function(t){return t.user}}))},E=n(70),C=n(71),x=Object(c.a)(P,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("SaveButton",{attrs:{editing:t.editing},on:{save:t.save}}),t._v(" "),n("div",{staticClass:"input-name",class:{error:t.hasError("name")}},[n("input",{attrs:{type:"text",id:"edit-name"},domProps:{value:t.bindedValue},on:{focus:t.edit,focusout:t.unedit}}),t._v(" "),t.editing&&t.hasError("name")?n("div",{staticClass:"error-text"},[t._v("\n            "+t._s(t.$t("errors."+t.getError("name")))+"\n        ")]):t._e()])],1)}),[],!1,null,null,null);"function"==typeof E.default&&Object(E.default)(x),"function"==typeof C.default&&Object(C.default)(x);var $=x.exports;function S(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),n.push.apply(n,r)}return n}function k(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}var D={components:{SaveButton:p,IconProfile:r.a},data:function(){return{editing:!1,value:""}},mounted:function(){this.value=this.user.name},methods:{edit:function(){this.editing=!0,setTimeout((function(){document.getElementById("edit-name").focus()}),10)},unedit:function(t){var e=this;this.value=t.target.value,setTimeout((function(){e.editing=!1}),10)},save:function(){var t=this;this.value!=this.user.name&&(this.$store.dispatch("errors/clear"),this.$store.dispatch("auth/saveName",this.value).then((function(){t.hasError("name")?(t.editable=!0,document.getElementById("edit-name").focus()):t.$store.dispatch("message/show",t.$t("nameSaved"))})))}},computed:function(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?S(Object(n),!0).forEach((function(e){k(t,e,n[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):S(Object(n)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))}))}return t}({bindedValue:function(){return this.editing?this.value:this.user.name}},Object(f.b)("errors",{hasError:"has",getError:"getFirst"}),{},Object(f.c)("auth",{user:function(t){return t.user}}))},N=n(72),I=n(73),B=Object(c.a)(D,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("div",{staticClass:"block with-errors"},[n("div",{staticClass:"title"},[n("IconProfile",{attrs:{height:"20",classes:"settings-icon vertical-center"}}),t._v(" "),n("div",[t._v(t._s(t.$t("name")))]),t._v(" "),t.editing?t._e():n("div",{staticClass:"change",on:{click:t.edit}},[t._v(t._s(t.$t("change")))])],1),t._v(" "),t.editing?t._e():n("div",{staticClass:"value",on:{click:t.edit}},[t._v(t._s(t.user.name))]),t._v(" "),n("div",{staticClass:"bottom"},[t.editing?n("div",{staticClass:"input-item text-right",class:{error:t.hasError("name")}},[n("input",{attrs:{type:"text",id:"edit-name"},domProps:{value:t.value},on:{focusout:t.unedit}})]):t._e(),t._v(" "),t.hasError("name")?n("div",{staticClass:"error-text"},[t._v("\n                "+t._s(t.$t("errors."+t.getError("name")))+"\n            ")]):t._e(),t._v(" "),n("SaveButton",{attrs:{editing:t.editing},on:{save:t.save}})],1)])])}),[],!1,null,null,null);"function"==typeof N.default&&Object(N.default)(B),"function"==typeof I.default&&Object(I.default)(B);var z=B.exports,H=n(98),q=n(97);function V(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),n.push.apply(n,r)}return n}function L(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}var M={components:{SaveButton:p,IconLock:n(10).a},data:function(){return{editing:!1,old_password:"",password:"",password_confirmation:""}},mounted:function(){this.value=this.user.password},methods:{edit:function(){this.editing=!0,setTimeout((function(){document.getElementById("edit-password").focus()}),10)},unedit:function(t){var e=this;setTimeout((function(){var t=document.activeElement.id;"edit-password"!=t&&"confirm-password"!=t&&"old-password"!=t&&setTimeout((function(){e.editing=!1}),10)}),10)},save:function(){var t=this;this.$store.dispatch("errors/clear"),this.$store.dispatch("auth/savePassword",{old_password:this.old_password,password:this.password,password_confirmation:this.password_confirmation}).then((function(){t.hasError("password")||t.hasError("old_password")?t.edit():(t.$store.dispatch("message/show",t.$t("passwordSaved")),t.old_password="",t.password="",t.password_confirmation="")}))}},computed:function(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?V(Object(n),!0).forEach((function(e){L(t,e,n[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):V(Object(n)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))}))}return t}({},Object(f.b)("errors",{hasError:"has",getError:"getFirst"}),{},Object(f.c)("auth",{user:function(t){return t.user}}))},T=n(74),R=n(75),F=Object(c.a)(M,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("div",{staticClass:"block with-errors"},[n("div",{staticClass:"title"},[n("IconLock",{attrs:{height:"20",classes:"settings-icon vertical-center"}}),t._v(" "),n("div",[t._v(t._s(t.$t("password")))]),t._v(" "),t.editing?t._e():n("div",{staticClass:"change",on:{click:t.edit}},[t._v(t._s(t.$t("change")))])],1),t._v(" "),t.editing?t._e():n("div",{staticClass:"value",on:{click:t.edit}},[t._v("********")]),t._v(" "),n("div",{staticClass:"bottom"},[t.editing?n("div",{staticClass:"input-item",class:{error:t.hasError("old_password")}},[n("label",[t._v(t._s(t.$t("oldPassword")))]),t._v(" "),n("input",{directives:[{name:"model",rawName:"v-model",value:t.old_password,expression:"old_password"}],attrs:{type:"password",id:"old-password",autocomplete:"off"},domProps:{value:t.old_password},on:{focusout:t.unedit,input:function(e){e.target.composing||(t.old_password=e.target.value)}}}),t._v(" "),n("div",{staticClass:"error-text",class:{hidden:!t.hasError("old_password")}},[t._v("\n                    "+t._s(t.$t("errors."+t.getError("old_password")))+"\n                ")])]):t._e(),t._v(" "),t.editing?n("div",{staticClass:"input-item",class:{error:t.hasError("password")}},[n("label",[t._v(t._s(t.$t("newPassword")))]),t._v(" "),n("input",{directives:[{name:"model",rawName:"v-model",value:t.password,expression:"password"}],attrs:{type:"password",id:"edit-password",autocomplete:"off"},domProps:{value:t.password},on:{focusout:t.unedit,input:function(e){e.target.composing||(t.password=e.target.value)}}}),t._v(" "),n("div",{staticClass:"error-text",class:{hidden:!t.hasError("password")}},[t._v("\n                    "+t._s(t.$t("errors."+t.getError("password")))+"\n                ")]),t._v(" "),n("label",[t._v(t._s(t.$t("passwordConfirmation")))]),t._v(" "),n("input",{directives:[{name:"model",rawName:"v-model",value:t.password_confirmation,expression:"password_confirmation"}],attrs:{type:"password",id:"confirm-password",autocomplete:"off"},domProps:{value:t.password_confirmation},on:{focusout:t.unedit,input:function(e){e.target.composing||(t.password_confirmation=e.target.value)}}})]):t._e(),t._v(" "),n("SaveButton",{attrs:{editing:t.editing},on:{save:t.save}})],1)])])}),[],!1,null,null,null);"function"==typeof T.default&&Object(T.default)(F),"function"==typeof R.default&&Object(R.default)(F);var U=F.exports,A=n(8),J={props:["height","classes"]},W=Object(c.a)(J,(function(){var t=this.$createElement,e=this._self._c||t;return e("svg",{staticClass:"fill-current",class:this.classes,attrs:{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",height:this.height}},[e("path",{attrs:{d:"M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm1-11v2h1a3 3 0 0 1 0 6h-1v1a1 1 0 0 1-2 0v-1H8a1 1 0 0 1 0-2h3v-2h-1a3 3 0 0 1 0-6h1V6a1 1 0 0 1 2 0v1h3a1 1 0 0 1 0 2h-3zm-2 0h-1a1 1 0 1 0 0 2h1V9zm2 6h1a1 1 0 0 0 0-2h-1v2z"}})])}),[],!1,null,null,null).exports;function G(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),n.push.apply(n,r)}return n}function K(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}var Q={components:{IconRightChevron:A.a,IconMoney:W},methods:{canExpire:function(){return 0==this.subscription.price&&!this.subscription.prolongable&&"endless"!=this.subscription.period||"Cancelled"==this.subscription.status},isPaid:function(){return this.subscription.price>0},isEndless:function(){return"endless"==this.subscription.period},localizeNext:function(){return this.subscription.next_transaction_date?this.$d(new Date(this.subscription.next_transaction_date),"short"):""}},mounted:function(){this.$store.dispatch("locale/loadSubscriptions")},computed:function(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?G(Object(n),!0).forEach((function(e){K(t,e,n[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):G(Object(n)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))}))}return t}({},Object(f.c)("auth",{subscription:function(t){return t.user.subscription}}))},X=n(76),Y=n(77),Z=Object(c.a)(Q,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("div",{staticClass:"block with-errors"},[n("div",{staticClass:"title"},[n("IconMoney",{attrs:{height:"20",classes:"settings-icon vertical-center"}}),t._v(" "),n("div",[t._v(t._s(t.$t("tariff")))]),t._v(" "),n("div",{staticClass:"change",on:{click:function(e){return t.$router.push({name:"select-tariff"})}}},[t._v("\n                "+t._s(t.$t("change"))+"\n            ")])],1),t._v(" "),n("div",{staticClass:"value",on:{click:function(e){return t.$router.push({name:"select-tariff"})}}},[n("div",{},[t._v(t._s(t.subscription.name[t.$i18n.locale]))]),t._v(" "),n("div",{staticClass:"action"},[n("IconRightChevron",{attrs:{height:"16",classes:"vertical-center ml-auto"}})],1)]),t._v(" "),n("div",{staticClass:"bottom"},[n("div",{staticClass:"warning-text pr-16 lg:ml-30 lg:pl-px lg:text-left"},[t.isEndless()?n("div",[t._v(t._s(t.$t("neverExpire")))]):t._e(),t._v(" "),t.canExpire()?n("div",{staticClass:"text-prime-500"},[t._v("\n                    "+t._s(t.$t("expire",{date:t.localizeNext()}))+"\n                ")]):t._e(),t._v(" "),t.isPaid()&&!t.canExpire()?n("div",[t._v("\n                    "+t._s(t.subscription.price+" "+t.$t("currency."+t.subscription.currency)+"/"+t.$t("periods."+t.subscription.period))+" "),n("br"),t._v("\n                    "+t._s(t.$t("nextPayment",{date:t.localizeNext()}))+"\n                ")]):t._e()])])])])}),[],!1,null,null,null);"function"==typeof X.default&&Object(X.default)(Z),"function"==typeof Y.default&&Object(Y.default)(Z);var tt=Z.exports;function et(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),n.push.apply(n,r)}return n}function nt(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}var rt={components:{IconRightChevron:A.a,IconMoney:W},methods:{},mounted:function(){},computed:function(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?et(Object(n),!0).forEach((function(e){nt(t,e,n[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):et(Object(n)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))}))}return t}({},Object(f.c)("auth",{user:function(t){return t.user}}))},st=n(78),it=n(79),ot=Object(c.a)(rt,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return t.user.cardLastFour?n("div",[n("div",{staticClass:"block with-errors",on:{click:function(e){return t.$router.push({name:"payment-card"})}}},[n("div",{staticClass:"title"},[n("IconMoney",{attrs:{height:"20",classes:"settings-icon vertical-center"}}),t._v(" "),n("div",[t._v(t._s(t.$t("method")))]),t._v(" "),n("div",{staticClass:"change"},[t._v(t._s(t.$t("change")))])],1),t._v(" "),n("div",{staticClass:"value"},[n("div",{},[t._v("** "+t._s(t.user.cardLastFour))]),t._v(" "),n("div",{staticClass:"action"},[n("IconRightChevron",{attrs:{height:"16",classes:"vertical-center ml-auto"}})],1)]),t._v(" "),n("div",{staticClass:"bottom"})])]):t._e()}),[],!1,null,null,null);"function"==typeof st.default&&Object(st.default)(ot),"function"==typeof it.default&&Object(it.default)(ot);var at=ot.exports,ct={props:["height","classes"]},ut=Object(c.a)(ct,(function(){var t=this.$createElement,e=this._self._c||t;return e("svg",{staticClass:"fill-current",class:this.classes,attrs:{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",height:this.height}},[e("path",{attrs:{d:"M18 21H7a4 4 0 0 1-4-4V5c0-1.1.9-2 2-2h10a2 2 0 0 1 2 2h2a2 2 0 0 1 2 2v11a3 3 0 0 1-3 3zm-3-3V5H5v12c0 1.1.9 2 2 2h8.17a3 3 0 0 1-.17-1zm-7-3h4a1 1 0 0 1 0 2H8a1 1 0 0 1 0-2zm0-4h4a1 1 0 0 1 0 2H8a1 1 0 0 1 0-2zm0-4h4a1 1 0 0 1 0 2H8a1 1 0 1 1 0-2zm9 11a1 1 0 0 0 2 0V7h-2v11z"}})])}),[],!1,null,null,null).exports,lt={components:{IconRightChevron:A.a,IconHistory:ut},methods:{},mounted:function(){},computed:{}},dt=n(80),pt=n(81),vt=Object(c.a)(lt,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("div",{staticClass:"block",on:{click:function(e){return t.$router.push({name:"payments"})}}},[n("div",{staticClass:"title"},[n("IconHistory",{attrs:{height:"20",classes:"settings-icon vertical-center"}}),t._v(" "),n("div",[t._v(t._s(t.$t("history")))]),t._v(" "),n("div",{staticClass:"change"},[t._v(t._s(t.$t("view")))])],1),t._v(" "),n("div",{staticClass:"value"},[n("div",{staticClass:"action"},[n("IconRightChevron",{attrs:{height:"16",classes:"vertical-center ml-auto"}})],1)])])])}),[],!1,null,null,null);"function"==typeof dt.default&&Object(dt.default)(vt),"function"==typeof pt.default&&Object(pt.default)(vt);var ft=vt.exports,ht=n(99);function _t(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),n.push.apply(n,r)}return n}function mt(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}var gt={components:{Page:o.a,PageHeader:i.a,EmailEditable:O,NameEditable:$,NameEditableLarge:z,LocaleEditable:q.a,PasswordEditable:U,IconProfile:r.a,SubscriptionEditable:tt,PaymentMethod:at,PaymentsHistory:ft,NightMode:H.a,LoadingButton:s.a,Oferta:ht.a},data:function(){return{}},methods:{logout:function(){var t=this;this.$store.dispatch("auth/logout").then((function(){t.$router.push({name:"home"})}))}},computed:function(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?_t(Object(n),!0).forEach((function(e){mt(t,e,n[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):_t(Object(n)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))}))}return t}({large:function(){return window.innerWidth>1024}},Object(f.b)("errors",{errorsHappened:"happened"}),{},Object(f.c)("auth",{user:function(t){return t.user},loaded:function(t){return t.loaded}}))},bt=n(82),wt=n(83),Ot=Object(c.a)(gt,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("Page",{scopedSlots:t._u([{key:"bottom",fn:function(){return[t.large?t._e():n("div",{staticClass:"settings"},[n("EmailEditable"),t._v(" "),n("PasswordEditable"),t._v(" "),n("LocaleEditable"),t._v(" "),n("NightMode"),t._v(" "),n("SubscriptionEditable"),t._v(" "),n("PaymentMethod"),t._v(" "),n("PaymentsHistory"),t._v(" "),n("Oferta")],1),t._v(" "),t.large?n("div",[n("LoadingButton",{on:{clicked:t.logout}},[t._v(t._s(t.$t("logout")))]),t._v(" "),n("div",{staticClass:"settings"},[n("LocaleEditable"),t._v(" "),n("NightMode"),t._v(" "),n("Oferta")],1)],1):t._e()]},proxy:!0}])},[n("PageHeader",{attrs:{back:"dashboard"}},[t._v("\n        "+t._s(t.$t("pageTitle"))+"\n    ")]),t._v(" "),t.large?t._e():n("div",[n("div",{staticClass:"page-icon"},[n("IconProfile",{attrs:{classes:"mx-auto",height:"75"}})],1),t._v(" "),n("NameEditable"),t._v(" "),n("LoadingButton",{on:{clicked:t.logout}},[t._v(t._s(t.$t("logout")))])],1),t._v(" "),t.large?n("div",{staticClass:"page-container double settings large"},[n("NameEditableLarge"),t._v(" "),n("SubscriptionEditable"),t._v(" "),n("EmailEditable"),t._v(" "),n("PaymentMethod"),t._v(" "),n("PasswordEditable"),t._v(" "),n("PaymentsHistory")],1):t._e()],1)}),[],!1,null,null,null);"function"==typeof bt.default&&Object(bt.default)(Ot),"function"==typeof wt.default&&Object(wt.default)(Ot);e.default=Ot.exports},23:function(t,e){t.exports=function(t){t.options.__i18n=t.options.__i18n||[],t.options.__i18n.push('{"ru":{"save":"Сохранить"}}'),delete t.options._Ctor}},24:function(t,e){t.exports=function(t){t.options.__i18n=t.options.__i18n||[],t.options.__i18n.push('{"en":null}'),delete t.options._Ctor}},25:function(t,e){t.exports=function(t){t.options.__i18n=t.options.__i18n||[],t.options.__i18n.push('{"ru":{"email":"Электронная почта","warning":"Нужно будет подтвердить после изменения","emailSaved":"Новая электронная почта сохранена. Подвердите ее с помощью ссылки в письме.","change":"Изменить","errors":{"email":{"required":"Элетронная почта обезательно нужна","email":"Электронная почта должна быть настоящей","unique":"Такой адрес элекронной почты уже используется"}}}}'),delete t.options._Ctor}},26:function(t,e){t.exports=function(t){t.options.__i18n=t.options.__i18n||[],t.options.__i18n.push('{"en":{"email":"Email","warning":"Verification will be required after change","emailSaved":"New email was saved. Please verify it by link in email.","change":"Change","errors":{"email":{"required":"Email is required","email":"Please provide correct email","unique":"Somebody already registered with this email"}}}}'),delete t.options._Ctor}},27:function(t,e){t.exports=function(t){t.options.__i18n=t.options.__i18n||[],t.options.__i18n.push('{"ru":{"nameSaved":"Имя сохранено","errors":{"name":{"required":"Имя обязательно нужно","string":"В имени нельзя писать загадочные символы","min":"Имя должно быть хотя бы из трех букв"}}}}'),delete t.options._Ctor}},28:function(t,e){t.exports=function(t){t.options.__i18n=t.options.__i18n||[],t.options.__i18n.push('{"en":{"nameSaved":"Name was saved","errors":{"name":{"required":"Name is required","string":"Please use only letters and numbers","min":"Name must be at least 3 letters"}}}}'),delete t.options._Ctor}},29:function(t,e){t.exports=function(t){t.options.__i18n=t.options.__i18n||[],t.options.__i18n.push('{"ru":{"name":"Имя","nameSaved":"Имя сохранено","change":"Изменить","errors":{"name":{"required":"Имя обязательно нужно","string":"В имени нельзя писать загадочные символы","min":"Имя должно быть хотя бы из трех букв"}}}}'),delete t.options._Ctor}},30:function(t,e){t.exports=function(t){t.options.__i18n=t.options.__i18n||[],t.options.__i18n.push('{"en":{"name":"Name","nameSaved":"Name was saved","change":"Change","errors":{"name":{"required":"Name is required","string":"Please use only letters and numbers","min":"Name must be at least 3 letters"}}}}'),delete t.options._Ctor}},31:function(t,e){t.exports=function(t){t.options.__i18n=t.options.__i18n||[],t.options.__i18n.push('{"ru":{"password":"Пароль","newPassword":"Новый пароль","passwordConfirmation":"Подтверждение пароля","oldPassword":"Старый пароль","passwordSaved":"Пароль сохранен","change":"Изменить","errors":{"password":{"required":"Пароль обязательно нужен","min":"Пароль должен быть не меньше 8 символов","confirmed":"Пароль и подтверждение пароля должны совпадать"},"old_password":{"required":"Старый пароль обязательно нужен","password":"Старый пароль не правильный"}}}}'),delete t.options._Ctor}},32:function(t,e){t.exports=function(t){t.options.__i18n=t.options.__i18n||[],t.options.__i18n.push('{"en":{"password":"Password","newPassword":"New password","passwordConfirmation":"Confirm password","oldPassword":"Old password","passwordSaved":"Password was saved","change":"Change","errors":{"password":{"required":"Password is required","min":"Password must be at least 8 symbols","confirmed":"Password and confirmation must be the same"},"old_password":{"required":"Old password is required","password":"Old password is incorrect"}}}}'),delete t.options._Ctor}},33:function(t,e){t.exports=function(t){t.options.__i18n=t.options.__i18n||[],t.options.__i18n.push('{"ru":{"tariff":"Тарифный план","change":"Изменить","currency":{"RUB":"рублей"},"expire":"Закончится {date}","neverExpire":"Не закончится никогда","nextPayment":"Следующий автоматический платеж {date}"}}'),delete t.options._Ctor}},34:function(t,e){t.exports=function(t){t.options.__i18n=t.options.__i18n||[],t.options.__i18n.push('{"en":{"tariff":"Subscription plan","change":"Change","currency":{"RUB":"RUB"},"expire":"Will expire {date}","neverExpire":"Never expire","nextPayment":"Next payment {date}"}}'),delete t.options._Ctor}},35:function(t,e){t.exports=function(t){t.options.__i18n=t.options.__i18n||[],t.options.__i18n.push('{"ru":{"method":"Привязанная карта","change":"Изменить"}}'),delete t.options._Ctor}},36:function(t,e){t.exports=function(t){t.options.__i18n=t.options.__i18n||[],t.options.__i18n.push('{"en":{"method":"Saved credit card","change":"Change"}}'),delete t.options._Ctor}},37:function(t,e){t.exports=function(t){t.options.__i18n=t.options.__i18n||[],t.options.__i18n.push('{"ru":{"history":"История платежей","view":"Посмотреть"}}'),delete t.options._Ctor}},38:function(t,e){t.exports=function(t){t.options.__i18n=t.options.__i18n||[],t.options.__i18n.push('{"en":{"history":"Payments history","view":"View"}}'),delete t.options._Ctor}},39:function(t,e){t.exports=function(t){t.options.__i18n=t.options.__i18n||[],t.options.__i18n.push('{"ru":{"pageTitle":"Профиль","logout":"Выйти"}}'),delete t.options._Ctor}},40:function(t,e){t.exports=function(t){t.options.__i18n=t.options.__i18n||[],t.options.__i18n.push('{"en":{"pageTitle":"Profile","logout":"Logout"}}'),delete t.options._Ctor}},54:function(t,e,n){"use strict";var r={props:["height","classes"]},s=n(0),i=Object(s.a)(r,(function(){var t=this.$createElement,e=this._self._c||t;return e("svg",{staticClass:"fill-current",class:this.classes,attrs:{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",height:this.height}},[e("path",{attrs:{d:"M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6c0-1.1.9-2 2-2zm16 3.38V6H4v1.38l8 4 8-4zm0 2.24l-7.55 3.77a1 1 0 0 1-.9 0L4 9.62V18h16V9.62z"}})])}),[],!1,null,null,null);e.a=i.exports},66:function(t,e,n){"use strict";var r=n(23),s=n.n(r);e.default=s.a},67:function(t,e,n){"use strict";var r=n(24),s=n.n(r);e.default=s.a},68:function(t,e,n){"use strict";var r=n(25),s=n.n(r);e.default=s.a},69:function(t,e,n){"use strict";var r=n(26),s=n.n(r);e.default=s.a},70:function(t,e,n){"use strict";var r=n(27),s=n.n(r);e.default=s.a},71:function(t,e,n){"use strict";var r=n(28),s=n.n(r);e.default=s.a},72:function(t,e,n){"use strict";var r=n(29),s=n.n(r);e.default=s.a},73:function(t,e,n){"use strict";var r=n(30),s=n.n(r);e.default=s.a},74:function(t,e,n){"use strict";var r=n(31),s=n.n(r);e.default=s.a},75:function(t,e,n){"use strict";var r=n(32),s=n.n(r);e.default=s.a},76:function(t,e,n){"use strict";var r=n(33),s=n.n(r);e.default=s.a},77:function(t,e,n){"use strict";var r=n(34),s=n.n(r);e.default=s.a},78:function(t,e,n){"use strict";var r=n(35),s=n.n(r);e.default=s.a},79:function(t,e,n){"use strict";var r=n(36),s=n.n(r);e.default=s.a},80:function(t,e,n){"use strict";var r=n(37),s=n.n(r);e.default=s.a},81:function(t,e,n){"use strict";var r=n(38),s=n.n(r);e.default=s.a},82:function(t,e,n){"use strict";var r=n(39),s=n.n(r);e.default=s.a},83:function(t,e,n){"use strict";var r=n(40),s=n.n(r);e.default=s.a}}]);