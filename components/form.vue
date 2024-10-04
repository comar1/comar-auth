<template>
    <div class="form">
        <h3>Registration</h3>
        Username
        <input type="text" v-model="username">
        Password
        <input type="password" v-model="password">
        <div>
            <button @click="submitForm">Sign In</button>
            <p>New? <span>Register</span> now</p>
        </div>
    </div>
</template>
<script>
export default {
  data() {
    return {
      username: 'comar1',
      password: 'testpassword',
    };
  },
  emits: ['submit'],
  methods: {
    submitForm() {
      this.$emit('submit', { username: this.username, password: this.password });
    },
  },
};
</script>