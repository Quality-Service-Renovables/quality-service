<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
</script>

<template>
    <Toaster position="top-right" richColors :visibleToasts="10" />

    <Head title="Clientes" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl  leading-tight">Clientes</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <v-card>
                        <v-row>
                            <v-col cols="12" sm="12">
                                <v-data-table :headers="headers" :items="customers" fixed-header :search="search" :mobile="isMobile()"
                                    mobile>
                                    <template v-slot:item.logo="{ item }">
                                        <v-avatar v-if="item.logo" :image="'../../' + item.logo" size="40"
                                            class="ma-1 avatar" @click="showImage(item)"></v-avatar>
                                        <v-avatar v-else color="secondary">
                                            <v-icon icon="mdi-account-circle"></v-icon>
                                        </v-avatar>
                                    </template>
                                    <template v-slot:item.active="{ value }">
                                        <v-icon :color="getColor(value)">mdi-circle-slice-8</v-icon>
                                    </template>
                                    <template v-slot:item.address="{ item }">
                                        <p>{{ item.address }}, {{ item.zip_code }}</p>
                                    </template>
                                    <template v-slot:item.phone="{ item }">
                                        <p>Celular:{{ item.phone }}</p>
                                        <p>Oficina:{{ item.phone_office }}</p>
                                    </template>
                                    <template v-slot:item.open_time="{ item }">
                                        {{ item.office_days }}
                                        <small>{{ formatTime(item.open_time) }} - {{ formatTime(item.close_time)
                                            }}</small>
                                    </template>
                                    <template v-slot:top>
                                        <v-toolbar flat>
                                            <v-toolbar-title class="ml-1">
                                                <v-text-field v-model="search" label="Buscar" hide-details
                                                    variant="solo" append-inner-icon="mdi-magnify"
                                                    density="compact"></v-text-field>
                                            </v-toolbar-title>
                                            <v-divider class="mx-4" inset vertical></v-divider>
                                            <v-spacer></v-spacer>
                                            <v-dialog v-model="dialog" v-if="hasPermissionTo('clients.create') || hasPermissionTo('clients.update')">
                                                <template v-slot:activator="{ props }" v-if="hasPermissionTo('clients.create')">
                                                    <v-btn class="mb-2" color="primary" dark v-bind="props"
                                                        icon="mdi-plus"></v-btn>
                                                </template>
                                                <v-card>
                                                    <v-card-title>
                                                        <span class="text-h5">{{ formTitle }}</span>
                                                    </v-card-title>

                                                    <v-card-text>
                                                        <v-container>
                                                            <v-row>
                                                                <v-col cols="12" md="4">
                                                                    <v-file-input variant="solo" label="Imagen"
                                                                        v-model="editedItem.logo"
                                                                        accept="image/*" prepend-icon="" prepend-inner-icon="mdi-image-plus" hide-details></v-file-input>
                                                                </v-col>
                                                                <v-col cols="12" md="4">
                                                                    <v-text-field v-model="editedItem.client"
                                                                        label="Cliente" hide-details
                                                                        variant="solo"></v-text-field>
                                                                </v-col>

                                                                <v-col cols="12" md="4">
                                                                    <v-text-field v-model="editedItem.legal_name"
                                                                        label="Nombre fiscal" hide-details
                                                                        variant="solo"></v-text-field>
                                                                </v-col>

                                                                <v-col cols="12" md="4">
                                                                    <v-textarea v-model="editedItem.address"
                                                                        label="Dirección" hide-details variant="solo"
                                                                        rows="1"></v-textarea>
                                                                </v-col>
                                                                <v-col cols="12" md="4">
                                                                    <v-text-field v-model="editedItem.zip_code"
                                                                        label="C.P." hide-details variant="solo"
                                                                        type="number"></v-text-field>
                                                                </v-col>

                                                                <v-col cols="12" md="4">
                                                                    <v-text-field v-model="editedItem.phone"
                                                                        label="Teléfono" hide-details variant="solo"
                                                                        type="phone"></v-text-field>
                                                                </v-col>

                                                                <v-col cols="12" md="4">
                                                                    <v-text-field v-model="editedItem.phone_office"
                                                                        label="Teléfono oficina" hide-details
                                                                        variant="solo" type="phone"></v-text-field>
                                                                </v-col>

                                                                <v-col cols="12" md="4">
                                                                    <v-text-field v-model="editedItem.office_days"
                                                                        label="Días de oficina" hide-details
                                                                        variant="solo"></v-text-field>
                                                                </v-col>

                                                                <v-col cols="12" md="4">
                                                                    <v-text-field v-model="editedItem.open_time"
                                                                        label="Hora de apertura" hide-details
                                                                        variant="solo" type="time"></v-text-field>
                                                                </v-col>

                                                                <v-col cols="12" md="4">
                                                                    <v-text-field v-model="editedItem.close_time"
                                                                        label="Hora de cierre" hide-details
                                                                        variant="solo" type="time"></v-text-field>
                                                                </v-col>

                                                                <v-col cols="12" md="4">
                                                                    <v-text-field v-model="editedItem.website"
                                                                        label="Website" hide-details
                                                                        variant="solo"></v-text-field>
                                                                </v-col>

                                                                <v-col cols="12" md="4">
                                                                    <v-text-field v-model="editedItem.email"
                                                                        label="Email" hide-details type="email"
                                                                        variant="solo"></v-text-field>
                                                                </v-col>

                                                                <v-col cols="12" md="4">
                                                                    <v-switch label="Activo" v-model="editedItem.active"
                                                                        color="primary"></v-switch>
                                                                </v-col>
                                                            </v-row>
                                                        </v-container>
                                                    </v-card-text>

                                                    <v-card-actions>
                                                        <v-spacer></v-spacer>
                                                        <v-btn color="blue-darken-1" variant="text" @click="close">
                                                            Cancelar
                                                        </v-btn>
                                                        <v-btn color="blue-darken-1" variant="text" @click="save">
                                                            Guardar
                                                        </v-btn>
                                                    </v-card-actions>
                                                </v-card>
                                            </v-dialog>
                                            <v-dialog v-model="dialogDelete" max-width="500px">
                                                <v-card>
                                                    <v-card-title class="text-h5 text-center">¿Estás seguro de
                                                        eliminar?</v-card-title>
                                                    <v-card-actions>
                                                        <v-spacer></v-spacer>
                                                        <v-btn color="blue-darken-1" variant="text"
                                                            @click="closeDelete">Cancel</v-btn>
                                                        <v-btn color="blue-darken-1" variant="text"
                                                            @click="deleteItemConfirm(editedItem.client_uuid)">Si,
                                                            eliminar</v-btn>
                                                        <v-spacer></v-spacer>
                                                    </v-card-actions>
                                                </v-card>
                                            </v-dialog>
                                        </v-toolbar>
                                    </template>
                                    <template v-slot:item.actions="{ item }">
                                        <v-icon class="me-2" size="small" @click="editItem(item)" v-if="hasPermissionTo('clients.update')">
                                            mdi-pencil
                                        </v-icon>
                                        <v-icon size="small" @click="deleteItem(item)" v-if="hasPermissionTo('clients.delete')">
                                            mdi-delete
                                        </v-icon>
                                    </template>
                                </v-data-table>
                            </v-col>
                        </v-row>
                    </v-card>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>

