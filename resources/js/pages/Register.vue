<template>
    <div class="d-flex flex-column bd-highlight mb-3 text-center">
        <div  class="p-2 bd-highlight" v-if="error" style="color:red;">{{this.error}}</div>
        <div class="p-2 bd-highlight">
            <label for="name">Name</label>
            <input type="text" v-model="name" id="name">
        </div>
        <div class="p-2 bd-highlight">
            <label for="email">Email</label>
            <input type="email" v-model="email" id="email">
        </div>
        <div class="p-2 bd-highlight">
            <label for="password">Password</label>
            <input type="text" v-model="password" id="password">
        </div>
        <div class="p-2 bd-highlight">
            <label for="phone">Phone</label>
            <input type="text" v-model="phone" id="phone">
        </div>
        <div class="p-2 bd-highlight">
            <label for="address">Address</label>
            <input type="text" v-model="address" id="address">
        </div>
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
            name: '',
            phone: '',
            address: '',
            error: '',
        }
    },
    methods: {
        async register(){
            if (this.email && this.password && this.name && this.phone && this.address){
                await axios.post('api/register', {
                    email: this.email,
                    password:this.password,
                    name:this.name,
                    phone:this.phone,
                    address:this.address,
                })
                    .then(response => {
                        if (response.data.status == 200) {
                            router.push({ path: '/'})
                            // location.reload();
                            // this.$store.dispatch('save_code', response.data.data.phone_code);
                            // this.$store.dispatch('save_user', response.data.data);
                            // router.push({name:'TwoFactor'});
                        }
                    })
                    .catch(error => {
                        this.error = error.response.data.errors;
                    })
            }else{
                this.error='Pls fill all fields';
            }
        }
    },
    beforeMount() {

    }
}
</script>
