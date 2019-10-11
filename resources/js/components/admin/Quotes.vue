<template>
    <div>
        <h1 class="text-center mt-3">Quotes</h1>
        <ul class="list-group mt-3">
            <li v-for="quote in quotes" :key="quote.id" class="list-group-item mb-2">{{quote.text}}</li>
        </ul>

    </div>
</template>

<script>
export default {
    name: "quotes",
    data(){
        return {
            quotes: []
        }
    },
    mounted(){
        let token = localStorage.getItem("access_token");
        fetch('/api/quotes', {
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        }).then(data => data.json()).then(payload => {
            if(payload.message){
                this.$store.commit('updateLoggedIn', { loggedIn: false});
            }else{
                this.quotes = payload.data;
            }
        });
    }
}
</script>