<template>
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-8 col-lg-4 mt-5 ">
            <div class="row">
                <div class="col-12">
                    <h1>Login</h1>
                </div>
            </div>
            <div class="wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <form class="form-group" @submit="validateForm">
                                <label>Email</label>
                                <input class="form-control" placeholder="someone@mail.com" v-model="email">
                                <hr class="mb-3">
                                <label>Password</label>
                                <input class="form-control" placeholder="password" type="password" v-model="password">
                                <input class="btn btn-primary float-right mt-2" type="submit" value="Login">
                                <small class="form-text text-danger" v-if="error">Enter valid email and password</small>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import EmailValidator from '@/js/email-validator';

export default {
    name: "adminAuth",
    data(){
        return {
            error: null,
            email: null,
            password: null
        }
    },
    methods: {
        validateEmail(){
            console.log(EmailValidator.validEmail(this.email));
            if(!this.email){
                return false;
            }else if (!EmailValidator.validEmail(this.email)) {
                return false;
            }else{
                return true;
            }
        },
        validatePassword(){
            if(!this.password){
                return false;
            }else{
                return true;
            }
        },
        validateForm(e){
            let emailValidation = this.validateEmail();
            let passwordValidation = this.validatePassword();
            if(emailValidation && passwordValidation){
                this.login(this.email, this.password, (data) => {
                    if(data.error){
                        this.error = true;
                    }else{
                        this.$emit('login-submitted', {access_token: data.access_token});
                    }
                });
            }else{
                this.error = true;
            }
            e.preventDefault();
        },
        login(email, password, onResponse){
            fetch('/api/auth/login', {
                headers: {
                    'content-type': 'application/json'
                },
                method: 'post',
                body: JSON.stringify({
                    email: email, 
                    password: password
                })
            }).then(data => data.json()).then(data => {
                if(onResponse){
                    onResponse(data);
                }
            });
            
        }
    }
}
</script>