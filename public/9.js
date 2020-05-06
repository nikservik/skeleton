(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[9],{

/***/ "./node_modules/@intlify/vue-i18n-loader/lib/index.js!./node_modules/vue-loader/lib/index.js?!./resources/js/components/settings/NameEditable.vue?vue&type=custom&index=0&blockType=i18n&locale=ru&lang=yaml":
/*!********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/@intlify/vue-i18n-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/settings/NameEditable.vue?vue&type=custom&index=0&blockType=i18n&locale=ru&lang=yaml ***!
  \********************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = function (Component) {
  Component.options.__i18n = Component.options.__i18n || []
  Component.options.__i18n.push('{"ru":{"nameSaved":"Имя сохранено","errors":{"name":{"required":"Имя обязательно нужно","string":"В имени нельзя писать загадочные символы","min":"Имя должно быть хотя бы из трех букв"}}}}')
  delete Component.options._Ctor
}


/***/ }),

/***/ "./node_modules/@intlify/vue-i18n-loader/lib/index.js!./node_modules/vue-loader/lib/index.js?!./resources/js/components/settings/NameEditable.vue?vue&type=custom&index=1&blockType=i18n&locale=en&lang=yaml":
/*!********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/@intlify/vue-i18n-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/settings/NameEditable.vue?vue&type=custom&index=1&blockType=i18n&locale=en&lang=yaml ***!
  \********************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = function (Component) {
  Component.options.__i18n = Component.options.__i18n || []
  Component.options.__i18n.push('{"en":{"nameSaved":"Name was saved","errors":{"name":{"required":"Name is required","string":"Please use only letters and numbers","min":"Name must be at least 3 letters"}}}}')
  delete Component.options._Ctor
}


/***/ }),

/***/ "./node_modules/@intlify/vue-i18n-loader/lib/index.js!./node_modules/vue-loader/lib/index.js?!./resources/js/views/user/Profile.vue?vue&type=custom&index=0&blockType=i18n&locale=ru&lang=yaml":
/*!******************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/@intlify/vue-i18n-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/user/Profile.vue?vue&type=custom&index=0&blockType=i18n&locale=ru&lang=yaml ***!
  \******************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = function (Component) {
  Component.options.__i18n = Component.options.__i18n || []
  Component.options.__i18n.push('{"ru":{"pageTitle":"Профиль","logout":"Выйти"}}')
  delete Component.options._Ctor
}


/***/ }),

