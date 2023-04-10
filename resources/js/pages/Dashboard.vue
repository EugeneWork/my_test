<template>
    <div>
        <button class="btn btn-dark" v-on:click="paymentHistory">Payments History</button>
        <button class="btn btn-warning" v-on:click="logout">Logout</button>
        <div v-if="error" style="color:red;">{{this.error}}</div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Currency</th>
                <th scope="col">Value</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(wallet,index) in wallets">
                <th scope="row">{{index+1}}</th>
                <td>{{ wallet.value}}</td>
                <td>{{wallet.currency.name}}</td>
            </tr>
            </tbody>
        </table>

        <div class="border border-success">
            <h2>Top up</h2>
            <div class="p-2 bd-highlight">
                <label for="add">Value</label>
                <input type="text" v-model="value" id="add">
                <select v-model="currency">
                    <option v-for="currency in currencies" :value=currency.id>{{currency.name}}</option>
                </select>
                <button class="btn btn-success" v-on:click="topUp">Top up</button>
                <button class="btn btn-danger" v-on:click="withdraw">Withdraw</button>
            </div>
        </div>

        <div class="border border-secondary" v-if="this.wallets.length<3">
            <h2>Create wallet</h2>
            <div class="p-2 bd-highlight">
                <select v-model="wallet">
                    <option v-for="currency in currencies" :value=currency.id>{{currency.name}}</option>
                </select>
                <button class="btn btn-success" v-on:click="createWallet">Create wallet</button>
            </div>
        </div>
    </div>
</template>
<script>
import router from "../router";
import axios from "../axios";

export default {
    data() {
        return {
            error: '',
            wallets: '',
            value:'',
            currencies:'',
            currency:'',
            wallet:'',
        }
    },
    beforeMount() {
        let token=localStorage.getItem('api_token');
        axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
        this.getWallets();
        this.getCurrencies();
    },
    methods: {
        async getWallets() {
            await axios.get('api/wallets')
                .then(response => {
                    if (response.data.status == 200) {
                        this.wallets = response.data.data;
                    }
                })
                .catch(error => {
                    this.error = error.response.data.errors;
                })
        },
        async getCurrencies() {
            await axios.get('api/currencies')
                .then(response => {
                    if (response.data.status == 200) {
                        this.currencies=response.data.data;
                    }
                })
                .catch(error => {
                    this.error = error.response.data.errors;
                })
        },
        async topUp() {
            await axios.post('api/payment/top-up',{
                value:this.value,
                currency_id:this.currency,
                operation:'top_up'
            })
                .then(response => {
                    if (response.data.status == 200) {
                        this.getWallets();
                    }
                })
                .catch(error => {
                    this.error = error.response.data.errors;
                })
        },
        async withdraw(){
            await axios.post('api/payment/withdraw',{
                value:this.value,
                currency_id:this.currency,
                operation:'withdraw'
            })
                .then(response => {
                    if (response.data.status == 200) {
                        this.getWallets();
                    }
                })
                .catch(error => {
                    this.error = error.response.data.errors;
                })
        },
        async createWallet(){
            await axios.post('api/wallets',{currency_id:this.wallet})
                .then(response => {
                    if (response.data.status == 200) {
                        this.getWallets();
                    }
                })
                .catch(error => {
                    this.error = error.response.data.errors;
                })
        },
        paymentHistory(){
            router.push({ path: '/payment-history'})
        },
        async logout(){
            await axios.post('api/logout')
                .then(response => {
                    if (response.data.status == 200) {
                        router.push({ path: '/'})
                    }
                })
                .catch(error => {
                    this.error = error.response.data.errors;
                })
        }
    }
}
</script>
