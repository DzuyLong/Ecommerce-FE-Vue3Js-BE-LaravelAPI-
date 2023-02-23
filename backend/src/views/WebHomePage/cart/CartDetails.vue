<template>
  <div class="container px-10 py-10">
    <table class="w-full">
      <thead>
        <tr class="font-mono text-xl">
          <th>
            <input
              type="checkbox"
              v-model="selectedAll"
              @change="toggleSelectAll"
            />
          </th>
          <th>Hình Ảnh</th>
          <th>Product Name</th>
          <th>Quantity</th>
          <th>Unit Price</th>
          <th>Total Price</th>
          <th>Thao Tác</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(cart, index) in carts"
          :key="index"
          class="text-center font-mono text-xl relative"
        >
          <Spinner
            text="Removing..."
            v-if="cart.remove"
            class="absolute justify-center h-full w-full bg-white z-50 block"
          />
          <td><input type="checkbox" v-model="cart.checked" /></td>
          <td>
            <img
              class="w-36 h-[8rem] object-fill inline"
              :src="`http://localhost:8000/uploads/images/${cart.image}`"
              :alt="cart.title"
            />
          </td>
          <td>{{ cart.title }}</td>
          <td>
            <div class="flex justify-center items-center">
              <div
                class="flex relative items-center border rounded-md w-[160px] h-[50px] bg-white"
              >
                <button
                  @click="decrementValue(cart, cart.id, cart.pivot.quantity)"
                  class="btn-decrementValue h-full w-full border-r-[1px]"
                >
                  <span class="sp-btn-minus inline-block"
                    ><i
                      class="bi bi-dash-lg cursor-pointer text-black text-2xl"
                    ></i
                  ></span>
                </button>
                <div
                  class="text-field-value-quantity h-full w-full flex items-center"
                >
                  <Spinner
                    text=""
                    v-if="cart.loading"
                    class="text-center h-[36px] w-[100%] ml-1 text-field-input p-[3px]"
                  />
                  <input
                    v-else
                    @blur="updateValueQuantity(cart, cart.id, cart.pivot.quantity)"
                    v-model="cart.pivot.quantity"
                    class="h-[36px] mx-1 w-[45px] text-center text-field-input p-[6px] font-semibold"
                  />
                  <!-- blur là một sự kiện HTMl nó work khi một phần từ bị mất focus(click ra ngoài hoặc sử dụng tab) -->
                </div>
                <button
                  @click="incrementValue(cart, cart.id, cart.pivot.quantity)"
                  class="btn-incrementValue h-full w-full border-l-[1px]"
                >
                  <span class="sp-btn-plus inline-block"
                    ><i
                      class="bi bi-plus-lg cursor-pointer text-black text-2xl"
                    ></i
                  ></span>
                </button>
              </div>
            </div>
          </td>
          <td>{{ $filters.currencyVND(cart.price) }}</td>
          <td class="text-red-600">
            {{ $filters.currencyVND(cart.price * cart.pivot.quantity) }}
          </td>
          <td>
            <div class="">
              <i
                @click="removeProductFromCart(cart)"
                class="bi bi-x-circle text-3xl cursor-pointer hover:text-red-600"
              ></i>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <ButtonScroll />
    <div
      class="sticky bottom-0 w-full left-[0%] flex justify-center font-mono mt-10"
    >
      <div class="bg-white w-[1000px] grid grid-cols-2 shadow-xl">
        <div class="flex flex-col justify-evenly p-5 gap-2">
          <span class="text-xl"
            >Tổng sản phẩm thanh toán:( {{ selectedItemsCount }} Sản phẩm
            )</span
          >
          <span class="text-2xl font-semibold text-red-600"
            >Tổng tiền: {{ $filters.currencyVND(total) }}</span
          >
        </div>
        <div class="flex items-center justify-center">
          <div class="relative" ref="closebox">
            <span @click="showAddress" class="cursor-pointer">Địa chỉ</span>
            <transition name="fade-in-up">
              <div
                v-if="isShowAddress"
                class="absolute w-[500px] max-h-[500px] top-[-270px] left-[-200px] z-20 shadow-md"
              >
                <div
                  class="bg-white flex justify-between py-2 border-b-[1px] border-neutral-200 px-7"
                  v-for="(address, index) in Addresses"
                  :key="index"
                >
                  <div class="flex flex-col">
                    <div class="flex items-center gap-3">
                      <span>{{ address.fullname }}</span>
                      <span>|</span>
                      <span>{{ address.telephone }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                      <span>{{ address.province.name }},</span>
                      <span>{{ address.district.name }},</span>
                      <span>{{ address.ward.name }}</span>
                    </div>
                    <div class="flex">
                      <span>{{ address.details_address }}</span>
                    </div>
                  </div>
                  <div class="flex items-center">
                    <div class="">
                      <input
                        type="radio"
                        :id="`address-${index}`"
                        name="group_radio"
                        v-model="selectedOption"
                        :value="address.id"                    
                      />
                    </div>
                  </div>
                </div>
              </div>
            </transition>
          </div>
          <button class="py-4 px-10 bg-amber-400" @click="Checkout(carts,Addresses,total)">
            Đặt Hàng
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import Spinner from "../../../components/core/Spinner.vue";
import store from '../../../store';
import ButtonScroll from '../../../views/button/buttonScroll.vue'
import {computed, onMounted, ref, watch , toRefs, watchEffect, reactive} from "vue";
import Swal from 'sweetalert2';
const closebox = ref(null);
const selectedOption = ref(null);
 // Lấy giá trị đã lưu trữ trong localStorage (nếu có)
 const storedValue = localStorage.getItem('selectedOption');
    if (storedValue) {
      selectedOption.value = storedValue;
    }
     // Lưu trạng thái của radio button vào localStorage khi người dùng chọn
   watchEffect(() => {
       localStorage.setItem('selectedOption', selectedOption.value);
    });

const carts = computed(() => store.state.customer.cartData);
onMounted(() => {
    if(store.state.customer.token) {
      store.dispatch('getCart');
      getAddress();
    }
    document.addEventListener('click', (event) => {
  if (event.target && closebox.value && closebox.value.contains) {
    if (!closebox.value.contains(event.target)) {
      isShowAddress.value = false;
    }
  }
});
})
function updateValueQuantity(cart, productId, newQuantityValue) {
  cart.loading = true;
  if(!cart.pivot.quantity || cart.pivot.quantity == 0) {
    cart.pivot.quantity = 1;
  }
  store.dispatch('UpdateCartQuantity', {productId,  newQuantityValue: Number(newQuantityValue)}).
  then( response => {
      cart.loading = false;
      console.log(response);
  })
}
function incrementValue(cart, productId, newQuantity) {
  cart.loading = true;
  store.dispatch('UpdateCartQuantity', {productId, newQuantity: Number(newQuantity) + 1}).
  then( response => {
    cart.loading = false;
     cart.pivot.quantity++;
      console.log(response);
  })
}
function decrementValue(cart, productId, newQuantity) {
  cart.loading = true;
  store.dispatch('UpdateCartQuantity', {productId, newQuantity: Number(newQuantity) - 1}).
  then( response => {
    cart.loading = false;
    if (cart.pivot.quantity > 1) {
      cart.pivot.quantity--;
    }
      console.log(response);
  })
}
 function removeProductFromCart(cart) {
  cart.remove = true;
    store.dispatch('removeFromCart', cart).
    then( response => {
      cart.remove = true;
      store.dispatch('getCart');
    })
 }
 const selectedAll = ref(false);
 function toggleSelectAll() {
  for (const item of store.state.customer.cartData) {
        item.checked = selectedAll.value
      }
 }
    const selectedItemsCount = computed(() => {
      return store.state.customer.cartData.filter(item => item.checked).length;
    });
    const total = computed(() => {
      return store.state.customer.cartData.reduce((totalItem, item) => {
        if (item.checked) {
          return totalItem + (item.price * item.pivot.quantity);
        }
        return totalItem;
      }, 0);
    });
const isShowAddress = ref(false);
const Addresses = ref({});
function showAddress (){
  isShowAddress.value = !isShowAddress.value;
}
 function getAddress() {
    store.dispatch('getAddress').
    then(response => {
        Addresses.value = response.data.getAddress;
    })
 } 
  function Checkout(carts,Addresses,total) {
    const checkedCarts = reactive([]);
    const getIdCarts = reactive([]);
    for (const cart of carts) {
    if (cart.checked) {
      getIdCarts.push(cart.id);
      checkedCarts.push(cart);
    }
  }
  const checkedAddresses = reactive({})
  const getIdAddress = ref({});
    for (const address of Addresses) {
    if (selectedOption.value == address.id) {
      checkedAddresses[address.id] = address;
      getIdAddress.value = address.id;
    }
  }
      store.dispatch('checkout',{checkedCarts,checkedAddresses, getIdAddress: getIdAddress.value, getIdCarts , total}).
      then(response => {
        console.log(response.data);
      });
  }
</script>

<style scoped>
.fade-in-up-enter-active {
  animation: fadeInUp 0.4s;
}
.fade-in-up-leave-active {
  opacity: 0;
  transform: translate3d(0, -5%, 0);
  transition: all 0.2s ease-in;
}

@keyframes fadeInUp {
  from {
    transform: translate3d(0, 5%, 0);
    /* scale: 0; */
    opacity: 0;
  }

  to {
    transform: translate3d(0, 0, 0);
    /* scale: 1; */
    opacity: 1;
  }
}
.btn-decrementValue:hover .sp-btn-minus {
  transform: translateY(-1px);
  color: black;
}
.btn-incrementValue:hover .sp-btn-plus {
  transform: translateY(-1px);
  color: black;
}
</style>