/***/ "./node_modules/@intlify/vue-i18n-loader/lib/index.js!./node_modules/vue-loader/lib/index.js?!./resources/js/views/user/Profile.vue?vue&type=custom&index=1&blockType=i18n&locale=en&lang=yaml":
/*!******************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/@intlify/vue-i18n-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/user/Profile.vue?vue&type=custom&index=1&blockType=i18n&locale=en&lang=yaml ***!
  \******************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = function (Component) {
  Component.options.__i18n = Component.options.__i18n || []
  Component.options.__i18n.push('{"en":{"pageTitle":"Profile","logout":"Logout"}}')
  delete Component.options._Ctor
}


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/settings/NameEditable.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/settings/NameEditable.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_visual_SaveButton__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @/components/visual/SaveButton */ "./resources/js/components/visual/SaveButton.vue");
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    SaveButton: _components_visual_SaveButton__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  data: function data() {
    return {
      editing: false,
      value: ''
    };
  },
  mounted: function mounted() {
    this.value = this.user.name;
  },
  methods: {
    edit: function edit() {
      this.editing = true;
    },
    unedit: function unedit(event) {
      var _this = this;

      this.value = event.target.value;
      setTimeout(function () {
        _this.editing = false;
      }, 10);
    },
    save: function save() {
      var _this2 = this;

      if (this.value == this.user.name) return;
      this.$store.dispatch('errors/clear');
      this.$store.dispatch('auth/saveName', this.value).then(function () {
        if (_this2.hasError('name')) {
          _this2.editable = true;
          document.getElementById('edit-name').focus();
        } else _this2.$store.dispatch('message/show', _this2.$t('nameSaved'));
      });
    }
  },
  computed: _objectSpread({
    bindedValue: function bindedValue() {
      return this.editing ? this.value : this.user.name;
    }
  }, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapGetters"])('errors', {
    hasError: 'has',
    getError: 'getFirst'
  }), {}, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapState"])('auth', {
    user: function user(state) {
      return state.user;
    }
  }))
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/user/Profile.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/user/Profile.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_visual_icons_IconProfile__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @/components/visual/icons/IconProfile */ "./resources/js/components/visual/icons/IconProfile.vue");
/* harmony import */ var _components_visual_LoadingButton__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/components/visual/LoadingButton */ "./resources/js/components/visual/LoadingButton.vue");
/* harmony import */ var _components_visual_PageHeader__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @/components/visual/PageHeader */ "./resources/js/components/visual/PageHeader.vue");
/* harmony import */ var _components_visual_Page__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @/components/visual/Page */ "./resources/js/components/visual/Page.vue");
/* harmony import */ var _components_settings_EmailEditable__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @/components/settings/EmailEditable */ "./resources/js/components/settings/EmailEditable.vue");
/* harmony import */ var _components_settings_NameEditable__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @/components/settings/NameEditable */ "./resources/js/components/settings/NameEditable.vue");
/* harmony import */ var _components_settings_NameEditableLarge__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @/components/settings/NameEditableLarge */ "./resources/js/components/settings/NameEditableLarge.vue");
/* harmony import */ var _components_settings_NightMode__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @/components/settings/NightMode */ "./resources/js/components/settings/NightMode.vue");
/* harmony import */ var _components_settings_LocaleEditable__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @/components/settings/LocaleEditable */ "./resources/js/components/settings/LocaleEditable.vue");
/* harmony import */ var _components_settings_PasswordEditable__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @/components/settings/PasswordEditable */ "./resources/js/components/settings/PasswordEditable.vue");
/* harmony import */ var _components_settings_SubscriptionEditable__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! @/components/settings/SubscriptionEditable */ "./resources/js/components/settings/SubscriptionEditable.vue");
/* harmony import */ var _components_settings_PaymentMethod__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! @/components/settings/PaymentMethod */ "./resources/js/components/settings/PaymentMethod.vue");
/* harmony import */ var _components_settings_PaymentsHistory__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! @/components/settings/PaymentsHistory */ "./resources/js/components/settings/PaymentsHistory.vue");
/* harmony import */ var _components_settings_Oferta__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! @/components/settings/Oferta */ "./resources/js/components/settings/Oferta.vue");
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//















