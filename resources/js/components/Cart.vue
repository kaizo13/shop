<template>
    <div v-if="products.length>0" class="relative top-0 right-0 w-1/6   overflow-y-visible overflow-auto h-screen">
        <div  class="border border-solid border-gray-100 rounded bg-white shadow-inner">
            <div class="flex text-center border-b border-solid border-gray-300">
                <p class="text-lg ">Carrito</p>
                <a @click="emptyCart(cart.id)" ><img class="w-6 ml-56" src="/img/bin.png"></a>
            </div>
            <div class="ml-3" >
                <div class="flex mt-2 border-b border-solid border-gray-300"  v-for="(product,index) in products" :key="index">
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
        <div class="text-center">
            <p class=" ">Total: {{cart.price}} €</p>
            <button class="bg-green-500 text-white rounded p-1 mt-1">Comprar</button>
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
        },
        emptyCart(e){
            this.$axios.delete(`api/emptyCart/${e}`).then(response =>{
                this.fetchCart();
            })

        }
    }
}
</script>