<template>
<Navbar />

<div class=" w-[1200px] mx-auto min-h-full pt-6">
    <div class="relative w-full">
        <div class="flex items-center space-x-4 after:w-full after:h-[0.5px]  after:bg-gray-300 after:absolute after:top-[30px]">
            <router-link class="hover:translate-y-[-1px] transition-all duration-150 ease-in hover:font-semibold" :to="{name: 'homepage'}"><span class="text-gray-500 font-mono 
              hover:text-amber-500">Trang Chủ</span></router-link>
            <i class="bi bi-chevron-double-right font-semibold"></i>
            <span class="font-semibold font-mono">{{ productDetail.title }}</span>
        </div>
        <div class="grid grid-cols-12 mt-[15px]">  
           <div class="grid grid-cols-1 col-span-7">
            <Splide ref="main" id="#main-slider" 
            :options="{ 
                type       : 'fade',
                heightRatio: 0.5,
                pagination : false,
                arrows     : false,
                cover      : true,
            }" 
            aria-label="My Favorite Images">
                        <SplideSlide v-for="(image,index) in slides" :key="index">
                        <img :src="image.img">
                        </SplideSlide>
                        
            </Splide>
            <Splide ref="thumbnails"  id="#thumbnail-slider" :options="{ 
                rewind: true ,
                fixedWidth      : 104,
                fixedHeight     : 58,
                perMove         : 1,
                isNavigation    : true,
                gap             : 10,
                focus           : 'center',
                pagination      : false,
                cover           : true,
                dragMinThreshold: {
                        mouse: 4,
                        touch: 10,
                    },
                    breakpoints : {
                        640: {
                        fixedWidth  : 66,
                        fixedHeight : 38,
                        },
                    },
                }" aria-label="My Favorite Images">
                        <SplideSlide v-for="(image,index) in slides" :key="index">
                        <img :src="image.img">
                        </SplideSlide>
              <!-- <div class="splide__arrows">
                  <button class="splide__arrow splide__arrow--prev">
                    Prev
                  </button>
                  <button class="splide__arrow splide__arrow--next">
                    Next
                  </button>
                </div>        -->
            </Splide>
           </div>
            <div class="grid grid-cols-1 col-span-5 gap-3 mt-[20px] pl-9 font-mono">
              <div class="title-product flex items-center flex-col">
                <span><strong class="text-2xl">Sản Phẩm:</strong></span>
               <span>{{ productDetail.title }}</span>
              </div>
              <div class="price-product border-b-[1px] border-slate-300 flex justify-between">
                <span class="text-3xl font-bold text-red-600">{{ $filters.currencyVND(productDetail.price * currentValue )}}</span>
                <!-- <span><p>{{ newPrice }}</p></span> -->
                <div class="price-product-right flex flex-col justify-self-auto">
                  <div class="likes-product flex  items-center mb-3">
                    <i class="bi bi-bookmark-heart mr-3 text-xl text-pink-600"></i>
                  <span><h3>Lượt thích(...)</h3></span>
                  </div>
                  <div class="flex  items-center">
                    <i class="bi bi-bag-check mr-3 text-xl text-amber-500"></i>
                    <span><h3>Đã bán(...)</h3></span>
                  </div>
                </div>
              </div>
              <div class="flex justify-between">
                <div class="flex justify-evenly items-center border rounded-md w-[160px] h-[50px] bg-white">
                <button  @click="decrementValue" class="btn-decrementValue h-full w-full border-r-[1px]">
                <span class="sp-btn-minus inline-block"><i class="bi bi-dash-lg cursor-pointer text-black text-2xl"></i></span>
              </button>
                <div class="text-field-value-quantity  mx-1">
                  <input min="1" v-model="currentValue" class="h-[36px] w-[41px] text-center text-field-input p-[3px] font-semibold"/>
                </div>
                <button @click="incrementValue" class="btn-incrementValue h-full w-full border-l-[1px]">
                <span class="sp-btn-plus inline-block"><i class="bi bi-plus-lg cursor-pointer text-black text-2xl"></i></span>
                </button>
              </div>
              <div class="flex ">
                <i class="bi bi-box-seam mr-3 text-xl"></i>
                <span class="font-semibold text-[18px]">Kho: {{ quantity.quantity }}</span>
              </div>
              </div>
              <div class="btn-product grid grid-cols-2 gap-3">
                <button  class="text-white bg-amber-700 hover:bg-amber-800 
                        focus:ring-4 focus:outline-none focus:ring-amber-500 font-medium 
                        rounded-lg  px-4 py-2 text-center hover:translate-y-[-2px] transition-all duration-400
                        h-[50px] hover:font-semibold  hover:outline"
                        @click="addToCart(productDetail.id,currentValue)">
                            <i class="bi bi-bag-plus-fill mr-2"></i>Add to cart</button>
                <button class=" h-[50px] text-black font-medium bg-amber-400 rounded-lg hover:bg-amber-500 
                hover:translate-y-[-1px] transition-all duration-400 focus:ring-amber-800 focus:ring-4 focus:outline-none hover:font-semibold hover:outline">Mua Ngay</button>
              </div>
            </div> 
        </div>
         <!-- --------------descriptions---------- -->

         <div class="col-span-12 mt-6 font-mono">
          <div class="flex space-x-10">
            <div class="w-[1000px] h-full border border-solid border-neutral-300 shadow-md rounded-lg">
                  <div class="tabs-details">
                    <div class="tabs-btn grid grid-cols-3 border-b border-solid border-neutral-300 shadow-sm">
                    <button class="text-neutral-500 border-slate-400 border-r-[1px] p-[5px] m-[5px]" :class="{ active: activeTab === 'tab1' }" @click="activeTab = 'tab1'">Mô tả sản phẩm</button>
                    <button class="text-neutral-500 border-slate-400 border-r-[1px] p-[5px] m-[5px]" :class="{ active: activeTab === 'tab2' }" @click="activeTab = 'tab2'">Bình luận, Đánh giá</button>
                    <button class="p-[5px] m-[5px] text-neutral-500" :class="{ active: activeTab === 'tab3' }" @click="activeTab = 'tab3'">Bảo hành, thương hiệu</button>         
                  </div>
                  <div v-if="activeTab === 'tab1'" :class="{ active: activeTab === 'tab1' }" class="tab-content-wrapper mt-2">
                      <div class="w-full h-full">
                          <div class="details-content">
                            <span class=""><h1 class="text-xl text-center px-5 font-semibold">CHI TIẾT SẢN PHẨM</h1></span>
                            <div class="bg-neutral-200 m-4">
                            <div class="grid grid-cols-2 gap-x-[1px]">
                              <div class="flex items-center justify-start">
                                <div class="w-[100px]"><span>Danh Mục</span></div>
                                <div class="font-semibold"><span>....</span></div>
                              </div>
                              <div class="flex items-center justify-start">
                                <div class="w-[100px]"><span>Danh Mục</span></div>
                                <div class="font-semibold"><span>....</span></div>
                              </div>
                              <div class="flex items-center justify-start">
                                <div class="w-[100px]"><span>Danh Mục</span></div>
                                <div class="font-semibold"><span>....</span></div>
                              </div>
                              <div class="flex items-center justify-start">
                                <div class="w-[100px]"><span>Danh Mục</span></div>
                                <div class="font-semibold"><span>....</span></div>
                              </div>
                              <div class="flex items-center justify-start">
                                <div class="w-[100px]"><span>Danh Mục</span></div>
                                <div class="font-semibold"><span>....</span></div>
                              </div>
                              <div class="flex items-center justify-start">
                                <div class="w-[100px]"><span>Danh Mục</span></div>
                                <div class="font-semibold"><span>....</span></div>
                              </div>
                            </div>
                            </div>                          
                          </div>
                         <div class="desc-content">
                          <span class=""><h1 class="text-xl text-center px-5 font-semibold">MÔ TẢ SẢN PHẨM</h1></span> 
                          <div class="h-full text-[14px] m-3">
                            <p>{{ productDetail.description }}</p>
                          </div> 
                         </div>
                      </div>
                    </div>
                    <div v-if="activeTab === 'tab2'" :class="{ active: activeTab === 'tab2' }" class="tab-content-wrapper mt-2">
                      <div class="w-full h-full">
                          <div>
                            <span class=""><h1 class="text-xl">TAB ĐÁNH GIÁ</h1></span>
                            <div class="grid grid-cols-2"></div>
                          </div>
                      </div>
                    </div>
                    <div v-if="activeTab === 'tab3'" :class="{ active: activeTab === 'tab3' }" class="tab-content-wrapper mt-2">
                      <div class="w-full h-full">
                          <div>
                            <span class=""><h1 class="text-xl">TABBH THƯƠNG HIỆU</h1></span>
                            <div class="grid grid-cols-2"></div>
                          </div>
                      </div>
                    </div>
                  </div>
                  
                  </div>
                  <div class="w-[200px] h-full">
                    <span>Banner</span>
                  </div>  
                </div>      
                <!-- -------------product related------ -->
                <div class="my-4">
                  <div class="p-3 text-neutral-900 font-semibold border-t border-l border-r rounded-t-md border-neutral-300"><span>SẢN PHẨM LIÊN QUAN</span></div>
                  <div class="grid grid-cols-4 gap-2 p-2 border-neutral-300 border ">
                    <div v-for="(productrl, index) in relatedProduct" :key="productrl.id" class=" bg-white rounded-lg shadow-md
                  hover:translate-y-[-2px] hover:shadow-stone-500 transition-all duration-400 ease-linear 
                  dark:bg-gray-800 dark:border-gray-700">
                  <router-link class="border-solid border-b-2 block  m-3 border-slate-200" :to="{params: {slug: productrl.slug}, name: 'ProductDetails'}">         
                          <img class="object-fill h-48 w-96 md:mb-2 mb-4" :src="productrl.image_url" alt="product image" />
                  </router-link>
                      <div class="px-5 pb-5">
                          <a href="#">
                              <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ productrl.title }}</h5>
                              <p>{{ productrl.description }}</p>
                          </a>
                          <div class="flex items-center mt-1 mb-2">
                              <svg aria-hidden="true" class="w-5 h-5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>First star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                              <svg aria-hidden="true" class="w-5 h-5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Second star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                              <svg aria-hidden="true" class="w-5 h-5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Third star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                              <svg aria-hidden="true" class="w-5 h-5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Fourth star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                              <svg aria-hidden="true" class="w-5 h-5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Fifth star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                              <span class="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800 ml-3">5.0</span>
                          </div>
                          <div class="flex items-center flex-col justify-between">
                              <span class="text-3xl font-bold mb-1 text-gray-900 dark:text-white"> {{ $filters.currencyVND(productrl.price) }}</span>
                              <button  class="text-white bg-amber-700 hover:bg-amber-800 
                              focus:ring-4 focus:outline-none focus:ring-amber-500 font-medium 
                              rounded-lg text-sm px-4 py-2 text-center hover:translate-y-[-1px] transition-all duration-400"
                              @click="addToCart(productrl.id)">
                                  <i class="bi bi-bag-plus-fill mr-2"></i>Add to cart</button>
                          </div>
                      </div>
                  </div>
                  </div>
                </div>              
            </div>
    </div>
    <ButtonScroll />
