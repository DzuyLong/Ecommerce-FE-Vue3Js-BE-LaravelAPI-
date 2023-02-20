<template>
    <section id="slider">
        <Swiper  class="border-gray-500 w-full mb-10 "
                 :effect="'coverflow'" 
                 :speed=500
                 :centeredSlides="true"
                 :slidesPerView="'auto'"
                 :loopedSlides="10"
                 :loopedSlidesLimit="true"
                 :loopPreventsSlide="true"
                 :coverflowEffect="{
                        rotate: 0,
                        stretch: 0,
                        depth: 65,
                        modifier: 4,
                        slideShadows: true,
                        }"
                :modules="modules"
                :space-between="15"
                :loop="true"
                    navigation
                :pagination="{clickable:true}"
                :autoplay="{delay:99999, disableOnInteraction: false, pauseOnMouseEnter: true}"          
        >
        <SwiperSlide v-for="(product, index) in products" :key="index" class="relative 
        before:w-full before:h-full before:absolute before:rounded-md ">
            <div class="slide-img">
                <img :src="product.image_url" :alt="product.title" class="md:w-[20rem] md:h-[25rem] w-[15rem] h-[20rem] 
                rounded-lg object-cover" />
                <button class="btn-buy-now absolute top-1/2 left-1/2  
                z-20 bg-transparent hover:bg-amber-400 text-white font-bold md:py-4 md:px-8 py-2 px-6 border-b-4 
                 border-2 border-amber-200 hover:border-amber-600 hover:text-slate-900 rounded">
                <a class="text-sm md:text-[18px]">Buy Now</a>
            </button>
            </div>
            <div class="absolute top-0 right-0 bottom-0 left-0 z-10">
                <h1 class="bg-slate-900/50 px-4  text-price md:text-4xl text-2xl top-1 left-4 text-amber-400 absolute md:left-4 font-extrabold">{{ $filters.currencyVND(product.price) }}</h1>
                <div class="absolute bottom-0 left-4">
                <h1 class="text-title md:text-4xl text-2xl text-white font-semibold">{{ product.title }}</h1>
                <div class="rating flex items-center gap-1 md:gap-3 mt-1 mb-2">
                        <svg aria-hidden="true" class="md:w-7 md:h-7 h-5 w-5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>First star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        <svg aria-hidden="true" class="md:w-7 md:h-7 h-5 w-5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Second star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        <svg aria-hidden="true" class="md:w-7 md:h-7 h-5 w-5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Third star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        <svg aria-hidden="true" class="md:w-7 md:h-7 h-5 w-5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Fourth star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        <svg aria-hidden="true" class="md:w-7 md:h-7 h-5 w-5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Fifth star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        <span class=" text-white md:text-3xl text-2xl font-bold px-1.5 md:px-2.5 mb-3 md:mb-0 rounded">5.0</span>
                    </div>
                </div>     
            </div>
        </SwiperSlide>
        </Swiper>
    </section>
</template>
  <script>
   import { Swiper, SwiperSlide } from 'swiper/vue';
   import { Autoplay, Pagination, Navigation ,EffectCoverflow} from 'swiper';
   import '../../../assets/slider1.css';
   import 'swiper/css';
   import 'swiper/css/pagination';
   import 'swiper/css/navigation';
    import 'swiper/css/scrollbar';
   import {ref ,onMounted, reactive} from 'vue';
   import store from "../../../store";
   export default {
    components: {
        Swiper,
        SwiperSlide,
    },
    setup() {
        const products = ref({});   
    onMounted( () => {
        getProductsSlide();
    })
    function getProductsSlide() {
        store.dispatch("getProductSlides").
        then(async ({data}) => {
            products.value  = await data.data;
          });
      }
   return { modules: [Pagination, Autoplay, Navigation, EffectCoverflow], products}
}
}
  </script>
<style >
</style>