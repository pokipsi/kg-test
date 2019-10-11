<template>
    <div>
        <div v-if="loggedIn">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <a class="navbar-brand" href="/admin-panel">KG Admin Panel</a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <router-link class="nav-link" to="/admin-panel/users" @invalid-token="logout">Users</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" to="/admin-panel/quotes" @invalid-token="logout">Quotes</router-link>
                        </li>
                    </ul>
                    <form class="form-inline">
                        <button class="btn btn-primary" @click="logout">Logout</button>
                    </form>
                    
                </div>
            </nav>

            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <keep-alive>
                            <router-view></router-view>
                        </keep-alive>
                    </div>
                </div>
            </div>
            
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
            
        }
    },
    computed: {
        loggedIn: function(){
            return this.$store.getters.loggedIn;
        }
    },
    components: {
        Login, Users, Quotes
    },
    methods: {
        login: function(value){
            localStorage.setItem('access_token', value.access_token);
            this.$store.commit('updateLoggedIn', { loggedIn: true});
        },
        logout: function(){
            localStorage.removeItem('access_token');
            this.$store.commit('updateLoggedIn', { loggedIn: false});
        }
    },
    mounted(){
        let token = localStorage.getItem('access_token');
        this.$store.commit('updateLoggedIn', { loggedIn: !!token});
    }
}
</script>