/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    Page: _components_visual_Page__WEBPACK_IMPORTED_MODULE_3__["default"],
    PageHeader: _components_visual_PageHeader__WEBPACK_IMPORTED_MODULE_2__["default"],
    EmailEditable: _components_settings_EmailEditable__WEBPACK_IMPORTED_MODULE_4__["default"],
    NameEditable: _components_settings_NameEditable__WEBPACK_IMPORTED_MODULE_5__["default"],
    NameEditableLarge: _components_settings_NameEditableLarge__WEBPACK_IMPORTED_MODULE_6__["default"],
    LocaleEditable: _components_settings_LocaleEditable__WEBPACK_IMPORTED_MODULE_8__["default"],
    PasswordEditable: _components_settings_PasswordEditable__WEBPACK_IMPORTED_MODULE_9__["default"],
    IconProfile: _components_visual_icons_IconProfile__WEBPACK_IMPORTED_MODULE_0__["default"],
    SubscriptionEditable: _components_settings_SubscriptionEditable__WEBPACK_IMPORTED_MODULE_10__["default"],
    PaymentMethod: _components_settings_PaymentMethod__WEBPACK_IMPORTED_MODULE_11__["default"],
    PaymentsHistory: _components_settings_PaymentsHistory__WEBPACK_IMPORTED_MODULE_12__["default"],
    NightMode: _components_settings_NightMode__WEBPACK_IMPORTED_MODULE_7__["default"],
    LoadingButton: _components_visual_LoadingButton__WEBPACK_IMPORTED_MODULE_1__["default"],
    Oferta: _components_settings_Oferta__WEBPACK_IMPORTED_MODULE_13__["default"]
  },
  data: function data() {
    return {};
  },
  methods: {
    logout: function logout() {
      var _this = this;

      this.$store.dispatch('auth/logout').then(function () {
        _this.$router.push({
          name: 'home'
        });
      });
    }
  },
  computed: _objectSpread({
    large: function large() {
      return window.innerWidth > 1024;
    }
  }, Object(vuex__WEBPACK_IMPORTED_MODULE_14__["mapGetters"])('errors', {
    errorsHappened: 'happened'
  }), {}, Object(vuex__WEBPACK_IMPORTED_MODULE_14__["mapState"])('auth', {
    user: function user(state) {
      return state.user;
    },
    loaded: function loaded(state) {
      return state.loaded;
    }
  }))
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/settings/NameEditable.vue?vue&type=template&id=182885e0&":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/settings/NameEditable.vue?vue&type=template&id=182885e0& ***!
  \************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c("SaveButton", {
        attrs: { editing: _vm.editing },
        on: { save: _vm.save }
      }),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "input-name", class: { error: _vm.hasError("name") } },
        [
          _c("input", {
            attrs: { type: "text", id: "edit-name" },
            domProps: { value: _vm.bindedValue },
            on: { focus: _vm.edit, focusout: _vm.unedit }
          }),
          _vm._v(" "),
          _vm.editing && _vm.hasError("name")
            ? _c("div", { staticClass: "error-text" }, [
                _vm._v(
                  "\n            " +
                    _vm._s(_vm.$t("errors." + _vm.getError("name"))) +
                    "\n        "
                )
              ])
            : _vm._e()
        ]
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/user/Profile.vue?vue&type=template&id=45366d78&":
/*!**********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/user/Profile.vue?vue&type=template&id=45366d78& ***!
  \**********************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "Page",
    {
      scopedSlots: _vm._u([
        {
          key: "bottom",
          fn: function() {
            return [
              !_vm.large
                ? _c(
                    "div",
                    { staticClass: "settings" },
                    [
                      _c("EmailEditable"),
                      _vm._v(" "),
                      _c("PasswordEditable"),
                      _vm._v(" "),
                      _c("LocaleEditable"),
                      _vm._v(" "),
                      _c("NightMode"),
                      _vm._v(" "),
                      _c("SubscriptionEditable"),
                      _vm._v(" "),
                      _c("PaymentMethod"),
                      _vm._v(" "),
                      _c("PaymentsHistory"),
                      _vm._v(" "),
                      _c("Oferta")
                    ],
                    1
                  )
                : _vm._e(),
              _vm._v(" "),
              _vm.large
                ? _c(
                    "div",
                    [
                      _c("LoadingButton", { on: { clicked: _vm.logout } }, [
                        _vm._v(_vm._s(_vm.$t("logout")))
                      ]),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "settings" },
                        [
                          _c("LocaleEditable"),
                          _vm._v(" "),
                          _c("NightMode"),
                          _vm._v(" "),
                          _c("Oferta")
                        ],
                        1
                      )
                    ],
                    1
                  )
                : _vm._e()
            ]
          },
          proxy: true
        }
      ])
    },
    [
      _c("PageHeader", { attrs: { back: "dashboard" } }, [
        _vm._v("\n        " + _vm._s(_vm.$t("pageTitle")) + "\n    ")
      ]),
      _vm._v(" "),
      !_vm.large
        ? _c(
            "div",
            [
              _c(
                "div",
                { staticClass: "page-icon" },
                [
                  _c("IconProfile", {
                    attrs: { classes: "mx-auto", height: "75" }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c("NameEditable"),
              _vm._v(" "),
              _c("LoadingButton", { on: { clicked: _vm.logout } }, [
                _vm._v(_vm._s(_vm.$t("logout")))
              ])
            ],
            1
          )
        : _vm._e(),
      _vm._v(" "),
      _vm.large
        ? _c(
            "div",
            { staticClass: "page-container double settings large" },
            [
              _c("NameEditableLarge"),
              _vm._v(" "),
              _c("SubscriptionEditable"),
              _vm._v(" "),
              _c("EmailEditable"),
              _vm._v(" "),
              _c("PaymentMethod"),
              _vm._v(" "),
              _c("PasswordEditable"),
              _vm._v(" "),
              _c("PaymentsHistory")
            ],
            1
          )
        : _vm._e()
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/settings/NameEditable.vue":
/*!***********************************************************!*\
  !*** ./resources/js/components/settings/NameEditable.vue ***!
  \***********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _NameEditable_vue_vue_type_template_id_182885e0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./NameEditable.vue?vue&type=template&id=182885e0& */ "./resources/js/components/settings/NameEditable.vue?vue&type=template&id=182885e0&");
