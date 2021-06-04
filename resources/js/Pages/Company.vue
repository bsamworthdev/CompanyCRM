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
                        <CustomButton class="mb-2" @click="openModal()" value="Add New" padding="2" color="green" />

                        <table class="table-fixed w-100 border-collapse border border-green-800 w-full">
                            <thead>
                                <tr>
                                    <TableCell content="Name" />
                                    <TableCell content="Phone" />
                                    <TableCell content="Website" />
                                    <TableCell content="" />
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="row in data" :key="row.id">
                                    <TableCell :content="row.name" />
                                    <TableCell :content="row.phone" />
                                    <TableCell :content="row.website" />
                                    <td class="border border-black-600 p-0 text-center">
                                        <CustomButton class="mb-1" @click="edit(row)" value="Edit" padding="1" color="blue" />
                                        <CustomButton class="mb-1" @click="deleteRow(row)" value="Delete" padding="1" color="red" />
                                    </td>
                                </tr>
                            </tbody>
                            
                        </table>

                        <div :class="['modal', { 'hidden':!showModal}]" id="modal">
                            <div class="modal-dialog">

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">New Company</h4>
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input class="form-control" required id="name" v-model="form.name"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Phone</label>
                                            <input class="form-control" required id="phone" v-model="form.phone"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Website</label>
                                            <input class="form-control" required id="phone" v-model="form.phone"/>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <CustomButton class="mb-1" @click="closeModal()" value="Close" padding="1" color="red" />
                                        <CustomButton class="mb-1" @click="save(form)" value="Save" padding="1" color="green" />
                                        <CustomButton class="mb-1" @click="update(form)" value="Update" padding="1" color="green" />
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import TableCell from '@/Pages/Components/TableCell'
    import CustomButton from '@/Pages/Components/CustomButton'
    export default {
        props: ['data'],
        data() {
            return {
                editMode: false,
                form: {
                    name: null,
                    phone: null,
                    website: null
                },
                showModal: false
            }
        },
        components: {
            AppLayout,
            TableCell,
            CustomButton
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
                    phone: null,
                }
            },
            save: function (data) {
                this.$inertia.post('/companies', data)
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
                if (!confirm('Sure')) return;
                data._method = 'PUT';
                this.$inertia.post('/companies/' + data.id, data)
                this.reset();
                this.closeModal();
            },
            deleteRow: function (data) {
                if (!confirm('Sure')) return;
                data._method = 'DELETE';
                this.$inertia.post('/companies/' + data.id, data)
                this.reset();
                this.closeModal();
            }
        }
    }
</script>