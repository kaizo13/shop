<template>
    <div>
        <div class="pt-8 pl-3"> 
            Descripcion: <input class="border border-solid border-black border-radius-75" type="text" v-model="filter.description" @keyup="filterProducts">
            Articulo: <select class="bg-color-white" v-model="filter.idArticle" @change="filterProducts">
                        <option :value="null"></option>
                        <option v-for="(article,index) in articles" :key="index" :value="article.id">{{article.name}}</option>
                    </select>
            Marcas: <select v-model="filter.idBrand" @change="filterProducts">
                        <option :value="null"></option>
                        <option v-for="(brand,index) in brands" :key="index" :value="brand.id">{{brand.name}}</option>
                    </select>
        </div>
        <div class="w-3/4 h-full px-4 py-8 flex flex-wrap justify-start items-center">
            <template v-for="(product,index) in products">
                <div class="my-8 mx-4" :key="`product_${index}`">
                    <Product  :product="product"></Product>
                </div>
            </template>
        </div>
    </div>
</template>
<script>
import Product from './Product.vue';
export default {
    name: "Products",
    components:{
        'Product':Product,
    },
    data(){
        return{
            articles:[],
            brands:[],
            products:[],
            filter:{},
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
            this.$axios.get(`api/getProducts`).then(response =>{
                this.products=response.data;
                
            })
        },
        filterProducts(){
            // console.log(this.filter);
            this.$axios.get(`api/getProducts`,{params:this.filter}).then(response =>{
                console.log(response.data);
                this.products=response.data;
            })
        }
    }
}
</script>