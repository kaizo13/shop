<template>
    <div class="flex">
         <a href="/"><button class="bg-green-500 rounded text-white p-1">Volver</button></a>
        <div class="mt-20 ml-20 flex w-full">

           <!-- Imagenes -->
            <div class="flex">
                <div class="w-20">
                        <img class="w-20 mt-1" v-for="(image,index) in product.images" :key="index" :src="'/storage/' + image.img" @mouseover="changePicture(image.img)">
                </div>
                <div class="w-64">
                    <img :src="'/storage/' + picture">
                </div>
            </div>

            <!-- Contenido -->
            <div class="w-3/4 justify-center">
                <h1>{{product.description}}</h1>
                <div class="flex">
                    <star-rating  :rating="valoration.valoration===undefined ? product.valoration : valoration.valoration "  :read-only="false" :increment="0.25"
                        active-color="#f3bf48" :star-size="30" :padding="5" @rating-selected="changeValoration" :show-rating="false" ></star-rating>
                    <p v-if="show" class="text-gray-700 italic mt-1">Aun no ha valorado este producto</p>
                </div>
                <div class="flex mt-4">
                    <div v-for="(size,index) in product.sizes" :key="index" @mouseover="sizeStock(size.stock)" @mouseout="generalStock">
                        <p class="mx-2"  v-if="size.stock>0" >{{size.size}}</p>
                        <p class="mx-2 text-gray-500" v-else>{{size.size}}</p>
                    </div>
                </div>
                <div v-if="product.stock" class="flex mt-2 pl-4">
                    Stock:
                    <p v-if="stock>100">{{stock}}</p>
                    <p v-else class="text-red-500"> {{stock}} </p>
                </div>
                <div v-else>
                    <p class="text-red-700 mt-1">SIN STOCK</p>
                </div>
                <div class="flex mt-4">
                    <button class="bg-blue-400 text-white p-1 rounded-md w-10" @click="showInput"><img src="/img/cart.png" title="Añadir al carrito"></button>
                    <select class="bg-white ml-4 w-20 text-center" v-if="product.sizes" v-model="newProduct.idSize" >
                        <option class="form-control" :value="null" disabled>Talla</option>
                        <option v-for="size in product.sizes" :key="size.id" :value="size.id">{{size.size}}</option>
                    </select>
                    <input  class=" ml-6 border rounded border-solid border-gray-500 w-32 text-center"  type="number" min="0" v-model="newProduct.quantity" placeholder="Unidades">
                    <button class="bg-blue-400 rounded text-white ml-1 p-1" @click="addProductToCart" title="Añadir al carrito">Añadir</button>
                </div>
            </div>
        </div>
         <Cart class="w-3/4" :idCustomer="idCustomer" :key="key"></Cart>
    </div>
</template>
<script>
import Cart from './Cart.vue';
 
export default {
    name:"Product",
    components:{
        'Cart':Cart,
    },
    data(){
        return{
            product:{},
            idProduct:this.$route.params.productId,
            idCustomer:1,
            picture:'',
            valoration:{},
            show:true,
            stock:0,
            key:0,
            newProduct:{},
            show:false,
        }
    },
    created(){
        this.fetchProduct();
        this.fetchValoration();
    },
    methods:{
        fetchProduct(){
            this.$axios.get(`api/getProduct/${this.idProduct}`).then(response =>{
                this.product=response.data;
                this.picture=this.product.images[0].img;
                this.stock=this.product.stock;
            });
        },
        fetchValoration(){
            this.$axios.get(`api/getValoration/${this.idCustomer}/${this.idProduct}`).then(response =>{
                if(response.data.valoration!==undefined){
                    this.valoration=response.data;
                    this.show=false;
                }
            })
        },
        addProductToCart(){
            this.newProduct.idCustomer=this.idCustomer;
            this.newProduct.idProduct=this.idProduct;
            console.log(this.newProduct);
            this.$axios.post(`api/addProduct`,this.newProduct).then(response =>{
                console.log(response.data);
                this.show=false;
               this.key +=1;
            })
        },
        changePicture(e){
            this.picture=e;
        },
        changeValoration:function(rating){
            this.valoration.valoration=rating;
           
           if(this.valoration.id!=null){
                 this.$axios.post(`api/updateValoration/${this.valoration.id}`,this.valoration).then(response =>{
                    console.log('Valoración cambiada');

                 })
            }else{
                this.$axios.post(`api/storeValoration/${this.idCustomer}/${this.idProduct}`,this.valoration).then(response =>{
                    this.show=false;   
                })
            }
        },
        showInput(){
            this.show=true;
        },
        sizeStock(e){
            this.stock=e;
        },
        generalStock(){
            this.stock=this.product.stock;
        },
        
    }
}
</script>
<style>

.VueCarousel-inner {
  transition: none !important;
}

.VueCarousel-slide {
  transition: all 0.5s;
  opacity: 0 !important;
}



.VueCarousel-slide-active {
  opacity: 1 !important;
}


</style>