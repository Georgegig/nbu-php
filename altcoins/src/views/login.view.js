'use strict';

let LoginView = {
    template: `
    <v-container>
        <v-layout row wrap>
            <v-flex xs-12>   
                <v-form v-model="valid" ref="form" v-show="!successfulLogin">
                    <v-text-field label="E-mail" v-model="email" :rules="emailRules" required></v-text-field>
                    <v-text-field label="Password" type="password" v-model="password" :rules="passwordRules" required></v-text-field>
                    <v-btn @click="login()" :disabled="!valid" color="primary" white--text><b>LOG IN</b></v-btn>
                    <v-btn @click="clear()">clear</v-btn>
                </v-form>
                <v-alert color="success" icon="check_circle" value="true" v-show="successfulLogin">
                    Successfully logged in. Redirecting to portfolio page.
                </v-alert>
                <v-alert color="error" icon="warning" value="true" v-show="unsuccessfulLogin">
                    Specified email or password is wrong.
                </v-alert>
            </v-flex>
        </v-layout>
    </v-container>`,
    data () {
        return {
            valid: false,
            successfulLogin: false,
            unsuccessfulLogin: false,
            password: '',
            passwordRules: [
                (v) => !!v || 'Password is required'
            ],
            email: '',
            emailRules: [
                (v) => !!v || 'E-mail is required',
                (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid'
            ]
        }
    },
    mounted(){
        if(UsersTable.userLoggedIn()){
            this.$router.push('/portfolio');
        }
    },
    methods:{
        login() {
            if (this.$refs.form.validate()) {
                this.successfulLogin = false;
                this.unsuccessfulLogin = false;
              // Native form submission is not yet supported
                if(UsersTable.validateEmailAndPassword(this.email, this.password)){
                    let loginDate = new Date();
                    let user = {
                        name: UsersTable.getUsername(this.email, this.password),
                        email: this.email,
                        timeStamp:  loginDate.getFullYear() + '-' + (loginDate.getMonth() + 1) + '-' + loginDate.getDate()
                    };
                    UsersTable.loginUser(user);
                    this.successfulLogin = true;
                    setTimeout(() => {
                        this.$router.push('/portfolio');
                    }, 1500)
                    this.$eventHub.$emit('loginChange');
                }
                else{
                    this.unsuccessfulLogin = true;
                }
            }
          },
          clear() {
            this.$refs.form.reset()
            this.successfulLogin = false;
            this.unsuccessfulLogin = false;
          }
    }
};