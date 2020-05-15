<template>
    <div class="w-full">
        <Navbar></Navbar>
        <div class="flex">
            <div class="pt-20 pl-40 w-5/6 flex">

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
                <div class="text-center">
                    <h1>{{product.description}}</h1>
                    <div class="flex justify-center">
                        <star-rating  :rating="valoration.valoration===undefined ? product.valoration : valoration.valoration "  :read-only="false" :increment="0.25"
                            active-color="#f3bf48" :star-size="30" :padding="5" @rating-selected="changeValoration" :show-rating="false" ></star-rating>
                        <p v-if="noValoration" class="text-gray-700 italic mt-1">Aun no ha valorado este producto</p>
                    </div>
                    <div class="flex mt-4 justify-center">
                        <div v-for="(size,index) in product.sizes" :key="index" @mouseover="sizeStock(size.stock)" @mouseout="generalStock">
                            <p class="mx-2"  v-if="size.stock>0" >{{size.size}}</p>
                            <p class="mx-2 text-gray-500" v-else>{{size.size}}</p>
                        </div>
                    </div>
                    <div v-if="product.stock" class="flex mt-2  justify-center">
                        Stock:
                        <p v-if="stock>100">{{stock}}</p>
                        <p v-else class="text-red-500 pl-4"> {{stock}} </p>
                    </div>
                    <div v-else>
                        <p class="text-red-700 mt-1 pl-4">SIN STOCK</p>
                    </div>
                    <div class="flex mt-4">
                        <button class="bg-blue-400 text-white p-1 rounded-md w-10" @click="showInput"><img src="/img/cart.png" title="Añadir al carrito"></button>
                        <select v-if="show && product.sizes" class="bg-white ml-4 w-20 text-center" v-model="newProduct.idSize" >
                            <option class="form-control" :value="null" disabled>Talla</option>
                            <option v-for="size in product.sizes" :key="size.id" :value="size.id">{{size.size}}</option>
                        </select>
                        <input v-if="show"  class=" ml-6 border rounded border-solid border-gray-500 w-32 text-center"  type="number" min="0" v-model="newProduct.quantity" placeholder="Unidades">
                        <button v-if="show" class="bg-blue-400 rounded text-white ml-1 p-1" @click="addProductToCart" title="Añadir al carrito">Añadir</button>
                    </div>
                </div>
            </div>
            <Cart :idCustomer="idCustomer" :key="key"></Cart>
        </div>
        
    </div>
</template>
<script>
import Cart from './Cart.vue';
import Navbar from './Navbar.vue';
export default {
    name:"Product",
    components:{
        'Cart':Cart,
        'Navbar':Navbar,
    },
    data(){
        return{
            product:{},
            idProduct:this.$route.params.productId,
            idCustomer:1,
            picture:'',
            valoration:{},
            noValoration:true,
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
                    this.noValoration=false;
                }
            })
        },
        addProductToCart(){
            this.newProduct.idCustomer=this.idCustomer;
            this.newProduct.idProduct=this.idProduct;
            console.log(this.newProduct);
            this.$axios.post(`api/addProduct`,this.newProduct).then(response =>{
               this.newProduct.idSize=null,
               this.newProduct.quantity=0,
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