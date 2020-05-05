<template>
  <div class=" h-56 ">
    <div class="w-40 ml-8">
      <carousel class="carousel-slider" :per-page="1" :autoplay="true" :autoplayHoverPause="true" :mouse-drag="true" :width="100"
        :loop="true" :navigation-enabled="false" :paginationEnabled="false" :autoplayTimeOut="3000" :speed="500">
        <slide v-for="(image,index) in product.images" :key="index">
          <img :src="'/storage/' + image.img" class="w-40">
        </slide>
      </carousel>
    </div>
    <div class="flex">
      <p class="bg-green-500 text-white px-5 py-1">{{product.description}} </p>
      <p class="bg-green-800 text-white px-1 py-1">{{product.price}}€</p>
    </div>
   <div class="m-200 w-100 ml-6">
      <star-rating  :rating="product.valoration" :read-only="true" :show-rating="false" :increment="0.25"
                  active-color="#f3bf48" :star-size="30" :padding="5"></star-rating>
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
     this.$axios.get(`api/getProduct/1`).then(response =>{
        this.product=response.data;
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