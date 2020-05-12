<template>
    <div class="flex">
        <div class="w-5/6">
            <div class="pt-8 pl-3"> 
                Descripcion: <input class="border border-solid border-black border-radius-75" type="text" v-model="filter.description" @keyup="fetchProducts">
                Articulo: <select class="bg-color-white" v-model="filter.idArticle" @change="fetchProducts">
                            <option :value="null">Todos</option>
                            <option v-for="(article,index) in articles" :key="index" :value="article.id">{{article.name}}</option>
                        </select>
                Marcas: <select v-model="filter.idBrand" @change="fetchProducts">
                            <option :value="null">Todas</option>
                            <option v-for="(brand,index) in brands" :key="index" :value="brand.id">{{brand.name}}</option>
                        </select>
            </div>
            <!-- <div class="w-3/4 h-full px-4 py-8 flex flex-wrap justify-start items-center"> -->
            <div class="flex flex-wrap items-center px-4 py-8 w-full">
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
</template>
<script>
import Cart from './Cart.vue';
import ProductCard from './ProductCard.vue';
export default {
    name: "Products",
    components:{
        'ProductCard':ProductCard,
        'Cart':Cart,
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