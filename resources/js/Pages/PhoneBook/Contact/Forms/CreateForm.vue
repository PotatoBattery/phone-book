<template>
    <Head title="Добавить контакт" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Создание контакта</h2>
        </template>
        <div class="block p-6 rounded-lg shadow-lg bg-white max-w-md m-auto mt-32">
            <div class="form-group mb-6">
                <label for="lastName">Фамилия</label>
                <input type="text" id="lastName" v-model="contact.lastName" class="form-control block
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
                <InputError class="mt-2" :message="errors.lastName" />

            </div>
            <div class="form-group mb-6">
                <label for="firstName">Имя</label>
                <input type="text" id="firstName" v-model="contact.firstName" class="form-control block
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
                <InputError class="mt-2" :message="errors.firstName" />
            </div>
            <div class="form-group mb-6">
                <label for="secondName">Отчество</label>
                <input type="text" id="secondName" v-model="contact.secondName" class="form-control block
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
                    <label :for="'number-'+index">Номер телефона</label><a v-if="index !== 0" v-on:click="removeNumber(index)" class="remove-number-link">Удалить номер</a>
                    <input type="text" :id="'number-'+index" v-model="number.value" class="form-control block
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
            <button v-on:click="addNumber" class="
                  mb-2
                  w-full
                  px-6
                  py-2.5
                  bg-green-600
                  text-white
                  font-medium
                  text-xs
                  leading-tight
                  uppercase
                  rounded
                  shadow-md
                  hover:bg-green-700 hover:shadow-lg
                  focus:bg-green-700 focus:shadow-lg focus:outline-none focus:ring-0
                  active:bg-green-800 active:shadow-lg
                  transition
                  duration-150
                  ease-in-out">Добавить номер</button>
            <button v-on:click="addContact" class="
                      w-full
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
                      ease-in-out">Добавить контакт</button>
        </div>
    </AuthenticatedLayout>
</template>

<script>
export default {
    name: "CreateForm",
    data(){
        return {
            contact: {
                firstName: '',
                secondName: '',
                lastName: '',
                numbers: [
                    {
                        value: ''
                    }
                ]
            },
            errors: {
                firstName: '',
                lastName: ''
            }
        }
    },
    methods: {
        addNumber(){
            this.contact.numbers.push({value: ''});
        },
        removeNumber(index){
            this.contact.numbers.splice(index, 1)
        },
        addContact()
        {
            this.errors = {firstName: '', lastName: ''};
            window.axios.post('/api/v1/phone-book/contacts', {
                firstName: this.contact.firstName,
                secondName: this.contact.secondName,
                lastName: this.contact.lastName,
                numbers: this.contact.numbers,
            })
                .then(response => {
                    if(response.status === 201){
                        let contactId = response.data.id
                        window.location.replace(`/phone-book/contact/${contactId}`);
                    }
                })
                .catch(errors => {
                    this.errors.firstName = errors.response.data.errors.hasOwnProperty('firstName') ? errors.response.data.errors.firstName[0] : '';
                    this.errors.lastName = errors.response.data.errors.hasOwnProperty('lastName') ? errors.response.data.errors.lastName[0] : '';
                })
        }
    }
}
</script>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
</script>

<style scoped>
    .remove-number-link{
        color: red;
        cursor: pointer;
        float: right;
    }
</style>
