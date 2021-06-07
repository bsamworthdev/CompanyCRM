<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Employees
            </h2>
        </template>

        <div class="py-12 p-6 border-t border-gray-200">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="col-md-6 p-6">
                        <SuccessButton class="mb-2" @click="add()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add New
                        </SuccessButton>

                        <table class="table-auto w-100 border-collapse border border-black-800 w-full">
                            <thead class="font-bold">
                                <tr>
                                    <TableHeaderCell content="First Name" />
                                    <TableHeaderCell content="Last Name" />
                                    <TableHeaderCell hidden content="Company ID" />
                                    <TableHeaderCell content="Company" />
                                    <TableHeaderCell content="Email" />
                                    <TableHeaderCell content="Phone" />
                                    <TableHeaderCell content="" />
                                </tr>
                            </thead>
                            <tbody class="font-normal" v-if="myEmployees.data.length">
                                <tr v-for="employee in myEmployees.data" :key="employee.id">
                                    <TableCell :content="employee.first_name" />
                                    <TableCell :content="employee.last_name" />
                                    <TableCell hidden :content="employee.company" />
                                    <TableCell :content="getCompanyName(employee.company)" />
                                    <TableCell :content="employee.email" />
                                    <TableCell :content="employee.phone" />
                                    <td class="border border-black-600 p-0 text-center whitespace-nowrap">
                                        <SecondaryButton class="m-1" @click="edit(employee)">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                            Edit
                                        </SecondaryButton>
                                        <DangerButton @click="deleteRow(employee)">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Delete
                                        </DangerButton>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else class="border-none">
                                <i>No employees</i>
                            </tbody>
                            
                        </table>
                        <Pagination class="mt-6" :links="myEmployees.links" />

                        <DialogModal :show="showModal">
                            <template #title>
                                Add Employee
                            </template>

                            <template #content>
                                <form class="w-full max-w-md">
                                    <div class="md:flex md:items-center mb-6">
                                        <div class="md:w-1/2 text-right mr-2">
                                            <Label>
                                                First Name <span class="required">*</span>
                                            </Label>
                                            
                                        </div>
                                        <div class="md:w-1/2">
                                            <Input id="first_name" v-model="form.first_name"/>
                                        </div>
                                    </div>
                                    <div class="md:flex md:items-center mb-6">
                                        <div class="md:w-1/2 text-right mr-2">
                                            <Label>
                                                Last Name <span class="required">*</span>
                                            </Label>
                                           
                                        </div>
                                        <div class="md:w-1/2">
                                            <Input id="last_name" v-model="form.last_name"/>
                                        </div>
                                    </div>
                                    <div class="md:flex md:items-center mb-6">
                                        <div class="md:w-1/2 text-right mr-2">
                                            <Label>Company</Label>
                                        </div>
                                        <div class="md:w-1/2">
                                            <select v-model="form.company" class="w-24 p-1 min-w-full border-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                                <option value="">Please Select</option>
                                                <option v-for="company in companies" :value="company.id" :key="company.id">
                                                    {{ company.name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="md:flex md:items-center mb-6">
                                        <div class="md:w-1/2 text-right mr-2">
                                            <Label>Email</Label>
                                        </div>
                                        <div class="md:w-1/2">
                                            <Input id="email" v-model="form.email"/>
                                        </div>
                                    </div>
                                    <div class="md:flex md:items-center mb-6">
                                        <div class="md:w-1/2 text-right mr-2">
                                            <Label>Phone</Label>
                                        </div>
                                        <div class="md:w-1/2">
                                            <Input id="phone" v-model="form.phone"/>
                                        </div>
                                    </div>
                                    <div class="md:flex md:items-center mb-6">
                                        <div class="md:w-1/2 text-right mr-2">
                                        </div>
                                        <div class="md:w-1/2">
                                            <InputError :errors="errors"/>
                                        </div>
                                    </div>
                                </form>                        
                            </template>

                            <template #footer>
                                <DangerButton class="mr-1" @click="closeModal()">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Close
                                </DangerButton>
                                <SuccessButton v-if="editMode" class="mb-1" :disabled="!form.first_name || !form.last_name" @click="update(form)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                    </svg>
                                    Update
                                </SuccessButton>
                                <SuccessButton v-else class="mb-1" :disabled="!form.first_name || !form.last_name" @click="create(form)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                    </svg>
                                    Save
                                </SuccessButton>
                            </template>
                        </DialogModal>

                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<style scoped>
    .required{
        color:red;
    }
</style>

<script>
    import DialogModal from '@/Jetstream/DialogModal'
    import Label from '@/Jetstream/Label'
    import Input from '@/Jetstream/Input'
    import InputError from '@/Jetstream/InputError'
    import SuccessButton from '@/Jetstream/SuccessButton'
    import DangerButton from '@/Jetstream/DangerButton'
    import SecondaryButton from '@/Jetstream/SecondaryButton'
    import AppLayout from '@/Layouts/AppLayout'
    import TableCell from '@/Pages/Components/TableCell'
    import TableHeaderCell from '@/Pages/Components/TableHeaderCell'
    import Pagination from '@/Pages/Components/Pagination'
    export default {
        props: {
            employees: Object,
            companies: Array
        },
        data() {
            return {
                editMode: false,
                form: {
                    first_name: null,
                    last_name: null,
                    company: "",
                    email: null,
                    phone: null
                },
                showModal: false,
                myEmployees: this.employees,
                errors: []
            }
        },
        components: {
            DialogModal,
            Label,
            Input,
            InputError,
            AppLayout,
            TableCell,
            TableHeaderCell,
            SuccessButton,
            DangerButton,
            SecondaryButton,
            Pagination
        },
        methods: {
            openModal: function () {
                this.showModal = true;
            },
            closeModal: function () {
                this.showModal = false;
                this.reset();
                this.resetErrors();
                this.editMode = false;
            },
            reset: function () {
                this.form = {
                    first_name: null,
                    last_name: null,
                    company: "",
                    email: null,
                    phone: null
                }
            },
            resetErrors: function(){
                this.errors = [];
            },
            add: function() {
                this.editMode = false;
                this.openModal();
            },
            create: function (data) {
                if (this.validate(data)){
                    this.$inertia.post('/employees/create', data, {
                        onSuccess: () => {
                            this.closeModal();
                            location.reload();
                        },
                    });
                }
            },
            validate: function(data){
                this.resetErrors();
                if (!data.first_name) {
                    this.errors.push("First Name required.");
                }
                if (!data.last_name) {
                    this.errors.push("First Name required.");
                }
                if (data.email && !this.validEmail(data.email)) {
                    this.errors.push('Not a valid email format');
                }
                if (data.phone && isNaN(data.phone)) {
                    this.errors.push('Not a valid phone number');
                }
                return this.errors.length==0;
            },
            validEmail: function (email) {
                var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            },
            edit: function (data) {
                this.form = Object.assign({}, data);
                this.editMode = true;
                this.openModal();
            },
            update: function (data) {
                if (this.validate(data)){
                    this.$inertia.post('/employees/update/' + data.id, data, {
                        onSuccess: () => {
                            this.closeModal();
                            location.reload();
                        },
                    });

                    // var employee = this.myEmployees.filter(obj => {
                    //     return obj.id === data.id
                    // })
                    // if (employee.length){
                    //     employee[0].first_name=data.first_name;
                    //     employee[0].last_name=data.last_name;
                    //     employee[0].company=data.company;
                    //     employee[0].email=data.email;
                    //     employee[0].phone=data.phone;
                    // }
                    // this.closeModal();
                }
            },
            deleteRow: function (data) {
                this.$inertia.post('/employees/delete/' + data.id, data, {
                        onSuccess: () => {
                            this.closeModal();
                            location.reload();
                        },
                });
                // this.myEmployees = this.myEmployees.filter(function( obj ) {
                //     return obj.id !== data.id;
                // });
                // this.closeModal();
            },
            getCompanyName: function(id){
                var companies = this.companies.filter(obj => {
                    return obj.id === id
                })
                if (companies.length) {
                    return companies[0].name;
                } else {
                    return '';
                }
            }
        }
    }
</script>