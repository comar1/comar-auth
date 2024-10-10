<template>
  <div @mousemove="updateMousePosition($event)" class="app">
      
    <div style="display: flex; flex-direction: column; align-items: center;">
      <Transition name="fade">
        <Form :username="username" :password="password"  @update:password2="updatePassword"  @update:username2="updateUsername" @submit="submit"/>
      </Transition>
      <div>
        <div class="container">
          <b>Info</b>
          <p><span class="bg-green">Password</span> + <span class="bg-purple">Salt</span>: <span class="bg-green">{{ password }}</span><span class="bg-purple">{{ salt }}</span></p>
          <p>Hashed (SHA-256): {{ hashed }}</p>

          
          <div style="margin-top: 1rem;">
            <!-- Client -->
            <h4>Client</h4>
            <div class="client_output">
              <b>Registration</b>
              <p>Username: {{ client.username }}</p>
              <p>Password: {{ client.password }}</p>
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="events">
      <div>
        <!-- Server -->
        <h4 ref="server">Server</h4>
        <div class="server_output">
          <b>Registration</b>
          <p>Username: {{ server.username }}</p>
          <p>Password: {{ server.password }}</p>
        </div>
        <div class="server_output">
          <b>Generated Salt</b>
          <p>Salt: {{ salt }}</p>
        </div>
        <div class="server_output">
          <b>Salted Password</b>
          <p>Password: {{ server.password }}</p>
          <p>Salted: {{ salted }}</p>
        </div>
        <div class="server_output">
          <b>Hashed Password</b>
          <p>Salted: {{ salted }}</p>
          <p>Hashed: {{ hashed }}</p>
        </div>
        <div class="server_output">
          <b>Generated new User ID</b>
          <p>User ID: {{ uuid }}</p>
        </div>
        <div class="server_output">
          <b>Saved credentials</b>
          <p>Username: {{ server.username }}</p>
          <p>Salt: {{ salt }}</p>
          <p>Hashed: {{ hashed }}</p>
          <p>User ID: {{ uuid }}</p>
        </div>
      </div>
    </div>

    <div class="mouse-follower-wrapper">
      <div class="mouse-follower" :style="{ top: posy + 'px', left: posx + 'px'}"></div>
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

        username: '',
        password: '',
        salt: '',

        client: {
          username: '',
          password: '',
        },

        server: {
          username: '',
          password: '',
        },
        salted: '', //salted password
        hashed: '', //hashed password
        uuid: '', //generated user id
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
    mounted() {
      this.mousex = 844;
      this.mousey = 446;
      document.addEventListener('mousemove', this.updateMousePosition);

      (async () => { //async functions cannot exist in mounted, solution would be declare in method then assign this.salt = generateSalt(), this solution, however, uses self-invoking anonymous function
        try {
          const response = await fetch('http://comar-auth.api:8000/getHash', {
            method: 'GET',
            mode: 'cors',
          });

          if (!response.ok) {
            throw new Error(`Failed to fetch data! status: ${response.status}`);
          }

          const response_data = await response.json();
          //console.log(response_data?.data);
          this.salt = response_data?.data; // assuming the salt value is in the "data" property of the response data
        } catch (error) {
          console.error(error);
        }
      })();
    },
    unmounted() {
      document.removeEventListener('mousemove', this.updateMousePosition);
    },
    methods: {
      updateMousePosition(event) {
        this.mousex = event.clientX;
        this.mousey = event.clientY;
      },
      updateUsername(newValue) {
        this.username = newValue;
      },
      updatePassword(newValue) {
        this.password = newValue;
      },
      async submit() {
        
        this.$refs.server.scrollIntoView({ behavior: 'smooth', duration: 100 });

        this.client.username = this.username;
        this.client.password = this.password;

        try {
            //register
            const registerResponse  = await fetch('http://comar-auth.api:8000/register', {
                method: 'POST',
                mode: 'cors',
                headers: {
                  'Content-Type': 'application/json',
                },
                body: JSON.stringify(this.client), //formData from client
            })
            
            if (!registerResponse.ok) {
                throw new Error(`Failed to fetch data! status: ${registerResponse.status}`)
            }
            
            let response_data = await registerResponse.json();
            //console.log(response_data?.data);
            this.server.username = response_data?.data?.username;
            this.server.password = response_data?.data?.password;
            
            //salted password
            const saltedResponse  = await fetch('http://comar-auth.api:8000/getSaltedPassword', {
                method: 'POST',
                mode: 'cors',
                headers: {
                  'Content-Type': 'application/json',
                },
                body: JSON.stringify({ password: this.client.password, salt: this.salt }), //formData from client
            })
            
            if (!saltedResponse.ok) {
                throw new Error(`Failed to fetch data! status: ${saltedResponse.status}`)
            }
            
            response_data = await saltedResponse.json(); //reuse variable
            //console.log(response_data?.data);
            this.salted = response_data?.data;
            
            //hashed password
            const hashedResponse  = await fetch('http://comar-auth.api:8000/getHashedPassword', {
                method: 'POST',
                mode: 'cors',
                headers: {
                  'Content-Type': 'application/json',
                },
                body: JSON.stringify({ password: this.client.password, salt: this.salt }), //formData from client
            })
            
            if (!hashedResponse.ok) {
                throw new Error(`Failed to fetch data! status: ${hashedResponse.status}`)
            }
            
            response_data = await hashedResponse.json(); //reuse variable
            //console.log(response_data?.data);
            this.hashed = response_data?.data;

            //uuid
            const uuidResponse  = await fetch('http://comar-auth.api:8000/generateUserID', {
                method: 'GET',
                mode: 'cors',
            })
            
            if (!uuidResponse.ok) {
                throw new Error(`Failed to fetch data! status: ${uuidResponse.status}`)
            }
            
            response_data = await uuidResponse.json(); //reuse variable
            //console.log(response_data?.data);
            this.uuid = response_data?.data;

            //register account w credentials
            const accountResponse  = await fetch('http://comar-auth.api:8000/account', {
                method: 'POST',
                mode: 'cors',
                headers: {
                  'Content-Type': 'application/json',
                },
                body: JSON.stringify({ 
                  username: this.client.username, 
                  salt: this.salt, 
                  hashed: this.hashed, 
                  uuid: this.uuid 
                }), //formData from client
            })
            
            if (!accountResponse.ok) {
                throw new Error(`Failed to fetch data! status: ${accountResponse.status}`)
            }
            
            response_data = await accountResponse.json(); //reuse variable

        } catch (error) {
            console.error(error)
        }
      },
    },
  };
  </script>