/* harmony import */ var _NameEditable_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./NameEditable.vue?vue&type=script&lang=js& */ "./resources/js/components/settings/NameEditable.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");
/* harmony import */ var _NameEditable_vue_vue_type_custom_index_0_blockType_i18n_locale_ru_lang_yaml__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./NameEditable.vue?vue&type=custom&index=0&blockType=i18n&locale=ru&lang=yaml */ "./resources/js/components/settings/NameEditable.vue?vue&type=custom&index=0&blockType=i18n&locale=ru&lang=yaml");
/* harmony import */ var _NameEditable_vue_vue_type_custom_index_1_blockType_i18n_locale_en_lang_yaml__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./NameEditable.vue?vue&type=custom&index=1&blockType=i18n&locale=en&lang=yaml */ "./resources/js/components/settings/NameEditable.vue?vue&type=custom&index=1&blockType=i18n&locale=en&lang=yaml");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _NameEditable_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _NameEditable_vue_vue_type_template_id_182885e0___WEBPACK_IMPORTED_MODULE_0__["render"],
  _NameEditable_vue_vue_type_template_id_182885e0___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* custom blocks */

if (typeof _NameEditable_vue_vue_type_custom_index_0_blockType_i18n_locale_ru_lang_yaml__WEBPACK_IMPORTED_MODULE_3__["default"] === 'function') Object(_NameEditable_vue_vue_type_custom_index_0_blockType_i18n_locale_ru_lang_yaml__WEBPACK_IMPORTED_MODULE_3__["default"])(component)

if (typeof _NameEditable_vue_vue_type_custom_index_1_blockType_i18n_locale_en_lang_yaml__WEBPACK_IMPORTED_MODULE_4__["default"] === 'function') Object(_NameEditable_vue_vue_type_custom_index_1_blockType_i18n_locale_en_lang_yaml__WEBPACK_IMPORTED_MODULE_4__["default"])(component)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/settings/NameEditable.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/settings/NameEditable.vue?vue&type=custom&index=0&blockType=i18n&locale=ru&lang=yaml":
/*!**********************************************************************************************************************!*\
  !*** ./resources/js/components/settings/NameEditable.vue?vue&type=custom&index=0&blockType=i18n&locale=ru&lang=yaml ***!
  \**********************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_intlify_vue_i18n_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_NameEditable_vue_vue_type_custom_index_0_blockType_i18n_locale_ru_lang_yaml__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/@intlify/vue-i18n-loader/lib!../../../../node_modules/vue-loader/lib??vue-loader-options!./NameEditable.vue?vue&type=custom&index=0&blockType=i18n&locale=ru&lang=yaml */ "./node_modules/@intlify/vue-i18n-loader/lib/index.js!./node_modules/vue-loader/lib/index.js?!./resources/js/components/settings/NameEditable.vue?vue&type=custom&index=0&blockType=i18n&locale=ru&lang=yaml");
/* harmony import */ var _node_modules_intlify_vue_i18n_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_NameEditable_vue_vue_type_custom_index_0_blockType_i18n_locale_ru_lang_yaml__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_intlify_vue_i18n_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_NameEditable_vue_vue_type_custom_index_0_blockType_i18n_locale_ru_lang_yaml__WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_intlify_vue_i18n_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_NameEditable_vue_vue_type_custom_index_0_blockType_i18n_locale_ru_lang_yaml__WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_intlify_vue_i18n_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_NameEditable_vue_vue_type_custom_index_0_blockType_i18n_locale_ru_lang_yaml__WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_intlify_vue_i18n_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_NameEditable_vue_vue_type_custom_index_0_blockType_i18n_locale_ru_lang_yaml__WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/components/settings/NameEditable.vue?vue&type=custom&index=1&blockType=i18n&locale=en&lang=yaml":
/*!**********************************************************************************************************************!*\
  !*** ./resources/js/components/settings/NameEditable.vue?vue&type=custom&index=1&blockType=i18n&locale=en&lang=yaml ***!
  \**********************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_intlify_vue_i18n_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_NameEditable_vue_vue_type_custom_index_1_blockType_i18n_locale_en_lang_yaml__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/@intlify/vue-i18n-loader/lib!../../../../node_modules/vue-loader/lib??vue-loader-options!./NameEditable.vue?vue&type=custom&index=1&blockType=i18n&locale=en&lang=yaml */ "./node_modules/@intlify/vue-i18n-loader/lib/index.js!./node_modules/vue-loader/lib/index.js?!./resources/js/components/settings/NameEditable.vue?vue&type=custom&index=1&blockType=i18n&locale=en&lang=yaml");
