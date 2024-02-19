<template>
  <nav class="flex justify-between items-center px-10 py-4">
    <div>
        <span class="text-xl text-red-400 font-bold">My Receipes</span>
    </div>
    <div>
      <router-link :to="{name : 'add'}">
        <button class="bg-red-400 text-white border-0 rounded-md p-3">Add New Receipe</button>
      </router-link>
    </div>
  </nav>
</template>

<script>
export default {

}
</script>

<style>

</style>