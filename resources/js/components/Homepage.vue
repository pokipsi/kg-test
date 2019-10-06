<template>
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-8 col-lg-6 mt-5 ">
            <div class="row">
                <div class="col-12">
                    <h1>Welcome</h1>
                </div>
            </div>
            <div class="wrapper">
                <div class="row">
                    <div class="col-12">
                        <form class="form-group" @submit="validateForm">
                            <label>Email address</label>
                            <input class="form-control" placeholder="someone@mail.com" v-model="email">
                            <small class="form-text text-danger text-center" v-if="error">{{ error }}</small>
                            <input class="btn btn-primary float-right mt-2" type="submit" value="Subscribe">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "homepage",
    data(){
        return {
            error: null,
            email: null
        }
    },
    methods: {
        validateForm(e){
            alert("Implement validation");
            e.preventDefault();
        }
    }
}
</script>