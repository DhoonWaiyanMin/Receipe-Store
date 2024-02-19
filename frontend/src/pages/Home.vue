<template>
    <div>
        <div>
            <NavBar></NavBar>
        </div>
        <div class="flex justify-center border-b border-b-slate-300 pb-5">
            <div>
                <span class="text-[30px] text-red-600 font-bold block tracking-wider text-center my-3">We made Our Food With Our Love</span>
                <span class="text-yellow-600 text-[20px] font-semibold block tracking-widest text-center mb-5">Come & Taste On <span class="text-red-600 text-[25px] font-extrabold font-[cursive]">OneDay</span></span>
            </div>
            
        </div>

        <div class="flex justify-center items-center mt-5" v-if="categories">
          <button class="border-0 bg-red-400 text-white p-2 rounded-lg shadow-lg hover:bg-gray-600 hover:text-white mx-5" @click="getAllReceipes">All receipes</button>

            <div v-for="category in categories" :key="category.id">
                <button class="border-0 bg-red-400 text-white p-2 rounded-lg shadow-lg hover:bg-gray-600 hover:text-white mx-5" @click="filterReceipesByCategory(category.name)">{{ category.name }}</button>
            </div>
            <!-- <select class="appearance-none bg-gray-700 text-white p-2 rounded-lg hover:bg-red-700 hover:text-white mx-5">
              <option v-for="category in categories" :key="category.id" value="{{ category.name }}">
                {{ category.name }}
              </option>
            </select> -->
        </div>

        <div v-if="isLoading" class=" w-full flex justify-between items-center flex-wrap mt-5 px-10">
            <div v-for="receipe in receipes" :key="receipe.id" class="w-1/4 max-h-[500px] h-[500px] mx-4 my-5 border border-slate-500 overflow-hidden rounded-lg bg-gray-100 shadow-md shadow-gay-900">
                <router-link :to="{name:'detail', params : {id : receipe.id }}">
                  <div class="h-2/3">
                      <img :src="receipe.photo" class="w-full h-full object-cover" alt="">
                      <!-- <img src="http://localhost:8000/storage/receipes/rYGmmoJOSOiXB97tyGCTqMsAVBpkVRhQW6YxvL5H.jpg" class="w-full h-full object-cover" alt=""> -->
                  </div>
                  <div class="h-1/3 p-6">
                      <h2 class="text-lg text-gray-600 font-semibold mb-3 line-clamp-1">{{ receipe.title }}</h2>
                      <p class="line-clamp-3">{{ receipe.description }}</p>
                  </div>
                </router-link>
            </div>
        </div>
        <div v-else class="w-full flex justify-between items-center flex-wrap mt-5 px-10 animate-pulse">
          <div v-for="(_ , index) in new Array(6)" :key="index" class="w-1/4 max-h[500px] h-[500px] mx-4 my-5 border border-slate-500 overflow-hidden rounded-lg bg-gray-100 shadow-md shadow-gay-900 ">
            <div class="h-2/3 bg-gray-200 flex justify-center items-center">
              <div class="w-5 h-5 border-3 border-t-gray-50 rounded-full animate-spin"></div>
            </div>
            <div class="h-1/3 px-6 mt-5">
              <h2 class="w-full h-2 bg-gray-400 rounded-lg my-3"></h2>
              <p class="w-2/3 h-2 bg-gray-400 rounded-lg my-3"></p>
              <p class="w-1/3 h-2 bg-gray-400 rounded-lg my-3"></p>
              <p class="w-2/3 h-2 bg-gray-400 rounded-lg my-3"></p>
              <p class="w-full h-2 bg-gray-400 rounded-lg my-3"></p>
            </div>
          </div>
        </div>

        <div class="gap-x-1 my-10 flex justify-end">
          <!-- <button v-for="(link , index) in links" :key="index" @click="getPaginatedReceipes(link.url)" class="{{ link.active ? 'bg-red-600' : '' }} p-2 border hover:bg-gray-300">{{ link.label }}</button> -->
          <button v-for="(link , index) in links" :key="index" @click="getPaginatedReceipes(link.url)" :class="link.label == current_page ? 'bg-red-600 p-2 border' : '' + ' p-2 border hover:bg-gray-300'">{{ link.label }}</button>

        </div>
    </div>
</template>

<script>
import { getTransitionRawChildren } from 'vue';
import NavBar from '../components/NavBar.vue'

export default {
  components: {
    NavBar
   },
  data(){
    return {
      categories : [],
      receipes : [],
      isLoading : false,
      links : [],
      current_page : 1
    }
  },
  methods : {
    async getCategories(){
      try{
        let res = await this.$axios.get("/categories");
        if(res){
            this.categories = res.data
            this.isLoading = true
        }
      }catch(err){
        console.log(err)
      }
    },

    async filterReceipesByCategory(category){
      try{
        let res = await this.$axios.get("/receipes?category="+category);
        console.log(res)
        if(res){
          this.receipes = res.data.data
        }

      }catch(err){
        console.log(err)
      }
    },

    async getAllReceipes(){
    //   let res = await this.$axios.get("/api/receipes");
    //   console.log(res.data.data);
    //   this.receipes = res.data.data;
        try{
            let res = await this.$axios.get("receipes")
            if(res){
                this.receipes = res.data.data
                console.log(res.data)
                this.links = res.data.links
            }
        }catch(err){
            console.log(err)
        }
    },

    async getPaginatedReceipes(url){
      // console.log(url)
      try {
        if(url !== null){
          let pageNumber = url.split("page=")[1];
          this.current_page = pageNumber;
          let res = await this.$axios.get(url);
          if(res){
            this.receipes = res.data.data
            console.log(res.data)
          }
        }
      } catch (error) {
        console.log(error)
      }
    }
  },
  mounted(){
    this.getCategories();
    this.getAllReceipes();
  }
}
</script>

<style>

</style>