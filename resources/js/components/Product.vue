<template>
  <div class=" h-56 justify-center pt-1 ">
    <div class="w-40 static">
        <div v-if="product.stock==0">
          <img  class="absolute top-0 w-40 h-40 ml-8 z-10 bg-black bg-opacity-75" src="/storage/cross3.png">
        </div>
        <div class="relative top-0 left-0 w-40 ml-8 ">
          <carousel class="carousel-slider static z-0" :per-page="1" :autoplay="true" :autoplayHoverPause="true" :mouse-drag="true" :width="100"
            :loop="true" :navigation-enabled="false" :paginationEnabled="false" :autoplayTimeOut="3000" :speed="500" v-if="product.images.length>1">
            <slide v-for="(image,index) in product.images" :key="index">
              <img :src="'/storage/' + image.img" class="h-40">
            </slide>
          </carousel>
          <img class="static z-0" :src="'/storage/' + product.images[0].img" v-else>
        </div>
    </div>
    <div class="flex mt-1 ">
      <p class="bg-green-500 text-white px-5 py-1 rounded-lg rounded-r-none">{{product.description}} </p>
      <p class="bg-green-800 text-white px-1 py-1 rounded-lg rounded-l-none">{{product.price}}€</p>
    </div>
   <div class="m-200 w-100 ml-6">
      <star-rating  :rating="product.valoration" :read-only="true" :show-rating="false" :increment="0.25"
                  active-color="#f3bf48" :star-size="30" :padding="5"></star-rating>
    </div>
    <div class="mt-1">
      <div v-if="product.stock!=0">
          <div class="flex justify-center">
            <div v-for="(size,index) in product.sizes" :key="index">
              <p class="mx-2"  v-if="size.stock>0" >{{size.size}}</p>
              <p class="mx-2 text-gray-500" v-else>{{size.size}}</p>
            </div>
           
          </div>
      </div>
      <div v-else>
          <p class="text-red-500 text-center mt-1">SIN STOCK</p>
      </div>
    </div>
  </div>
</template>
<script>
export default {
 data(){
   return{
     product:{},
   }
 },
 created(){
   this.fetchProduct();
 },
 methods:{
   fetchProduct(){
     this.$axios.get(`api/getProduct/15`).then(response =>{
        this.product=response.data;
        // this.product.stock=0;
     });
   }
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