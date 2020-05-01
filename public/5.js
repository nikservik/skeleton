(window.webpackJsonp=window.webpackJsonp||[]).push([[5],{11:function(e,t,r){"use strict";var s={props:["height","classes"]},n=r(0),i=Object(n.a)(s,(function(){var e=this.$createElement,t=this._self._c||e;return t("svg",{staticClass:"fill-current",class:this.classes,attrs:{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",height:this.height}},[t("path",{attrs:{d:"M11.85 17.56a1.5 1.5 0 0 1-1.06.44H10v.5c0 .83-.67 1.5-1.5 1.5H8v.5c0 .83-.67 1.5-1.5 1.5H4a2 2 0 0 1-2-2v-2.59A2 2 0 0 1 2.59 16l5.56-5.56A7.03 7.03 0 0 1 15 2a7 7 0 1 1-1.44 13.85l-1.7 1.71zm1.12-3.95l.58.18a5 5 0 1 0-3.34-3.34l.18.58L4 17.4V20h2v-.5c0-.83.67-1.5 1.5-1.5H8v-.5c0-.83.67-1.5 1.5-1.5h1.09l2.38-2.39zM18 9a1 1 0 0 1-2 0 1 1 0 0 0-1-1 1 1 0 0 1 0-2 3 3 0 0 1 3 3z"}})])}),[],!1,null,null,null);t.a=i.exports},18:function(e,t){e.exports=function(e){e.options.__i18n=e.options.__i18n||[],e.options.__i18n.push('{"ru":{"pageTitle":"Напоминание пароля","email":"Электронная почта","send":"Отправить напоминание","link":{"sent":"Письмо со ссылкой для установки нового пароля отправлено."},"errors":{"validation":"Исправьте ошибки, чтобы отправить напоминание пароля","email":{"required":"Электронная почта обязательно нужна","exists":"Нет пользователя с такой электронной почтой"},"passwords":{"user":"Нет пользователя с такой электронной почтой","throttled":"Слишком много попыток. Попробуйте немного позже"}}}}'),delete e.options._Ctor}},182:function(e,t,r){"use strict";r.r(t);var s=r(11),n=r(3),i=r(5),a=r(8),o=r(4),l=r(1);function c(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var s=Object.getOwnPropertySymbols(e);t&&(s=s.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,s)}return r}function u(e,t,r){return t in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}var p={components:{IconLock:s.a,Page:n.a,PageHeader:o.a,PageBlock:i.a,BigButton:a.a},data:function(){return{email:null}},mounted:function(){},methods:{remind:function(){this.$store.dispatch("errors/clear"),this.$store.dispatch("auth/remind",this.email)}},computed:function(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?c(Object(r),!0).forEach((function(t){u(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):c(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}({},Object(l.b)("loading",{disable:"disable"}),{},Object(l.b)("errors",{errorsHappened:"happened",hasError:"has"}),{},Object(l.c)("errors",{errors:function(e){return e.errors}}),{},Object(l.c)("message",{message:function(e){return e.message}}))},d=r(0),m=r(89),f=r(90),h=Object(d.a)(p,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("Page",{scopedSlots:e._u([{key:"bottom",fn:function(){return[r("form",{staticClass:"form",on:{submit:function(t){return t.preventDefault(),e.remind(t)}}},[r("div",{staticClass:"group",class:{"has-error":e.hasError("email")}},[r("label",{attrs:{for:"email"}},[e._v(e._s(e.$t("email")))]),e._v(" "),r("input",{directives:[{name:"model",rawName:"v-model",value:e.email,expression:"email"}],attrs:{type:"email",placeholder:"user@example.com",required:""},domProps:{value:e.email},on:{input:function(t){t.target.composing||(e.email=t.target.value)}}}),e._v(" "),e._l(e.errors.email,(function(t){return e.hasError("email")?r("div",{staticClass:"error-description"},[e._v("\n                    "+e._s(e.$t("errors."+t))+"\n                ")]):e._e()}))],2),e._v(" "),r("BigButton",{attrs:{disable:e.disable},on:{clicked:e.remind}},[e._v("\n              "+e._s(e.$t("send"))+"\n            ")])],1)]},proxy:!0}])},[r("PageHeader",{attrs:{back:"login"}},[e._v("\n        "+e._s(e.$t("pageTitle"))+"\n    ")]),e._v(" "),r("div",{staticClass:"page-icon"},[r("IconLock",{attrs:{classes:"mx-auto",height:"75"}})],1)],1)}),[],!1,null,null,null);"function"==typeof m.default&&Object(m.default)(h),"function"==typeof f.default&&Object(f.default)(h);t.default=h.exports},19:function(e,t){e.exports=function(e){e.options.__i18n=e.options.__i18n||[],e.options.__i18n.push('{"en":{"pageTitle":"Remind password","email":"Email","send":"Send me a link","link":{"sent":"Email with password reset link was sent to you"},"errors":{"validation":"Please provide correct data to get a reminder link","email":{"required":"Email is required","exists":"User with this email doesn\'t exists"},"passwords":{"user":"User with this email doesn\'t exists","throttled":"Too many attempts. Please try later"}}}}'),delete e.options._Ctor}},89:function(e,t,r){"use strict";var s=r(18),n=r.n(s);t.default=n.a},90:function(e,t,r){"use strict";var s=r(19),n=r.n(s);t.default=n.a}}]);