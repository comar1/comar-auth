<template>
    <div class="form">
        <h3>Registration</h3>
        Username
        <input type="text" v-model="localUsername">
        Password
        <input type="password" v-model="localPassword">
        <div>
            <!-- <button @click="submitForm">Sign In</button> -->
            <button @click="$emit('submit')">Register</button>
            <p>Have an account? <span @click="">Login</span> instead!</p>
        </div>
    </div>
</template>
<script>
export default {
  props: ['username', 'password'],
  data() {
    return {
      localUsername: this.username,
      localPassword: this.password,
    };
  },
  computed: {
    username2: {
      get() {
        return this.localUsername;
      },
      set(newValue) {
        this.localUsername = newValue;
        this.$emit('update:username2', newValue);
      },
    },
    password2: {
      get() {
        return this.localPassword;
      },
      set(newValue) {
        this.localPassword = newValue;
        this.$emit('update:password2', newValue);
      },
    },
  },
  watch: {
    localUsername(newValue) {
        this.$emit('update:username2', newValue);
    },
    localPassword(newValue) {
        this.$emit('update:password2', newValue);
    },
  }
};
</script>