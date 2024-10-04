<template>
    <div @mousemove="updateMousePosition($event)" :style="{ cursor: 'default', height: '100vh', width: '100vw'}" class="app">
      <div class="mouse-follower" :style="{ top: posy + 'px', left: posx + 'px'}"></div>
        
      <Transition name="fade">
        <Form @submit="submit"/>
      </Transition>

      <div class="container">
        <b>Info</b>
        <p><span class="bg-green">Password</span> + <span class="bg-purple">Salt</span>: <span class="bg-green">{{ form.password }}</span><span class="bg-purple">{{ salt }}</span></p>
        <p>Hashed (SHA-256): </p>
      </div>
      <div class="output">
        <b>Client</b>
        <p>Username:</p>
        <p>Password:</p>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        title: 'test3',
        mousex: 0,
        mousey: 0,
        headers: ['Details', 'Navigation Structure', 'Assign Pages'],

        form: {
          username: '',
          password: '',
        },

        salt: ''
      };
    },
    computed: {
        posx() {
            return this.mousex - 550;
        },
        posy() {
            return this.mousey - 530;
        },
    },
    methods: {
      updateMousePosition(event) {
        this.mousex = event.clientX;
        this.mousey = event.clientY;
      },
      submit(formData) {
        this.salt = '12345'
        this.form.password = formData.password;
        console.log('Form submitted:', formData);
        // Handle the form data (e.g., send it to a server, update the UI, etc.)
      },
    },
    mounted() {
        this.mousex = 844;
        this.mousey = 446;
        document.addEventListener('mousemove', this.updateMousePosition);
    },
    unmounted() {
      document.removeEventListener('mousemove', this.updateMousePosition);
    },
  };
  </script>