<template>
  <div class=" h-56 justify-center pt-1 ">
    <router-link :to="'/product/' + product.id">
    <div class="w-40 relative" @mouseover="startLoop" @mouseleave="endLoop" style="top:0px">
        <div class="w-40 ml-8 "  >
          <carousel class="carousel-slider static z-0" :per-page="1" :autoplay="true" :autoplayHoverPause="false"  :mouse-drag="true" :width="100" :value="picture"
            :loop="loop" :navigation-enabled="false" :paginationEnabled="false" :autoplayTimeOut="3000" :speed="500" :centerMode="true" v-if="product.images.length>1" >
            <slide v-for="(image,index) in product.images" :key="index" :data-index="index">
              <img :src="'/storage/' + image.img" class="h-40">
            </slide>
          </carousel>
          <img class="static z-0" :src="'/storage/' + product.images[0].img" v-else>
        </div>
    </div>
    <div class="flex mt-1 ">
      <p class="w-48 text-sm text-center bg-green-500 text-white px-5 py-1 rounded-lg rounded-r-none">{{product.description}} </p>
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
          <p class="text-red-700 text-center mt-1">SIN STOCK</p>
      </div>
    </div>
    </router-link>
  </div>
</template>
<script>
export default {
  name: "ProductCard",
  props:{
    product:Object
  },
 data(){
   return{
     loop:false,
     picture:0,
   };
 },
 created(){

 },
 methods:{
   startLoop(){
     this.loop=true;
   },
   endLoop(){
     this.loop=false;
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