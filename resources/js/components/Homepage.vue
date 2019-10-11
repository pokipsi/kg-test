<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-8 col-lg-6 mt-5 ">
                <div class="row">
                    <div class="col-12">
                        <h1>{{headerText}}</h1>
                    </div>
                </div>
                <div class="wrapper">
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-primary" role="alert" v-if="subscribed">
                                Subscribed!
                            </div>
                            <div class="alert alert-primary" role="alert" v-if="email_sent_info">
                                Check your email to reactivate subscription.
                                <button class="btn btn-default" @click="email_sent_info = false">Close</button>
                            </div>
                            <div class="alert alert-primary" role="alert" v-if="reactivate_question">
                                Do you want to reactivate account?
                                <button class="btn btn-primary" @click="reactivate()">Yes</button>
                                <button class="btn btn-default" @click="reactivate_question = false">No</button>
                            </div>
                            <form class="form-group" @submit="validateForm">
                                <div v-show="!showPayment">
                                    <label>Email address</label>
                                    <input class="form-control" placeholder="someone@mail.com" v-model="email" @keyup="validateEmail">
                                    <small class="form-text text-danger text-center" v-if="error">{{ error }}</small>
                                    <input class="btn btn-primary float-right mt-2" v-bind:disabled="error != null" type="submit" value="Subscribe">
                                </div>
                                <div v-show="showPayment">
                                    <div id="paypal-button-container"></div>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</template>

<script>

import PayPalIntegration from '@/js/paypal-integration';
import EmailValidator from '@/js/email-validator';

export default {
    name: "homepage",
    data(){
        return {
            error: null,
            email: null,
            showPayment: false,
            headerText: '',
            subscribed: false,
            reactivate_question: false,
            email_sent_info: false,
            user: null
        }
    },
    computed: {
        
    },
    methods: {
        validateEmail: function(){
            if(!this.email){
                this.error = 'Email required.';
            }else if (!EmailValidator.validEmail(this.email)) {
                this.error = 'Valid email required.';
            }else{
                this.error = null;
            }
        },
        validateForm(e){
            this.validateEmail();
            this.subscribed = false;
            this.reactivate_question = false;
            if(!this.error){
                fetch('/api/user/check', {
                    headers: {
                        'content-type': 'application/json'
                    },
                    body: JSON.stringify({
                        email: this.email
                    }),
                    method: 'post'
                }).then(data => data.json()).then(data => {
                    if(data.subscribed){
                        if(data.deleted_at == null){
                            console.log("already subscribed");
                            this.subscribed = true;
                        }else{
                            this.user = data;
                            console.log("reactivate?");
                            this.reactivate_question = true;
                        }
                    }else{
                        this.showPayment = true;
                        this.headerText = 'Payment';
                        this.renderPayPal();
                    }
                });
            }
            e.preventDefault();
        },
        renderPayPal(){
            PayPalIntegration.render({
                onApprove: (data) => {
                    switch(data.status){
                        case 1:
                            this.subscribed = true;
                            break;
                        case 2:
                            this.subscribed = true;
                            break;
                    }

                },
                payload: {
                    email: this.email
                }
            });
        },
        reactivate(){
            fetch('/api/user/require-reactivation', {
                headers: {
                    'content-type': 'application/json'
                },
                body: JSON.stringify({
                    id: this.user.id,
                    password: this.user.password
                }),
                method: 'post'
            }).then(data => data.json()).then(data => {
                this.user = null;
                this.reactivate_question = false;
                this.email_sent_info = true;
                console.log(data);
            });
        }
    },
    mounted: function(){
        this.headerText = 'Welcome';
        
    }
}
</script>
