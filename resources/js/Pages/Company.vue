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
                                    <TableHeaderCell content="" />
                                </tr>
                            </thead>
                            <tbody class="font-normal">
                                <tr v-for="company in myCompanies" :key="company.id">
                                    <TableCell :content="company.name" />
                                    <TableCell :content="company.email" />
                                    <TableCell :content="company.website" />
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

                        <DialogModal :show="showModal">
                            <template #title>
                                Add Company
                            </template>

                            <template #content>
                                <form class="w-full max-w-md">
                                    <div class="md:flex md:items-center mb-6">
                                        <div class="md:w-1/2 text-right mr-2">
                                            <Label>Name</Label>
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
                                </form>                        
                            </template>

                            <template #footer>
                                <DangerButton class="mr-1" @click="closeModal()">Close</DangerButton>
                                <SuccessButton v-if="editMode" class="mb-1" @click="update(form)">Update</SuccessButton>
                                <SuccessButton v-else class="mb-1" @click="create(form)">Save</SuccessButton>
                            </template>
                        </DialogModal>

                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import DialogModal from '@/Jetstream/DialogModal'
    import Label from '@/Jetstream/Label'
    import Input from '@/Jetstream/Input'
    import SuccessButton from '@/Jetstream/SuccessButton'
    import DangerButton from '@/Jetstream/DangerButton'
    import SecondaryButton from '@/Jetstream/SecondaryButton'
    import AppLayout from '@/Layouts/AppLayout'
    import TableCell from '@/Pages/Components/TableCell'
    import TableHeaderCell from '@/Pages/Components/TableHeaderCell'
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
                    website: null
                },
                showModal: false,
                myCompanies: this.companies
            }
        },
        components: {
            DialogModal,
            Label,
            Input,
            AppLayout,
            TableCell,
            TableHeaderCell,
            SuccessButton,
            DangerButton,
            SecondaryButton
        },
        methods: {
            openModal: function () {
                this.showModal = true;
            },
            closeModal: function () {
                this.showModal = false;
                this.reset();
                this.editMode = false;
            },
            reset: function () {
                this.form = {
                    name: null,
                    email: null,
                }
            },
            add: function() {
                this.editMode = false;
                this.openModal();
            },
            create: function (data) {
                this.$inertia.post('/companies/create', data)
                this.myCompanies.push(data);
                this.reset();
                this.closeModal();
                this.editMode = false;
            },
            edit: function (data) {
                this.form = Object.assign({}, data);
                this.editMode = true;
                this.openModal();
            },
            update: function (data) {
                this.$inertia.post('/companies/update/' + data.id, data)

                var company = this.myCompanies.filter(obj => {
                    return obj.id === data.id
                })
                if (company.length){
                     company[0].name=data.name;
                     company[0].email=data.email;
                     company[0].website=data.website;
                }

                this.reset();
                this.closeModal();
            },
            deleteRow: function (data) {
                this.$inertia.post('/companies/delete/' + data.id, data)
                this.myCompanies = this.myCompanies.filter(function( obj ) {
                    return obj.id !== data.id;
                });
                this.reset();
                this.closeModal();
            }
        }
    }
</script>