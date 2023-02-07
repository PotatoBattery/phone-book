<template>
    <Head title="Список контактов" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Список контактов</h2>
            <input v-model="searchQuery" type="text" id="searchLine" placeholder="Поиск по контактам" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
        </template>
        <div class="flex flex-col">
            <div class="overflow-x-auto w-full m-auto">
                <div class="py-4 inline-block w-full sm:px-6 lg:px-8 ">
                    <div class="overflow-hidden">
                        <table class="w-full text-center">
                            <thead class="border-b bg-gray-800">
                                <tr>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                        Фамилия
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                        Имя
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                        Отчество
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                        Номер(-а) телефона
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b" v-if="isEmpty">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center" colspan="5">
                                        Контакты в Вашей телефонной книге отсутствуют, <a :href="route('create.contact')" class="add-contact-link">добавьте</a> свой первый контакт, прямо сейчас!
                                    </td>
                                </tr>
                                <tr class="bg-white border-b" v-for="contact in contacts" v-else>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        {{ contact.lastName }}
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        {{ contact.firstName }}
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        {{ contact.secondName }}
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        <ul>
                                            <li v-for="number in contact.numbers">
                                                {{ number.value }}
                                            </li>
                                        </ul>
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        <a :href="route('show.contact', contact.id)" class="
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
                                              ease-in-out">Просмотр</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
    export default {
        name: 'Dashboard',
        data(){
            return {
                contacts: [],
                isEmpty: false,
                searchQuery: '',
                timer: null
            }
        },
        mounted() {
            this.getContacts();
        },
        methods: {
            getContacts(){
                window.axios.get(`/api/v1/phone-book/contacts?searchQuery=${this.searchQuery}`)
                    .then(response => {
                        if(response.status === 204){
                            this.isEmpty = true;
                        }
                        if(response.status === 200){
                            this.isEmpty = false;
                            this.contacts = response.data;
                        }
                    })
                    .catch(errors => {
                        console.log(errors);
                    })
            }
        },
        watch: {
            searchQuery: function(){
                if(this.searchQuery.length !== 0 && this.searchQuery !== ''){
                    if(this.timer){
                        clearTimeout(this.timer)
                    }
                    let sleep = 0;
                    switch (this.searchQuery.length){
                        case 1:
                            sleep = 1000;
                            break;
                        case 2:
                        case 3:
                            sleep = 700;
                            break;
                        case 4:
                        case 5:
                            sleep = 500;
                            break;
                        default:
                            sleep = 300;
                    }
                    this.timer = setTimeout(() => {
                        this.getContacts();
                    }, sleep);
                }else{
                    this.getContacts();
                }
            }
        }
    }
</script>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<style scoped>
    .add-contact-link{
        color: dodgerblue;
    }
</style>
