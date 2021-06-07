<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Companies
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
                                    <TableHeaderCell content="Name" />
                                    <TableHeaderCell content="Email" />
                                    <TableHeaderCell content="Website" />
                                    <TableHeaderCell content="Logo" />
                                    <TableHeaderCell content="" />
                                </tr>
                            </thead>
                            <tbody class="font-normal" v-if="myCompanies.data.length">
                                <tr v-for="company in myCompanies.data" :key="company.id">
                                    <TableCell :content="company.name" />
                                    <TableCell :content="company.email" />
                                    <TableCell :content="company.website" />
                                    <td class="border border-black-600 p-0 text-center">
                                        <img class="object-scale-down h-20 inline-block" :src="company.logo">
                                    </td>
                                    <td class="border border-black-600 p-0 text-center whitespace-nowrap">
                                        <SecondaryButton class="m-1" @click="edit(company)">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                            Edit
                                        </SecondaryButton>
                                        <DangerButton @click="deleteRow(company)">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Delete
                                        </DangerButton>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else class="border-none">
                                <i>No companies</i>
                            </tbody>
                            
                        </table>
                        <Pagination class="mt-6" :links="myCompanies.links" />

                        <DialogModal :show="showModal">
                            <template #title>
                                Add Company
                            </template>

                            <template #content>
                                <form class="w-full max-w-md">
                                    <div class="md:flex md:items-center mb-6">
                                        <div class="md:w-1/2 text-right mr-2">
                                            <Label>
                                                Name <span class="required">*</span>
                                            </Label>
                                        </div>
                                        <div class="md:w-1/2">
                                            <Input id="name" v-model="form.name"/>
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
                                            <Label>Website</Label>
                                        </div>
                                        <div class="md:w-1/2">
                                            <Input id="website" v-model="form.website"/>
                                        </div>
                                    </div>
                                    <div class="md:flex md:items-center mb-6">
                                        <div class="md:w-1/2 text-right mr-2">
                                            <Label>Logo</Label>
                                        </div>
                                        <div class="md:w-1/2">
                                            <img class="object-scale-down h-50 mb-1" :src="form.logo">
                                            <Input id="Logo" hidden v-model="form.logo"/>
                                            <DangerButton v-show="form.logo" class="mr-1" id="clearLogoButton" @click="clearLogo">
                                                Clear
                                            </DangerButton>
                                            <form @submit="formSubmit" enctype="multipart/form-data">
                                                <input type="file" class=" " v-on:change="onChange">
                                            </form>
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
                                <SuccessButton v-if="editMode" class="mb-1" :disabled="!form.name" @click="update(form)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                    </svg>
                                    Update
                                </SuccessButton>
                                <SuccessButton v-else class="mb-1" :disabled="!form.name" @click="create(form)">
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
    #clearLogoButton{
        position: absolute;
        margin-top: -40px;
        margin-left: 66px;
        opacity: 0.1;
    }
    #clearLogoButton:hover{
        opacity:1;
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
            companies: String
        },
        data() {
            return {
                editMode: false,
                form: {
                    name: null,
                    email: null,
                    website: null,
                    logo: null
                },
                showModal: false,
                myCompanies: this.companies,
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
            clearLogo: function(){
                this.form.logo = null;
            },
            reset: function () {
                this.form = {
                    name: null,
                    email: null,
                    website: null,
                    logo: null
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
                if (this.validate(data)){;
                    this.$inertia.post('/companies/create', data, {
                        onSuccess: () => {
                            this.closeModal();
                            location.reload();
                        }
                    });
                    // this.myCompanies.push(data);
                    // this.closeModal();
                    // this.editMode = false;
                }
            },
            validate: function(data){
                this.resetErrors();
                if (!data.name) {
                    this.errors.push("Name required.");
                }
                if (data.email && !this.validEmail(data.email)) {
                    this.errors.push('Not a valid email format.');
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
                    this.$inertia.post('/companies/update/' + data.id, data, {
                         onSuccess: () => {
                            this.closeModal();
                            location.reload();
                        }
                    });

                    // var company = this.myCompanies.filter(obj => {
                    //     return obj.id === data.id
                    // })
                    // if (company.length){
                    //     company[0].name=data.name;
                    //     company[0].email=data.email;
                    //     company[0].website=data.website;
                    // }
                    // this.closeModal();
                }
            },
            deleteRow: function (data) {
                this.$inertia.post('/companies/delete/' + data.id, data, {
                        onSuccess: () => {
                            this.closeModal();
                            location.reload();
                        }
                    });
                // this.myCompanies = this.myCompanies.filter(function( obj ) {
                //     return obj.id !== data.id;
                // });
                // this.closeModal();
            },
            onChange(e) {
                this.file = e.target.files[0];
                this.formSubmit(e);
            },
            formSubmit(e) {
                e.preventDefault();
                var _this = this;

                _this.resetErrors();
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }

                let data = new FormData();
                data.append('file', this.file);

                axios.post('/upload', data, config)
                    .then(function (res) {
                        _this.form.logo = '/storage/uploads/' + res.data.fileName;
                        _this.success = res.data.success;
                    })
                    .catch(function (err) {
                        _this.form.logo = null;
                        _this.errors.push("Invalid file: Must be png image with minimum dimensions 100 x 100 px.");
                    });
            }
        }
    }
</script>