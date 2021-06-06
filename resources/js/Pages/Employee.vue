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
                            Add New
                        </SuccessButton>

                        <table class="table-fixed w-100 border-collapse border border-green-800 w-full">
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
                            <tbody class="font-normal">
                                <tr v-for="employee in myEmployees.data" :key="employee.id">
                                    <TableCell :content="employee.first_name" />
                                    <TableCell :content="employee.last_name" />
                                    <TableCell hidden :content="employee.company" />
                                    <TableCell :content="getCompanyName(employee.company)" />
                                    <TableCell :content="employee.email" />
                                    <TableCell :content="employee.phone" />
                                    <td class="border border-black-600 p-0 text-center">
                                        <SecondaryButton class="m-1" @click="edit(employee)">
                                            Edit
                                        </SecondaryButton>
                                        <DangerButton @click="deleteRow(employee)">
                                            Delete
                                        </DangerButton>
                                    </td>
                                </tr>
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
                                <DangerButton class="mr-1" @click="closeModal()">Close</DangerButton>
                                <SuccessButton v-if="editMode" class="mb-1" :disabled="!form.first_name || !form.last_name" @click="update(form)">Update</SuccessButton>
                                <SuccessButton v-else class="mb-1" :disabled="!form.first_name || !form.last_name" @click="create(form)">Save</SuccessButton>
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