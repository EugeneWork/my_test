<template>
    <div class="d-flex flex-column bd-highlight mb-3 text-center">
        <div  class="p-2 bd-highlight" v-if="error" style="color:red;">{{this.error}}</div>
        <div class="p-2 bd-highlight">
            <label for="email">Email</label>
            <input type="email" v-model="email" id="email">
        </div>
        <div class="p-2 bd-highlight">
            <label for="password">Password</label>
            <input type="password" v-model="password" id="password"></div>
        <div class="p-2 bd-highlight"> <button class="btn btn-success" v-on:click="login">Login</button></div>
        <div class="p-2 bd-highlight"> <button class="btn btn-dark" v-on:click="register">Register</button></div>
    </div>
</template>
<script>
import router from "../router";
export default {
    data() {
        return {
            email: '',
            password: '',
            error: '',
        }
    },
    methods: {
        async login(){
            if (this.email && this.password){
                await axios.post('api/login', {
                    email: this.email,
                    password:this.password
                })
                    .then(response => {
                        if (response.data.status == 200) {
                            localStorage.setItem('api_token', response.data.data.user);
                            router.push({ path: '/dashboard'});
                        }
                    })
                    .catch(error => {
                         this.error = error.response.data.errors;
                         })
            }else{
                this.error='Pls fill all fields';
            }
        },
        register(){
            router.push({ path: '/register'})
        }
    },
    beforeMount() {

    }
}
</script>
