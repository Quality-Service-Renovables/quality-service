<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
</script>

<template>
    <Toaster position="top-right" richColors :visibleToasts="10" />

    <Head title="Modelos" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl  leading-tight">Modelos</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <v-card>
                        <v-row>
                            <v-col cols="12" sm="12">
                                <v-data-table :headers="headers" :items="models" fixed-header :search="search" :mobile="isMobile()">
                                    <template v-slot:item.active="{ value }">
                                        <v-icon :color="getColor(value)">mdi-circle-slice-8</v-icon>
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
                                            <v-dialog v-model="dialog" max-width="500px" v-if="hasPermissionTo('models.create') || hasPermissionTo('models.update')">
                                                <template v-slot:activator="{ props }" v-if="hasPermissionTo('models.create')">
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
                                                                <v-col cols="12">
                                                                    <v-text-field v-model="editedItem.trademark_model"
                                                                        label="Nombre" variant="solo"
                                                                        hide-details></v-text-field>
                                                                </v-col>
                                                                <v-col cols="12">
                                                                    <v-select v-model="editedItem.trademark_code"
                                                                        :items="trademarks" item-title="trademark"
                                                                        item-value="trademark_code" label="Marca"
                                                                        variant="solo" hide-details></v-select>
                                                                </v-col>
                                                                <v-col cols="12">
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
                                                            @click="deleteItemConfirm(editedItem.trademark_model_uuid)">Si,
                                                            eliminar</v-btn>
                                                        <v-spacer></v-spacer>
                                                    </v-card-actions>
                                                </v-card>
                                            </v-dialog>
                                        </v-toolbar>
                                    </template>
                                    <template v-slot:item.actions="{ item }">
                                        <v-icon class="me-2" size="small" @click="editItem(item)" v-if="hasPermissionTo('models.update')">
                                            mdi-pencil
                                        </v-icon>
                                        <v-icon size="small" @click="deleteItem(item)" v-if="hasPermissionTo('models.delete')">
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

export default {
    components: {
        Toaster,
    },
    props: {
        models: {
            type: Array,
            required: true
        }
    },
    data: () => ({
        search: '',
        dialog: false,
        dialogDelete: false,
        headers: [
            { title: 'Modelo', key: 'trademark_model' },
            { title: 'Marca', key: 'trademark.trademark' },
            { title: 'Estado', key: 'active' },
            { title: 'Actions', key: 'actions', sortable: false }
        ],
        editedIndex: -1,
        editedItem: {
            trademark_model_uuid: '',
            trademark_model: '',
            trademark_code: '',
            active: false,
        },
        defaultItem: {
            trademark_model_uuid: '',
            trademark_model: '',
            trademark_code: '',
            active: false
        },
        trademarks: [],
    }),
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Nuevo modelo' : 'Editar modelo'
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
            this.editedIndex = this.models.indexOf(item)
            item.active = item.active == "1" ? true : false
            item.trademark_code = item.trademark.trademark_code
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },
        deleteItem(item) {
            this.editedIndex = this.models.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },
        deleteItemConfirm(item) {
            const putRequest = () => {
                return axios.delete('api/trademark/models/' + item);
            };
            toast.promise(putRequest, {
                loading: 'Procesando...',
                success: (data) => {
                    this.closeDelete()
                    this.$inertia.reload()
                    return 'Modelo eliminada correctamente';
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
            if (this.editedIndex > -1) {
                const putRequest = () => {
                    return axios.put('api/trademark/models/' + this.editedItem.trademark_model_uuid, {
                        trademark_model: this.editedItem.trademark_model,
                        trademark_code: this.editedItem.trademark_code,
                        active: this.editedItem.active
                    });
                };
                toast.promise(putRequest(), {
                    loading: 'Procesando...',
                    success: (data) => {
                        this.$inertia.reload()
                        this.close()
                        return 'Modelo actualizada correctamente';
                    },
                    error: (data) => {
                        this.handleErrors(data);
                    }
                });
            } else {
                const postRequest = () => {
                    return axios.post('api/trademark/models', {
                        trademark_model: this.editedItem.trademark_model,
                        trademark_code: this.editedItem.trademark_code,
                        active: this.editedItem.active
                    });
                };

                toast.promise(postRequest(), {
                    loading: 'Procesando...',
                    success: (data) => {
                        this.$inertia.reload()
                        this.close()
                        return 'Modelo creada correctamente';
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
        getTrademarks() {
            axios.get('api/trademarks')
                .then(response => {
                    this.trademarks = response.data.data;
                })
                .catch(error => {
                    toast.error('Error al cargar las marcas');
                });
        },
    },
    mounted() {
        this.getTrademarks();
    }
}
</script>
