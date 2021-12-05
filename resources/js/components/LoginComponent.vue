<template>
    <v-card  class="mx-auto my-12 pa-6" max-width="90%" min-width="374">
        <v-card-title>Login</v-card-title>
        <v-alert v-if="errors" type="error">
            {{errors}}
        </v-alert>
        <v-form
        ref="form"
        v-model="valid"
        lazy-validation>

            <v-text-field
            v-model="email"
            :rules="emailRules"
            label="E-mail"
            required></v-text-field>
            <v-text-field
            v-model="password"
            :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
            :type="show1 ? 'text' : 'password'"
            name="input-10-1"
            label="Password"
            @click:append="show1 = !show1"
            required></v-text-field>

            <v-btn
            width="100%"
            color="success"
            class="ma-auto d-block"
            @click="submit">
            Login
            </v-btn>

        </v-form>
    </v-card>
</template>

<script>
    import { api } from '../api/api'
    export default {
        name: 'LoginComponent',
        data() {
            return {
                show1: false,
                valid:true,
                emailRules:[],
                email:null,
                password:null,
                errors:null
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            submit(){
                if(this.email && this.password){
                    this.errors = '';
                    this.valid = true;
                    const req = api().login({email:this.email,password:this.password});
                    req.then(this.successCallback.bind(this)).catch(this.errorCallback.bind(this));
                }else{
                    this.renderError('Fileds are required');
                }
            },
            renderError(msg){
                this.errors = msg;
                this.valid = false;
            },
            errorCallback(e){
                if(e.response.data.message){
                    this.renderError(e.response.data.message);
                }
            },
            successCallback(e){
                if(!e.data.ok){
                    if(e.data.message){
                        this.renderError(e.data.message);
                    }
                }else{
                    localStorage.tokenAuth = e.data.data.token;
                    this.$router.push('/flights');
                }
            }

        }
    }
</script>
