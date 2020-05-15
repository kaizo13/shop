<template>
    <div class="  bg-white z-40 flex sticky top-0 border border-solid border-gray-300 h-28 ">
        <a href="/"><img class="h-20 ml-10" src="/img/logo.png"></a>
        <div class="align-center">
            <a v-for="(link,index) in links" :key="index" :href="link.route" class="link relative bottom-0 text-green-500 ml-20">{{link.name}}</a>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            links:[
                {
                    name: "Productos",
                    route:"/",
                },
                {
                    name:"Mis Pedidos",
                    route:"/pedidos",
                },
            ]
        }
    }
}
</script>
<style scoped>
.link:hover{
    color:gold;
}
</style>