</div>

</template>
<script setup>
import {computed, onMounted, onUnmounted ,onUpdated, ref, reactive,  watch} from "vue";
import ButtonScroll from '../../../../src/views/button/buttonScroll.vue';
import Navbar from '../Navbar.vue';
import store from "../../../store";
import {useRoute}  from 'vue-router';
import router from "../../../router";
import Swal from 'sweetalert2';
import { Splide, SplideSlide } from '@splidejs/vue-splide';
import '@splidejs/vue-splide/css';
const activeTab = ref('tab1');
const slides = ref([
      { img: 'data:image/jpeg;base64,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' },
      { img: 'https://media.istockphoto.com/id/1322277517/photo/wild-grass-in-the-mountains-at-sunset.jpg?s=612x612&w=0&k=20&c=6mItwwFFGqKNKEAzv0mv6TaxhLN3zSE43bWmFN--J5w=' },
      { img: 'https://media.istockphoto.com/id/1322277517/photo/wild-grass-in-the-mountains-at-sunset.jpg?s=612x612&w=0&k=20&c=6mItwwFFGqKNKEAzv0mv6TaxhLN3zSE43bWmFN--J5w=' },
      { img: 'https://product.hstatic.net/200000411281/product/thiet_ke_khong_ten__13__ecd4e91f1eaf4643980fc43cb24c9e2b_grande.jpg' },
      { img: 'https://cdn.tgdd.vn/Files/2017/01/19/939425/cach-cai-hinh-nen-may-tinh-khong-bi-mo_1280x720-800-resize.jpg' },
      { img: 'https://fptshop.com.vn/Uploads/Originals/2020/9/29/637369735917636373_huong-dan-cach-cai-dat-hinh-nen-may-tinh-win-10-don-gian-8.jpg' },
      { img: 'https://media.istockphoto.com/id/1322277517/photo/wild-grass-in-the-mountains-at-sunset.jpg?s=612x612&w=0&k=20&c=6mItwwFFGqKNKEAzv0mv6TaxhLN3zSE43bWmFN--J5w=' },
      { img: 'https://media.istockphoto.com/id/1322277517/photo/wild-grass-in-the-mountains-at-sunset.jpg?s=612x612&w=0&k=20&c=6mItwwFFGqKNKEAzv0mv6TaxhLN3zSE43bWmFN--J5w=' },
      { img: 'https://media.istockphoto.com/id/1322277517/photo/wild-grass-in-the-mountains-at-sunset.jpg?s=612x612&w=0&k=20&c=6mItwwFFGqKNKEAzv0mv6TaxhLN3zSE43bWmFN--J5w=' },
      // ...
    ])

    const main = ref(null);
    const thumbnails = ref(null);

    const inputValue = ref('');
    // const defaultValue = 1;

    const currentValue = computed({
      get() {
        if (!inputValue.value || inputValue.value === 0) {
       return  inputValue.value = 1;
      }else{
        return inputValue.value
      }     
      },
      set(newValue) {
        inputValue.value = newValue;
      }
    });
   
