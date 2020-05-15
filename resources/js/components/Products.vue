<template>
    <div class="w-full">
         <Navbar></Navbar>
        <div class="flex static z-30">
            <div class="w-5/6 overflow-y-visible overflow-auto h-screen">
                <div class=" pt-8 justify-center flex mb-4"> 
                    <div>
                        <p class="text-center mb-1">Descripcion</p> 
                        <input class="description border border-solid border-black border-radius-75" type="text" v-model="filter.description" @keyup="fetchProducts">
                    </div>
                    <div class="ml-4">
                        <p class="text-center mb-1">Articulo</p>
                        <select class="bg-color-white" v-model="filter.idArticle" @change="fetchProducts">
                            <option :value="null">Todos</option>
                            <option v-for="(article,index) in articles" :key="index" :value="article.id">{{article.name}}</option>
                        </select>
                    </div>
                    <div class="ml-4">
                        <p class="text-center mb-1">Marca</p>
                        <select v-model="filter.idBrand" @change="fetchProducts">
                            <option :value="null">Todas</option>
                            <option v-for="(brand,index) in brands" :key="index" :value="brand.id">{{brand.name}}</option>
                        </select>
                    </div>
                    <div class="ml-4">
                        <p class="text-center mb-1">Precio</p>
                        <div class="flex">                                
                            <input class="w-20" type="number" v-model="filter.minPrice" placeholder="Desde" @change="fetchProducts">
                            <input class="w-20 ml-4" type="number" v-model="filter.maxPrice" placeholder="Hasta" @change="fetchProducts">
                        </div>

                    </div>
                   
                </div>
                <!-- <div class="w-3/4 h-full px-4 py-8 flex flex-wrap justify-start items-center"> -->
                <div class="flex flex-wrap items-center px-4 py-8 w-full ">
                    <template v-for="(product,index) in products">
                        <div class="my-8 mx-4" :key="`product_${index}`">
                            <a :href="'/product/'+product.id">
                                <ProductCard  :product="product"></ProductCard>
                            </a>
                        </div>
                    </template>
                </div>
            </div>
            <Cart :idCustomer="idCustomer"></Cart>
        </div>
    </div>
</template>
<script>
import Cart from './Cart.vue';
import ProductCard from './ProductCard.vue';
import Navbar from './Navbar.vue';
export default {
    name: "Products",
    components:{
        'ProductCard':ProductCard,
        'Cart':Cart,
        'Navbar':Navbar,
    },
    data(){
        return{
            articles:[],
            brands:[],
            products:[],
            filter:{},
            idCustomer:1,
        }
    },
    created(){
        this.fetchArticles();
        this.fetchBrands();
        this.fetchProducts();    
    },
    methods:{
        
        fetchArticles(){
            this.$axios.get(`api/getArticles`).then(response =>{
                this.articles=response.data;
            })
        },
        fetchBrands(){
            this.$axios.get(`api/getBrands`).then(response =>{
                this.brands=response.data;
            })
        },
        fetchProducts(){
            this.$axios.get(`api/getProducts`,{params:this.filter}).then(response =>{
                this.products=response.data;
            })
        },
    }
}
</script>
<style>
.description:focus{
    border:1px solid green;
}
</style>