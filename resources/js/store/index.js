import Vue from 'vue';
import Vuex from 'vuex';

import { auth } from './auth.module';
import { locale } from './locale.module';
import { message } from './message.module';
import { errors } from './errors.module';

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    auth,
    locale,
    message,
    errors,
  }
});