/* harmony import */ var _node_modules_intlify_vue_i18n_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_NameEditable_vue_vue_type_custom_index_1_blockType_i18n_locale_en_lang_yaml__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_intlify_vue_i18n_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_NameEditable_vue_vue_type_custom_index_1_blockType_i18n_locale_en_lang_yaml__WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_intlify_vue_i18n_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_NameEditable_vue_vue_type_custom_index_1_blockType_i18n_locale_en_lang_yaml__WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_intlify_vue_i18n_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_NameEditable_vue_vue_type_custom_index_1_blockType_i18n_locale_en_lang_yaml__WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_intlify_vue_i18n_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_NameEditable_vue_vue_type_custom_index_1_blockType_i18n_locale_en_lang_yaml__WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/components/settings/NameEditable.vue?vue&type=script&lang=js&":
/*!************************************************************************************!*\
  !*** ./resources/js/components/settings/NameEditable.vue?vue&type=script&lang=js& ***!
  \************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_NameEditable_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./NameEditable.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/settings/NameEditable.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_NameEditable_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/settings/NameEditable.vue?vue&type=template&id=182885e0&":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/settings/NameEditable.vue?vue&type=template&id=182885e0& ***!
  \******************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_NameEditable_vue_vue_type_template_id_182885e0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./NameEditable.vue?vue&type=template&id=182885e0& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/settings/NameEditable.vue?vue&type=template&id=182885e0&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_NameEditable_vue_vue_type_template_id_182885e0___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_NameEditable_vue_vue_type_template_id_182885e0___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/views/user/Profile.vue":
/*!*********************************************!*\
  !*** ./resources/js/views/user/Profile.vue ***!
  \*********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Profile_vue_vue_type_template_id_45366d78___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Profile.vue?vue&type=template&id=45366d78& */ "./resources/js/views/user/Profile.vue?vue&type=template&id=45366d78&");
/* harmony import */ var _Profile_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Profile.vue?vue&type=script&lang=js& */ "./resources/js/views/user/Profile.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");
/* harmony import */ var _Profile_vue_vue_type_custom_index_0_blockType_i18n_locale_ru_lang_yaml__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./Profile.vue?vue&type=custom&index=0&blockType=i18n&locale=ru&lang=yaml */ "./resources/js/views/user/Profile.vue?vue&type=custom&index=0&blockType=i18n&locale=ru&lang=yaml");
/* harmony import */ var _Profile_vue_vue_type_custom_index_1_blockType_i18n_locale_en_lang_yaml__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./Profile.vue?vue&type=custom&index=1&blockType=i18n&locale=en&lang=yaml */ "./resources/js/views/user/Profile.vue?vue&type=custom&index=1&blockType=i18n&locale=en&lang=yaml");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Profile_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Profile_vue_vue_type_template_id_45366d78___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Profile_vue_vue_type_template_id_45366d78___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* custom blocks */

if (typeof _Profile_vue_vue_type_custom_index_0_blockType_i18n_locale_ru_lang_yaml__WEBPACK_IMPORTED_MODULE_3__["default"] === 'function') Object(_Profile_vue_vue_type_custom_index_0_blockType_i18n_locale_ru_lang_yaml__WEBPACK_IMPORTED_MODULE_3__["default"])(component)

