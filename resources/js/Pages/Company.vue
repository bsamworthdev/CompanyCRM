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
                            Add New
                        </SuccessButton>

                        <table class="table-fixed w-100 border-collapse border border-green-800 w-full">
                            <thead class="font-bold">
                                <tr>
                                    <TableHeaderCell content="Name" />
                                    <TableHeaderCell content="Email" />
                                    <TableHeaderCell content="Website" />
                                    <TableHeaderCell content="Logo" />
                                    <TableHeaderCell content="" />
                                </tr>
                            </thead>
                            <tbody class="font-normal">
                                <tr v-for="company in myCompanies.data" :key="company.id">
                                    <TableCell :content="company.name" />
                                    <TableCell :content="company.email" />
                                    <TableCell :content="company.website" />
                                    <td class="border border-black-600 p-0 text-center">
                                        <img class="object-scale-down h-20 inline-block" :src="company.logo">
                                    </td>
                                    <td class="border border-black-600 p-0 text-center">
                                        <SecondaryButton class="m-1" @click="edit(company)">
                                            Edit
                                        </SecondaryButton>
                                        <DangerButton @click="deleteRow(company)">
                                            Delete
                                        </DangerButton>
                                    </td>
                                </tr>
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
                                <DangerButton class="mr-1" @click="closeModal()">Close</DangerButton>
                                <SuccessButton v-if="editMode" class="mb-1" :disabled="!form.name" @click="update(form)">Update</SuccessButton>
                                <SuccessButton v-else class="mb-1" :disabled="!form.name" @click="create(form)">Save</SuccessButton>
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