/* get() method sẽ được gọi khi bạn truy xuất giá trị của currentValue. 
Nó sẽ trả về giá trị của inputValue nếu inputValue có giá trị, nếu không nó 
sẽ trả về defaultValue.
set(newValue) method sẽ được gọi khi bạn gán giá trị mới cho currentValue. 
Nó sẽ gán giá trị mới cho inputValue.
*/

const incrementValue = () => {
      inputValue.value = parseInt(inputValue.value) + 1;
    };

const decrementValue = () => {
      inputValue.value = parseInt(inputValue.value) - 1;
    };


const route = useRoute()
const slug = ref('');
const productDetail = ref({});
const quantity = ref({});
const relatedProduct = ref({});
const showButtonScroll = ref(false);
slug.value = route.params.slug;
    watch(
    () => route.params.slug, 
    () => {
        slug.value = route.params.slug, ProducDetail();  
        window.scroll({
        top: 0,
        left: 0,
        behavior: 'smooth'
      }); 
      inputValue.value = 1
    }
    );
 onMounted(() => {
  if(store.state.customer.token) {
    store.dispatch('getCart');
  }
    ProducDetail(); 
    const thumbsSplide = thumbnails.value.splide;
      if ( thumbsSplide ) {
        main.value.sync( thumbsSplide );
      }
  })
