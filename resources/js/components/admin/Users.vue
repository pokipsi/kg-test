<template>
    <div>
        <h1 class="text-center mt-3">Users</h1>
        <p class="text-right">Page: {{pagination.page}}, User count: {{pagination.total}}</p>
        <div class="row">
            <div class="col-12">
                <nav>
                    <ul class="float-right pagination">
                        <li class="page-item" v-if="pagination.links.prev"><a class="page-link" href="#" @click="paginate(pagination.links.prev)">Previous</a></li>
                        <li class="page-item" v-if="pagination.links.next"><a class="page-link" href="#" @click="paginate(pagination.links.next)">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <ul class="list-group">
                    <li v-for="user in users" :key="user.id" class="list-group-item mb-2">
                        {{user.email}}
                        <strong class="float-right">{{getStatus(user)}}</strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "users",
    data(){
        return {
            users: [],
            pagination: {
                page: '1/1',
                total: 0,
                links: {
                    prev: null,
                    next: null
                }
            }
        }
    },
    methods: {
        getStatus(user){
            if(user.deleted){
                if(user.required_reactivation){
                    return 'Required reactivation';
                }
                return 'Deleted';
            }else{
                if(user.required_reactivation){
                    return 'Required reactivation';
                }else{
                    if(user.subscribed){
                        return 'Subscribed';
                    }else{
                        return 'Inactive'
                    }
                }
            }
        },
        getResults(endpoint = '/api/users'){
            let token = localStorage.getItem("access_token");
            fetch(endpoint, {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            }).then(data => data.json()).then(payload => {
                if(payload.message){
                    this.$store.commit('updateLoggedIn', { loggedIn: false});
                }else{
                    this.users = payload.data;
                    this.pagination.page = `${payload.meta.current_page}/${payload.meta.last_page}`;
                    this.pagination.total = payload.meta.total;
                    this.pagination.links = payload.links;
                }
            });
        },
        paginate(endpoint){
            this.getResults(endpoint);
        }
    },
    mounted(){
        this.getResults();
    }
}
</script>