<script>
import { router } from '@inertiajs/vue3'
import { Toaster, toast } from 'vue-sonner'
import Swal from 'sweetalert2';
import moment from 'moment';

export default {
    components: {
        Toaster,
    },
    props: {
        customers: {
            type: Array,
            required: true
        }
    },
    data: () => ({
        search: '',
        dialog: false,
        dialogDelete: false,
        headers: [
            { title: '', key: 'logo', sortable: false },
            { title: 'Cliente', key: 'client' },
            { title: 'Nombre fiscal', key: 'legal_name', minWidth: '200' },
            { title: 'Dirección', key: 'address', minWidth: '200' },
            { title: 'Tels.', value: 'phone', minWidth: '200' },
            { title: 'Horario', key: 'open_time', align: 'center', minWidth: '150' },
            { title: 'Website', key: 'website' },
            { title: 'Email', key: 'email' },
            { title: 'Activo', key: 'active' },
            { title: 'Actions', key: 'actions', sortable: false }
        ],
        editedIndex: -1,
        editedItem: {
            client_uuid: '',
            client: '',
            logo: null,
            legal_name: '',
            address: '',
            zip_code: '',
            phone: '',
            phone_office: '',
            open_time: '',
            close_time: '',
            office_days: '',
            website: '',
            email: '',
            active: false
        },
        defaultItem: {
            client_uuid: '',
            client: '',
            logo: null,
            legal_name: '',
            address: '',
            zip_code: '',
            phone: '',
            phone_office: '',
            open_time: '',
            close_time: '',
            office_days: '',
            website: '',
            email: '',
            active: false
        }
    }),
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Nueva cliente' : 'Editar cliente'
        },
    },
    watch: {
        dialog(val) {
            val || this.close()
        },
        dialogDelete(val) {
            val || this.closeDelete()
        },
    },
    methods: {
        editItem(item) {
            this.editedIndex = this.customers.indexOf(item)
            item.active = item.active == "1" ? true : false
            this.editedItem = Object.assign({}, item)
            this.editedItem.logo = null
            this.dialog = true
        },
        deleteItem(item) {
            this.editedIndex = this.customers.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },
        deleteItemConfirm(item) {
            this.customers.splice(this.editedIndex, 1)
            const putRequest = () => {
                return axios.delete('api/clients/' + item);
            };
            toast.promise(putRequest, {
                loading: 'Procesando...',
                success: (data) => {
                    this.closeDelete()
                    return 'Cliente eliminado correctamente';
                },
                error: (data) => {
                    this.handleErrors(data);
                }
            });
        },
        close() {
            this.dialog = false
            this.$nextTick(() => {
                console.log("Cambiando estatus en close");
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },
        closeDelete() {
            this.dialogDelete = false
            this.$nextTick(() => {
                console.log("Cambiando estatus en closeDelete");
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },
        save() {
            let formData = {
                client: this.editedItem.client,
                logo_store: this.editedItem.logo,
                legal_name: this.editedItem.legal_name,
                address: this.editedItem.address,
                zip_code: this.editedItem.zip_code,
                phone: this.editedItem.phone,
                phone_office: this.editedItem.phone_office,
                open_time: moment(this.editedItem.open_time, 'HH:mm:ss').format('HH:mm'),
                close_time: moment(this.editedItem.close_time, 'HH:mm:ss').format('HH:mm'),
                office_days: this.editedItem.office_days,
                website: this.editedItem.website,
                email: this.editedItem.email,
                active: this.editedItem.active ? 1 : 0
            };

            if (this.editedIndex > -1) {
                const putRequest = () => {
                    return axios.post('api/clients/update/' + this.editedItem.client_uuid, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    });
                };
                toast.promise(putRequest(), {
                    loading: 'Procesando...',
                    success: (data) => {
                        this.$inertia.reload()
                        this.close()
                        return 'Cliente actualizado correctamente';
                    },
                    error: (data) => {
                        this.handleErrors(data);
                    }
                });
            } else {
                this.customers.push(this.editedItem)
                const postRequest = () => {
                    return axios.post('api/clients', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    });
                };

                toast.promise(postRequest(), {
                    loading: 'Procesando...',
                    success: (data) => {
                        this.$inertia.reload()
                        this.close()
                        return 'Cliente creado correctamente';
                    },
                    error: (data) => {
                        this.handleErrors(data);
                    }
                });
            }
        },
        getColor(value) {
            return value ? 'green' : 'red';
        },
        formatTime(time) {
            return moment(time, 'HH:mm:ss').format('hh:mm A');
        },
        showImage(item) {
            window.open('../' + item.logo, '_blank');
        },
    },

}
</script>
