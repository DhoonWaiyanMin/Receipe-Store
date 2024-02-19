<template>
  <router-view v-slot="{ Component }">
    <component :is="Component" />
  </router-view>
</template>

<script>

</script>

<style>
body{
  background: #f4f4f4;
}
</style>