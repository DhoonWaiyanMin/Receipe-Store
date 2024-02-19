<template>
    <div class=" w-full h-full flex justify-between items-center">
        <div class=" w-1/4 h-screen">
            <nav class="px-10 py-4">
                <router-link :to="{name : 'home'}">
                    <span class="text-xl text-red-400 font-bold">My Receipes</span>
                </router-link>
            </nav>
        </div>

        <div class="w-3/4 border-l-2 border-l-slate-400 px-5 py-10">
            <form class="w-[700px] bg-white p-10 rounded-lg shadow-2xl shadow-gray-700" @submit.prevent="handleSubmit">

                <div class="mt-3">
                    <label class="block text-lg font-semibold tracking-wide text-gray-500 mb-2">Receipe Title :</label>
                    <input type="text" class="w-full text-sm border-b bg-gray-200 border-b-blue-300 focus:border-b-2 focus:outline-none p-2" autocomplete="off" required v-model="data.title" />
                </div>

                <div class="mt-3">
                    <label class="block text-lg font-semibold tracking-wide text-gray-500 mb-2">Receipe Description :</label>
                    <textarea class="w-full text-sm border-b bg-gray-200 border-b-blue-300 focus:border-b-2 focus:outline-none p-2" autocomplete="off" required v-model="data.description"></textarea>
                </div>

                <div class="mt-3">
                    <label class="block text-lg font-semibold tracking-wide text-gray-500 mb-2">Category :</label>
                    <select class="w-full text-sm border-b bg-gray-200 border-b-blue-300 focus:border-b-2 focus:outline-none p-2" required v-model="data.category_id">
                        <option v-for="category in categories" :key="category.id" class="text-gray-800" :value="category.id">{{ category.name }}</option>
                    </select>
                </div>

                <div class="mt-3">
                    <label class="block text-lg font-semibold tracking-wide text-gray-500 mb-2">Receipe Photo :</label>
                    <input type="file" @change="getImage" accept="image/jpg , image/jpeg , image/png" class="w-full text-sm border-b bg-gray-200 border-b-blue-300 focus:border-b-2 focus:outline-none p-2" required autocomplete="off"/>
                </div>
                
                <div class="mt-3" v-if="data.photo">
                    <img :src="data.photo" class="w-full h-[300px] object-cover" alt="">
                </div>

                <div class="my-7">
                    <button class="w-full bg-transparent border text-red-600 text-md tracking-wide border-red-600 p-2 rounded-md">Save</button>
                </div>

            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            "categories" : [],
            "data" : {
                title : "",
                description : "",
                category_id : "",
                photo : ""
            }
        }
    },
    methods : {
        getImage(e){
            let files = e.target.files[0];
            console.log(files);
            if(!files instanceof File){
                return;
            }
            this.data.photo = files
        },
        async getAllCategories(){
           
            try{
                let { data } = await this.$axios.get("/categories");

                if(data){
                    this.categories = data

                }
            }catch(err){
                console.log(err);
            }
           
        },
        async handleSubmit(){
            try{
                let formData = new FormData();
                formData.append("photo",this.data.photo)
                let res = await this.$axios.post("receipes/upload",formData)
                
                
                if(res){
                    this.data.photo = res.data.path

                    if(this.$route.params?.id){
                        // edit state 
                    }else{
                        // create state 
                    }

                    let response = await this.$axios.post("receipes",this.data)

                    if(response){
                        this.$route.push("/");
                    }
                }
                
                
            }catch(err){
                console.log(err)
            }
        },
        async singleReceipe(id){
            try{
                let res = await this.$axios.get("/receipes/" + id);
                if(res){
                    this.data = res.data
                }
            }catch(err){
                console.log(err)
            }
        }
    },
    mounted(){
        this.getAllCategories();
        if(this.$route.params?.id){
            this.singleReceipe(this.$route.params.id);
        }
    }
}
</script>

<style>

</style>