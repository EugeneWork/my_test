<template>
    <div class="d-flex flex-column bd-highlight mb-3 text-center">
        <button class="btn btn-dark" v-on:click="back">Back</button>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Wallet</th>
                <th scope="col">Operation</th>
                <th scope="col">Value</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(payment,index) in payment_history">
                <th scope="row">{{index+1}}</th>
                <td>{{ payment.wallet.currency.name}}</td>
                <td>{{payment.operation}}</td>
                <td>{{payment.value}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
import router from "../router";
export default {
    data() {
        return {
            payment_history:'',
            error: '',
        }
    },
    beforeMount() {
        this.paymentHistory();
    },
    methods: {
        async paymentHistory(){
                await axios.get('api/payment/history')
                    .then(response => {
                        if (response.data.status == 200) {
                            this.payment_history=response.data.data;
                        }
                    })
                    .catch(error => {
                        this.error = error.response.data.errors;
                    })

        },
        back(){
            router.push({ path: '/dashboard'})
        }
    }
}
</script>
