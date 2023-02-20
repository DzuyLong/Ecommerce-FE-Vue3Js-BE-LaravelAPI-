<template>
    <div class="relative box-border ml-3 min-w-0 bg-white shadow-xl rounded-md flex-grow font-mono">
        <div class="flex flex-col relative min-h-full">
            <div class="contents">
                <div class="flex flex-col">
                    <div class="p-5 box-border border-b-[1px] border-neutral-200 flex items-center">
                    <div class="flex-1">
                        <div class="font-semibold text-2xl text-black">My Address</div>
                    </div>
                    <div class="flex">
                        <button @click="showModalValue(true)" class="bg-amber-400 leading-[45px] px-4 text-neutral-600 hover:text-black hover:translate-y-[-1px] transition-all duration-150 ease-in">
                            <div class="flex">
                                <i class="bi bi-plus text-2xl"></i>
                                <span>Thêm địa chỉ mới</span>
                            </div>                                                                       
                        </button>
                        <Modal :showModal="showModal" @close-modal="closeModal" title="New Address">
                            <div class="col-span-12 text-center">
                                <div class="errMsg mb-3">
                                    <span class="text-red-600">{{ errMsg }}</span>
                                </div>
                                <div class=" grid grid-cols-2 gap-12 mb-4">
                                    <div class="col-span-1">
                                        <input v-model="infoAddress.fullName" class="w-full" type="text" placeholder="Họ Và Tên">
                                    </div>
                                    <div class="col-span-1">
                                        <input v-model="infoAddress.phoneNumber" class="w-full" type="text" placeholder="Số Điện Thoại">
                                    </div>
                                </div>  
                                <div class="grid grid-cols-3 gap-4 mb-4">
                                    <div class="col-span-1">
                                        
                                        <select v-model="selectedProvice" @change="fetchDistricts"  class="w-full text-neutral-800" name="province" id="province">
                                            <option disabled selected value="">Tỉnh/ThànhPhố</option>  
                                            <option class="text-black " v-for="province in Provinces.data" :key="province.code" :value=province.code>{{ province.name }}</option>                                   
                                        </select>
                                    </div>
                                    <div class="col-span-1">
                                        
                                        <select v-model="selectedDistrict" @change="fetchWards"   class="w-full text-neutral-800" name="district" id="district">
                                            <option disabled selected value="">Quận/Huyện</option>  
                                            <option class="text-black" v-for="district in Districts.data" :key="district.code"  :value=district.code>{{ district.name }}</option>
                                        </select>
                                    </div>
                                    <div class="col-span-1">
                                       
                                        <select class="w-full text-neutral-800"  name="ward" id="ward" v-model="selectedWard" >
                                            <option disabled selected value="">Xã/Phường</option>  
                                            <option class="text-black " v-for="ward in Wards.data" :key="ward.code"  :value=ward.code>{{ ward.name }}</option>
                                        </select>
                                    </div>
                                </div>    
                            <div class="grid grid-cols-1 ">
                                <div class="col-span-1">
                                    <textarea v-model="infoAddress.addressDetail" class="w-full" max-length="128" rows="2" placeholder="Địa Chỉ Cụ Thể"></textarea>
                                </div>   
                            </div>
                            <div class="flex justify-end items-center">
                                <div class="">
                                    <button @click="saveAdress" class="bg-amber-400 text-black px-4 py-2 rounded-sm hover:translate-y-[-2px] transition-all duration-150 ease-in">Hoàn Thành</button>
                                </div>
                            </div>
                            </div>
                        </Modal>      
                    </div>
                </div>

                    <div class="w-full h-[125px] p-5">
                        <div class="title-address text-center mb-3"><span class="text-xl font-semibold">Địa Chỉ</span></div>
                        <div class="flex flex-col">
                            <div class="">
                                <span>FullName</span>
                            </div>
                            <div class="">
                                <span>Địa chỉ chi tiết</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import {computed,onMounted, onUpdated, ref, watch} from 'vue'
import Modal from './Modal_Address.vue'
import store from '../../store';
const showModal = ref(false)
   function showModalValue(value) {
    showModal.value = value;
    console.log(showModal.value);
   }
onMounted(() => {
    fetchProvinces();
    store.dispatch('getAddress');
})
const Provinces = ref('');
const Districts = ref('');
const Wards = ref('');
const selectedProvice = ref("");
const selectedDistrict = ref("");
const selectedWard = ref("");
 function fetchProvinces() {
    store.dispatch('fetchProvinces').
    then( response => {
        Provinces.value = response.data;
        Wards.value = '';
    })
 }
 function fetchDistricts() {
    if (selectedProvice.value) {
        const idProvince = selectedProvice.value
        store.dispatch('fetchDistricts', idProvince).
            then( response => {
            Districts.value = response.data;
            Wards.value = '';
    })
      }
 }
 function fetchWards() {
    if (selectedDistrict.value) {
        const idDistrict = selectedDistrict.value
        store.dispatch('fetchWards', idDistrict).
            then( response => {
                Wards.value = response.data;
    })
      }
 }
 const infoAddress = {
    fullName: '',
    phoneNumber: '',
    addressDetail: '',
 
  }
  const errMsg = ref('');
  function closeModal() {
        showModal.value = false;
        infoAddress.fullName = "";
        infoAddress.phoneNumber = "";
        infoAddress.addressDetail = "";
        selectedProvice.value = "";
        selectedDistrict.value = "";
        selectedWard.value = "";
        Districts.value = '';
        Wards.value = '';
    }
 function saveAdress() {
    store.dispatch('addAddress', {fullName: infoAddress.fullName, phoneNumber:infoAddress.phoneNumber, addressDetail:infoAddress.addressDetail, province: selectedProvice.value,district: selectedDistrict.value,ward: selectedWard.value}).
    then( response => {
        console.log(response);
        closeModal();
    }).catch(({ response }) => {
        errMsg.value = response.data.message;
      })
 }
//  function getAddress() {
//     store.dispatch('getAddress').
//     then(response => {
//         console.log(response.data);
//     })
//  }
</script>
<style scoped>
.text-color {
    color: black;
}
*:disabled {
    background-color: dimgrey;
    color: linen;
    opacity: 1;
}
</style>