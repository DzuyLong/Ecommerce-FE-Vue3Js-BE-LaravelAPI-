<template>
  <div>
    <Navbar />
    <main class="p-6">
      <Slider />
      <section id="content" class="flex md:justify-between md:flex-nowrap flex-wrap">
      <ContentLeft />
      <ProductContent v-if="route.path === '/'" />
      <div v-else class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 justify-items-center w-full relative">
      <router-view></router-view>
      </div>
      </section>
    </main>
  </div>
</template>

<script setup>
 import {computed, onMounted,onUpdated, ref, reactive,  watch} from "vue";
 import {useRoute}  from 'vue-router';
 import store from '../store';
import ProductContent from '../../src/views/WebHomePage/contentsite/ProductContent.vue'
import Navbar from '../views/WebHomePage/Navbar.vue'
import Slider from '../../src/views/WebHomePage/contentsite/Slider.vue'
import ContentLeft from '../../src/views/WebHomePage/contentsite/ContentLeft.vue'
const route = useRoute();

onMounted(() => {
    store.dispatch('getCart');
});
</script>