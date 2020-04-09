<template>
    <div>
        <h1 class="page-header">Личный кабинет</h1>
        <div class="m-4">
            Как дела, {{ $auth.user().name }}?
        </div>
        <form autocomplete="off" @submit.prevent="save" method="post">
            <div class="form-group" :class="{ 'has-error': errors.name }">
                <label for="name">Имя</label>
                <input type="text" id="name" class="form-control" placeholder="Ваше имя" v-model="name" required :disabled="!edit.name">
                <div class="error-description" v-if="errors.name" v-for="error in errors.name">
                    {{ error }}
                </div>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.email }">
                <label for="email">E-mail</label>
                <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email" required :disabled="!edit.email">
                <div class="error-description" v-if="errors.email" v-for="error in errors.email">
                    {{ error }}
                </div>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.password }">
                <label for="password">Пароль</label>
                <input type="password" id="password" class="form-control" v-model="password" required :disabled="!edit.password">
                <div class="error-description" v-if="errors.password" v-for="error in errors.password">
                    {{ error }}
                </div>
            </div>
            <div class="form-group" v-if="edit.password">
                <label for="password_confirmation">Подтверждение пароля</label>
                <input type="password" id="password_confirmation" class="form-control" v-model="password_confirmation" required>
            </div>
            <div class="text-center" v-if="edit.name || edit.email || edit.password">
                <button type="submit" class="button" :disabled="wait">Зарегистрироваться</button>
            </div>
        </form>
    </div>
</template>
<script>
  export default {
    data() {
      return {
        edit: { name: false, email: false, password: false },
        errors: {}, 
        name: this.$auth.user().name,
        email: this.$auth.user().email,
        password: '12345678',
        password_confirmation: '',
      }
    },
    mounted() {
      if(!this.$auth.user().email_verified_at)
        this.$router.push({name: 'verify'})
    },
    components: {
      //
    },
    methods: {
      save() {

      }
    }
  }
</script>