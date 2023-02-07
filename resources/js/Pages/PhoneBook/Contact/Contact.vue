<template>
    <Head title="Посмотреть контакт" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Просмотр контакта</h2>
        </template>
        <div class="block p-6 rounded-lg shadow-lg bg-white max-w-md m-auto mt-32">
            <a :href="route('dashboard')">К списку контактов</a>
            <div class="form-check float-right">
                <input v-on:click="changeFavorite" class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox" :checked="contact.favorite" id="flexCheckDefault">
                <label class="form-check-label inline-block text-gray-800" for="flexCheckDefault">
                    Избранный
                </label>
            </div>
            <hr class="mb-5 mt-5">
            <div class="form-group mb-6">
                <label for="lastName">Фамилия</label>
                <input type="text" readonly id="lastName" v-model="contact.lastName" class="form-control block
                        w-full
                        px-3
                        py-1.5
                        text-base
                        font-normal
                        text-gray-700
                        bg-white bg-clip-padding
                        border border-solid border-gray-300
                        rounded
                        transition
                        ease-in-out
                        m-0
                        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                       placeholder="Укажите фамилию">
            </div>
            <div class="form-group mb-6">
                <label for="firstName">Имя</label>
                <input type="text" readonly id="firstName" v-model="contact.firstName" class="form-control block
                        w-full
                        px-3
                        py-1.5
                        text-base
                        font-normal
                        text-gray-700
                        bg-white bg-clip-padding
                        border border-solid border-gray-300
                        rounded
                        transition
                        ease-in-out
                        m-0
                        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="Укажите имя">
            </div>
            <div class="form-group mb-6">
                <label for="secondName">Отчество</label>
                <input type="text" readonly id="secondName" v-model="contact.secondName" class="form-control block
                        w-full
                        px-3
                        py-1.5
                        text-base
                        font-normal
                        text-gray-700
                        bg-white bg-clip-padding
                        border border-solid border-gray-300
                        rounded
                        transition
                        ease-in-out
                        m-0
                        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                       placeholder="Укажите отчество (если имеется)">
            </div>
            <div class="form-group mb-6" v-for="(number, index) in contact.numbers">
                <span :key="index">
                    <label :for="'number-'+index">Номер телефона</label>
                    <input type="text" readonly :id="'number-'+index" v-model="number.value" class="form-control block
                            w-full
                            px-3
                            py-1.5
                            text-base
                            font-normal
                            text-gray-700
                            bg-white bg-clip-padding
                            border border-solid border-gray-300
                            rounded
                            transition
                            ease-in-out
                            m-0
                            focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                           placeholder="Укажите номер телефона">
                    </span>
            </div>
            <button v-on:click="removeContact" class="
                      w-1/2
                      px-6
                      py-2.5
                      bg-red-600
                      text-white
                      font-medium
                      text-xs
                      leading-tight
                      uppercase
                      rounded
                      shadow-md
                      hover:bg-red-700 hover:shadow-lg
                      focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0
                      active:bg-red-800 active:shadow-lg
                      transition
                      duration-150
                      ease-in-out">Удалить</button>
            <a :href="route('edit.contact', contactId)" class="
                      ml-11
                      w-1/2
                      px-6
                      py-2.5
                      bg-blue-600
                      text-white
                      font-medium
                      text-xs
                      leading-tight
                      uppercase
                      rounded
                      shadow-md
                      hover:bg-blue-700 hover:shadow-lg
                      focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0
                      active:bg-blue-800 active:shadow-lg
                      transition
                      duration-150
                      ease-in-out">Редактировать</a>
        </div>
    </AuthenticatedLayout>
</template>

<script>

export default {
    name: "Contact",
    props: {
        contactId: Number
    },
    data(){
        return {
            contact: {}
        }
    },
    mounted() {
        this.getContact()
    },
    methods: {
        getContact() {
            window.axios.get(`/api/v1/phone-book/contacts/${this.contactId}`)
                .then(response => {
                    this.contact = response.data;
                })
                .catch(errors => {
                    console.log(errors);
                });
        },
        changeFavorite(){
          window.axios.patch(`/api/v1/phone-book/contacts/favorite/${this.contactId}`, {
              favorite: this.contact.favorite
          })
              .then(response => {
                  if(response.status === 200){
                      this.getContact();
                  }
              })
              .catch(errors => {
                  console.log(errors);
              })
        },
        removeContact() {
            window.axios.delete(`/api/v1/phone-book/contacts/${this.contact.id}`)
                .then(response => {
                    if(response.status === 200){
                        window.location.replace('/phone-book/dashboard');
                    }
                })
                .catch(errors => {
                    console.log(errors);
                })
        }
    }
}
</script>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

</script>

<style scoped>

</style>
