<template>
    <div class="relative box-border ml-3 min-w-0 bg-white shadow-xl rounded-md flex-grow font-mono">
        <div class="flex flex-col relative max-h-[585px] overflow-auto">
            <div class="contents">
                <div class="flex flex-col">
                    <div class="p-5 box-border border-b-[1px] border-neutral-200 flex items-center">
                    <div class="flex-1">
                        <div class="font-semibold text-2xl text-black">My Address</div>
                    </div>
                    <div class="flex">
                        <button @click="showModalAddAddressValue(true)" class="bg-amber-400 leading-[45px] px-4 text-neutral-600 hover:text-black hover:translate-y-[-1px] transition-all duration-150 ease-in">
                            <div class="flex">
                                <i class="bi bi-plus text-2xl"></i>
                                <span>Thêm địa chỉ mới</span>
                            </div>                                                                       
                        </button>
                        <Modal :showModal="showModal" @close-modal="closeModalAddAddress" title="New Address">
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

                    <div class="w-full p-5">
                        <div class="title-address text-center mb-3"><span class="text-xl font-semibold">Địa Chỉ</span></div>
                        <div v-for="(Address, index) in Addresses" :key="Address.id" class="flex shadow-sm justify-between items-start">
                        <div  class="flex flex-col gap-3 p-4 border-b-[1px] border-neutral-200">                           
                            <div class=" flex gap-3 items-end">                              
                                <span class="text-xl">{{ Address.fullname }}</span>
                                <span class="text-neutral-600">|</span>
                                <span class="text-neutral-600">{{ Address.telephone }}</span>
                            </div>
                            <div class="flex gap-2 items-center text-neutral-600">
                                <span >{{ Address.province.name}}</span>
                                <span><i class="bi bi-dash-lg"></i></span>
                                <span>{{ Address.district.name}}</span>
                                <span><i class="bi bi-dash-lg"></i></span>
                                <span>{{ Address.ward.name}}</span>
                            </div>
                            <div class="">
                                <span class="text-neutral-600" >{{ Address.details_address }}</span>
                            </div>
                        
                        </div>
                        <div class="p-4 flex flex-col gap-3">
                            <div @click="showModelUpdateAddress(true)" class="div_update_adr flex items-center gap-2 cursor-pointer">
                                <i class="bi bi-pencil-square text-xl "></i>
                                <span class="text-neutral-600">Cập Nhật</span>                          
                            </div>
                            <Modal :showModal="ModelUpdateAddress" @close-modal="closeModalUpdateAddress" title="Cập nhật địa chỉ">
                                
                            </Modal>
                            <div @click="deleteAddress(Address.id)" class=" div_del_adr flex items-center gap-2 cursor-pointer">
                                <i class="bi bi-x-circle text-xl"></i>
                                <span class="text-neutral-600">Xóa</span>
                            </div>
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
   function showModalAddAddressValue(value) {
    showModal.value = value;
   }
const ModelUpdateAddress = ref(false);
function showModelUpdateAddress(value) {
    ModelUpdateAddress.value = value;
}
onMounted(() => {
    fetchProvinces();
    getAddress();
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
  function closeModalAddAddress() {
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
    function closeModalUpdateAddress() {
        ModelUpdateAddress.value = false;
    }
 function saveAdress() {
    store.dispatch('addAddress', {fullName: infoAddress.fullName, phoneNumber:infoAddress.phoneNumber, addressDetail:infoAddress.addressDetail, province: selectedProvice.value,district: selectedDistrict.value,ward: selectedWard.value}).
    then( response => {
        console.log(response);
        closeModalAddAddress();
        getAddress();
    }).catch(({ response }) => {
        errMsg.value = response.data.message;
      })
 }
 const Addresses = ref({});
 function getAddress() {
    store.dispatch('getAddress').
    then(response => {
        Addresses.value = response.data.getAddress;
    })
 }
 function deleteAddress(AddressId) {
    store.dispatch('deleteAddress', AddressId).
    then(response => {
        getAddress();
        console.log(response.data);
    });
 }
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
.div_update_adr:hover i {
    transition: all 0.2s ease-in;
    transform: translateY(-2px);
    color: #fbbf24c7;
}
.div_update_adr:hover span {
    transition: all 0.2s ease-in;
    color: black;
}
.div_del_adr:hover i {
    transition: all 0.2s ease-in;
    transform: translateY(-2px);
    color: red;
}
.div_del_adr:hover span {
    transition: all 0.2s ease-in;
    color: black;
}

</style>