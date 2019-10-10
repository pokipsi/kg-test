<template>
    <div>
        <div v-if="loggedIn">
            <router-link to="/admin-panel/users">Users</router-link>
            <router-link to="/admin-panel/quotes">Quotes</router-link>
            <button @click="logout">Logout</button>
            <keep-alive>
                <router-view></router-view>
            </keep-alive>
        </div>
        <Login v-else @login-submitted="login"></Login>
    </div>
</template>

<script>

import Login from '@/js/components/admin/Login';
import Users from '@/js/components/admin/Users';
import Quotes from '@/js/components/admin/Quotes';

export default {
    name: "admin",
    data(){
        return{
            loggedIn: false
        }
    },
    components: {
        Login, Users, Quotes
    },
    methods: {
        login: function(value){
            localStorage.setItem('access_token', value.access_token);
            this.loggedIn = true;
        },
        logout: function(){
            localStorage.removeItem('access_token');
            this.loggedIn = false;
        }
    },
    mounted(){
        let token = localStorage.getItem('access_token');
        if(token){
            this.loggedIn = true;
        }else{
            this.loggedIn = false;
        }
    }
}
</script>