function ProducDetail() {
   store.dispatch("ProducDetail", slug.value).
   then( response => {
    productDetail.value  = response.data.data;
    quantity.value = response.data.quantity;
    relatedProduct.value = response.data.relatedProduct;
     });
 }
//  const newPrice = computed(() => { return console.log(currentValue * productDetail.price) });
const isConfirm = ref(false);
    function addToCart(productId, quantity) {
        store.dispatch("addToCart", {productId, quantity}).
        then(async (response) => {
            isConfirm.value = true;
            await Swal.fire({
                title: 'Thêm sản phẩm vào giỏ hàng thành công',
                text: 'Bạn có muốn xem chi tiết giỏ hàng?',
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: 'Xem chi tiết',
                cancelButtonText: 'Trở về',
                preConfirm: () => {
                     router.push({name: 'cartDetails'});
             }
        });
        console.log(response.data);
        }).catch(error => {
          console.error(error);
        });
    }
</script>

<style scoped>

.tabs-btn .active {
  background-color: lightgray;
  color: black;
  font-weight: bold;
  border: inset 3px #fbbf24;
  transition: all 0.3s ease-out;
}
.tabs-btn button:not(.active):hover {
  transform: translateY(-1px);
  transition: all 0.3s ease-out;
  color: black;
}
.btn-decrementValue:hover .sp-btn-minus {
  transform: translateY(-1px);
  color: black;
}
.btn-incrementValue:hover .sp-btn-plus {
  transform: translateY(-1px);
  color: black;
}
div#\#main-slider{
  padding: 10px;
  background-color: whitesmoke;
  border-radius: 10px;
  box-shadow: 1px 0px 25px -10px;
}
div#\#thumbnail-slider {
  margin-top: 10px;
}
.splide__slide {
  opacity: 0.7;
}

.splide__slide.is-active {
  opacity: 1;
}
.splide__track--nav>.splide__list>.splide__slide.is-active {
    border: 2px solid #ffffff;
}
.text-field-input {

}
</style>