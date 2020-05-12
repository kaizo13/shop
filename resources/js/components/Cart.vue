<template>
    <div v-if="products.length>0" class="border border-solid border-gray-100 rounded bg-white shadow-inner w-1/6 fixed top-0 right-0 overflow-auto h-full">
        <div class="flex">
            <p class="text-lg">Carrito</p>
            <p class="ml-3">Total: {{cart.price}} €</p>
        </div>
        <div class="ml-3" >
            <div class="flex mt-2 border-b border-solid border-gray-100"  v-for="(product,index) in products" :key="index">
                <div>
                    <img class="w-20" :src="'/storage/' + product.img">
                </div>
                <div class="text-sm">
                    <p class="text-center mb-2" >{{product.description}}</p>
                    <div class="flex">
                        <p class="text-xs">{{product.price}}€</p>
                        <p v-if="product.size" class="ml-10 text-xs">{{product.size}}</p>
                        <p class="ml-10 text-xs">Cantidad: {{product.quantity}}</p>
                    </div>
                </div>
                <div class="w-6 ml-6 mt-3">
                    <a @click="deleteProductCart(product)"><img src="/storage/cross.png"></a>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name:"Cart",
    props:{
        idCustomer:Number,
    },
    data(){
        return{
            cart:{},
            products:[],
            total:0,
        }
    },
    created(){
        this.fetchCart();
    },
    methods:{
        fetchCart(){
            this.$axios.get(`api/getCart/${this.idCustomer}`).then(response =>{
                this.cart=response.data;
                this.products=response.data.products;
            })
        },
        deleteProductCart(product){
            this.$axios.delete(`api/deleteProductCart/${this.cart.id}`,{params:product}).then(response =>{
                this.fetchCart();
            })
        }
    }
}
</script>