if (typeof _Profile_vue_vue_type_custom_index_1_blockType_i18n_locale_en_lang_yaml__WEBPACK_IMPORTED_MODULE_4__["default"] === 'function') Object(_Profile_vue_vue_type_custom_index_1_blockType_i18n_locale_en_lang_yaml__WEBPACK_IMPORTED_MODULE_4__["default"])(component)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/user/Profile.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/user/Profile.vue?vue&type=custom&index=0&blockType=i18n&locale=ru&lang=yaml":
/*!********************************************************************************************************!*\
  !*** ./resources/js/views/user/Profile.vue?vue&type=custom&index=0&blockType=i18n&locale=ru&lang=yaml ***!
  \********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_intlify_vue_i18n_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_Profile_vue_vue_type_custom_index_0_blockType_i18n_locale_ru_lang_yaml__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/@intlify/vue-i18n-loader/lib!../../../../node_modules/vue-loader/lib??vue-loader-options!./Profile.vue?vue&type=custom&index=0&blockType=i18n&locale=ru&lang=yaml */ "./node_modules/@intlify/vue-i18n-loader/lib/index.js!./node_modules/vue-loader/lib/index.js?!./resources/js/views/user/Profile.vue?vue&type=custom&index=0&blockType=i18n&locale=ru&lang=yaml");
/* harmony import */ var _node_modules_intlify_vue_i18n_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_Profile_vue_vue_type_custom_index_0_blockType_i18n_locale_ru_lang_yaml__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_intlify_vue_i18n_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_Profile_vue_vue_type_custom_index_0_blockType_i18n_locale_ru_lang_yaml__WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_intlify_vue_i18n_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_Profile_vue_vue_type_custom_index_0_blockType_i18n_locale_ru_lang_yaml__WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_intlify_vue_i18n_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_Profile_vue_vue_type_custom_index_0_blockType_i18n_locale_ru_lang_yaml__WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_intlify_vue_i18n_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_Profile_vue_vue_type_custom_index_0_blockType_i18n_locale_ru_lang_yaml__WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/views/user/Profile.vue?vue&type=custom&index=1&blockType=i18n&locale=en&lang=yaml":
/*!********************************************************************************************************!*\
  !*** ./resources/js/views/user/Profile.vue?vue&type=custom&index=1&blockType=i18n&locale=en&lang=yaml ***!
  \********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_intlify_vue_i18n_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_Profile_vue_vue_type_custom_index_1_blockType_i18n_locale_en_lang_yaml__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/@intlify/vue-i18n-loader/lib!../../../../node_modules/vue-loader/lib??vue-loader-options!./Profile.vue?vue&type=custom&index=1&blockType=i18n&locale=en&lang=yaml */ "./node_modules/@intlify/vue-i18n-loader/lib/index.js!./node_modules/vue-loader/lib/index.js?!./resources/js/views/user/Profile.vue?vue&type=custom&index=1&blockType=i18n&locale=en&lang=yaml");
/* harmony import */ var _node_modules_intlify_vue_i18n_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_Profile_vue_vue_type_custom_index_1_blockType_i18n_locale_en_lang_yaml__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_intlify_vue_i18n_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_Profile_vue_vue_type_custom_index_1_blockType_i18n_locale_en_lang_yaml__WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_intlify_vue_i18n_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_Profile_vue_vue_type_custom_index_1_blockType_i18n_locale_en_lang_yaml__WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_intlify_vue_i18n_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_Profile_vue_vue_type_custom_index_1_blockType_i18n_locale_en_lang_yaml__WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_intlify_vue_i18n_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_Profile_vue_vue_type_custom_index_1_blockType_i18n_locale_en_lang_yaml__WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/views/user/Profile.vue?vue&type=script&lang=js&":
/*!**********************************************************************!*\
  !*** ./resources/js/views/user/Profile.vue?vue&type=script&lang=js& ***!
  \**********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Profile_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Profile.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/user/Profile.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Profile_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/user/Profile.vue?vue&type=template&id=45366d78&":
/*!****************************************************************************!*\
  !*** ./resources/js/views/user/Profile.vue?vue&type=template&id=45366d78& ***!
  \****************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Profile_vue_vue_type_template_id_45366d78___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Profile.vue?vue&type=template&id=45366d78& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/user/Profile.vue?vue&type=template&id=45366d78&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Profile_vue_vue_type_template_id_45366d78___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Profile_vue_vue_type_template_id_45366d78___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);