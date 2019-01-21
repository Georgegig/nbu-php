'use strict';

let RegisterView = {
    template: `
    <v-container>
        <v-layout row wrap>
            <v-flex xs-12>   
                <v-form v-model="valid" ref="form">
                    <v-text-field label="Name" v-model="name" :rules="nameRules" :counter="20" required></v-text-field>
                    <v-text-field label="E-mail" v-model="email" :rules="emailRules" required></v-text-field>
                    <v-text-field label="Password" type="password" v-model="password" :rules="passwordRules" :counter="8" required></v-text-field>
                    <v-text-field label="Repeat Password" type="password" v-model="repeatedPassword" :rules="repeatedPasswordRules" required></v-text-field>
                </v-form>
                <v-btn @click="register()" :disabled="!valid" color="primary" white--text><b>REGISTER</b></v-btn>
                <v-btn @click="clear()">clear</v-btn>
            </v-flex>
        </v-layout>
    </v-container>`,
    data () {
        return {
            valid: true,
            name: '',
            nameRules: [
                (v) => !!v || 'Name is required',
                (v) => v.length <= 20 || 'Name must be less than 10 characters'
            ],
            email: '',
            emailRules: [
                (v) => !!v || 'E-mail is required',
                (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid'
            ],
            password: '',
            passwordRules: [
                (v) => !!v || 'Password is requred',
                (v) => v.length >= 8 || "Password must be atleast 8 characters long",
                (v) => /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/.test(v) || `
                Password must must contain at least 1 lowercase alphabetical character, 
                1 uppercase alphabetical character, 
                1 numeric character 
                and 1 special character`
            ],
            repeatedPassword: '',
            repeatedPasswordRules: [
                (v) => !!v || 'Please repeat your password',
                (v) => this.password == v || 'Passwords do not match'
            ]
        }
    },
    mounted(){
        if(UsersTable.userLoggedIn()){
            this.$router.push('/portfolio');
        }
    },
    methods:{
        register() {
            if (this.$refs.form.validate()) {
              this.$http.post('/altcoinsbackend/register', {
                    name: this.name,
                    email: this.email,
                    password:  this.password // CryptoJS.SHA256(this.password).toString()
                }).then(function success(data) {
                    debugger;
                    if (data.body.success) {
                        this.$router.push('/login');
                    } else {
                        throw new Error('Unsuccessful registration');
                    }
                },
                function error(data) {
                    console.log(data);
                });
            }
          },
          clear() {
            this.$refs.form.reset()
          }
    }
};
