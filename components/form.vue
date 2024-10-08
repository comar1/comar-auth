<template>
    <div class="form">
        <h3>Registration</h3>
        Username
        <input type="text" v-model="fullName">
        Password
        <input type="password" v-model="form.password">
        <div>
            <!-- <button @click="submitForm">Sign In</button> -->
            <button @click="$emit('submit', form)">Sign In</button>
            <p>New? <span>Register</span> now</p>
        </div>
    </div>
</template>
<script>
export default {
  inject: ['form'],
  computed:{
    fullName: {
        get() {
            return this.form.username + ' user';
        },
        set(newValue) {
            const [username, suffix] = newValue.split(' ');
            this.form.username = username;
        },
    }
  }
};
</script>