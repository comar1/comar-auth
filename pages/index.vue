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
        <p>Username: <b>{{ client.username }}</b></p>
        <p>Password: <b>{{ client.password }}</b></p>
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
          username: 'comar1',
          password: 'comar1pass',
        },
        client: {
          username: '',
          password: '',
        },
        salt: ''
      };
    },
    provide(){
      return {
        form: this.form,
      }
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
        //onMount generate new salt

        //for fe only

        this.client.username = this.form.username;
        this.client.password = this.form.password + this.salt;
        
        console.log('Form submitted: '+ this.client.password + ' (password: ' + formData.password + ' + salt: ' +this.salt);

        //reset salt
        // this.salt = ''
        // Handle the form data (e.g., send it to a server, update the UI, etc.)
      },
      //Helper Functions
      generateRandomChars(length){
        let chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        const randomArray = new Uint8Array(length); // generate 5 random values
        crypto.getRandomValues(randomArray);

        const saltArray = [];
        for (const value of randomArray) {
          saltArray.push(chars.charAt(value % chars.length));
        }

        const generatedSalt = saltArray.join("");
        console.log("salt: " + generatedSalt);
        return generatedSalt;
      }
    },
    mounted() {
        this.mousex = 844;
        this.mousey = 446;
        document.addEventListener('mousemove', this.updateMousePosition);

        
        this.salt = this.generateRandomChars(5);
    },
    unmounted() {
      document.removeEventListener('mousemove', this.updateMousePosition);
    },
  };
  </script>