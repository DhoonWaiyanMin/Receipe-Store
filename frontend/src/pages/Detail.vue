<template>
    <div class="p-10">
        <nav class="flex justify-between items-center px-10 py-4">
            <router-link :to="{name : 'home'}">
                <span class="text-xl text-red-400 font-bold">My Receipes</span>
            </router-link>
        </nav>

        <div class="flex justify-between items-center">
            <div class="w-1/3 h-[300px] mr-5">
                <img :src="receipe.photo" class="object-cover" alt="">
            </div>
            <div class="w-2/3">
                <div class="p-3 absolute right-[20px] top-[50px] flex">
                    <button @click="handleDelete" class="mx-5 bg-red-500 text-white px-3 py-2 hover:bg-gray-500  rounded-md">Delete</button>
                    <router-link :to="{name : 'edit' , params : {id : receipe.id}}">
                        <button class="mx-5 bg-blue-500 text-white px-3 py-2 hover:bg-gray-500  rounded-md">Edit</button>
                    </router-link>
                </div>
                <h1 class="text-xl font-semibold text-gray-600">{{ receipe.title }}</h1>
                <p class="text-gray-700 mt-8">{{ receipe.description }}</p>
            </div>

        </div>


    </div>
</template>

<script>
export default {
    data(){
        return {
            receipe : {}
        }
    },
    methods : {
        async singleReceipe(){
            try{
                let res = await this.$axios.get("/receipes/" + this.$route.params?.id);
                if(res){
                    this.receipe = res.data
                }
            }catch(err){
                console.log(err)
            }
        },
        async handleDelete(){
            let id = this.$route.params.id;

            try {
                let res = await this.$axios.delete("/receipes/"+id);
                if(res){
                    
                    console.log(res);
                    this.$router.push({name : "home"});
                }
            } catch (error) {
                console.log(error)
            }
        }
    },
    mounted(){
        this.singleReceipe();
        
    }
}
</script>

<style>

</style>