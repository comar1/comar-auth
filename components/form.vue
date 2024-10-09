<template>
    <div class="form">
        <h3>Registration</h3>
        Username
        <input type="text" v-model="fullName">
        Password
        <input type="password" v-model="form.password" @keydown="getHash">
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
  },
  methods: {
    async getHash() {
    // const { data, error } = await useFetch('http://comar-auth.api:8000/getHash')
    //     if (error) {
    //      console.error(error)
    //     } else {
    //      console.log(data)
    //     }
        const { data, error } = await useFetch('http://comar-auth.api:8000/getHash', {
            mode: 'no-cors', // or 'no-cors'
        })
    }
    
  }
};
</script>