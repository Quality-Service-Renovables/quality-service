<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
</script>

<template>
    <Toaster position="top-right" richColors :visibleToasts="10" />

    <Head title="Equipments" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Aceites</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <v-card>
                        <v-row>
                            <v-col cols="12" sm="12">
                                <v-data-table :headers="headers" :items="oils" fixed-header :search="search">
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
                                            <v-dialog v-model="dialog" max-width="500px">
                                                <template v-slot:activator="{ props }">
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
                                                                    <v-text-field v-model="editedItem.oil"
                                                                        label="Nombre" variant="solo"
                                                                        hide-details></v-text-field>
                                                                </v-col>
                                                                <v-col cols="12">
                                                                    <v-text-field v-model="editedItem.viscosity"
                                                                        label="Viscosidad" variant="solo"
                                                                        hide-details></v-text-field>
                                                                </v-col>
                                                                <v-col cols="12">
                                                                    <v-textarea v-model="editedItem.description"
                                                                        label="Descripción" variant="solo"
                                                                        hide-details></v-textarea>
                                                                </v-col>
                                                                <v-col cols="12">
                                                                    <v-text-field v-model="editedItem.quantity"
                                                                        label="Cantidad" variant="solo" hide-details
                                                                        type="number"></v-text-field>
                                                                </v-col>
                                                                <v-col cols="12">
                                                                    <v-select v-model="editedItem.oil_category_code"
                                                                        :items="oil_categories" label="Categoria"
                                                                        item-title="oil_category"
                                                                        item-value="oil_category_code" hide-details
                                                                        variant="solo">
                                                                    </v-select>
                                                                </v-col>
                                                                <v-col cols="12">
                                                                    <v-select v-model="editedItem.trademark_code"
                                                                        :items="trademarks" label="Marca"
                                                                        item-title="trademark"
                                                                        item-value="trademark_code" hide-details
                                                                        variant="solo"></v-select>
                                                                </v-col>
                                                                <v-col cols="12">
                                                                    <v-select v-model="editedItem.trademark_model_code"
                                                                        :items="trademark_models" label="Modelo"
                                                                        item-title="trademark_model"
                                                                        item-value="trademark_model_code" hide-details
                                                                        variant="solo"></v-select>
                                                                </v-col>
                                                                <v-col cols="12">
                                                                    <v-text-field v-model="editedItem.production_date"
                                                                        label="Fecha producción" variant="solo"
                                                                        hide-details type="date"></v-text-field>
                                                                </v-col>
                                                                <v-col cols="12">
                                                                    <v-text-field v-model="editedItem.expiration_date"
                                                                        label="Fecha expiración" variant="solo"
                                                                        hide-details type="date"></v-text-field>
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
                                                            @click="deleteItemConfirm(editedItem.oil_uuid)">Si,
                                                            eliminar</v-btn>
                                                        <v-spacer></v-spacer>
                                                    </v-card-actions>
                                                </v-card>
                                            </v-dialog>
                                        </v-toolbar>
                                    </template>
                                    <template v-slot:item.actions="{ item }">
                                        <v-icon class="me-2" size="small" @click="editItem(item)">
                                            mdi-pencil
                                        </v-icon>
                                        <v-icon size="small" @click="deleteItem(item)">
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
        oils: {
            type: Array,
            required: true
        }
    },
    data: () => ({
        search: '',
        dialog: false,
        dialogDelete: false,
        headers: [
            { title: 'Aceite', key: 'oil' },
            { title: 'Viscosidad', key: 'viscosity' },
            { title: 'Descripción', key: 'description' },
            { title: 'Cantidad', key: 'quantity' },
            { title: 'Categoria', key: 'category.oil_category' },
            { title: 'Marca', key: 'trademark.trademark' },
            { title: 'Modelo', key: 'trademark.model.trademark_model' },
            { title: 'Fecha producción', key: 'production_date' },
            { title: 'Fecha expiración', key: 'expiration_date' },
            { title: 'Estatus', key: 'active' },
            { title: 'Acciones', key: 'actions', sortable: false }
        ],
        editedIndex: -1,
        editedItem: {
            oil_uuid: '',
            oil: '',
            viscosity: '',
            description: '',
            production_date: '',
            expiration_date: '',
            quantity: '',
            active: false,
            oil_category_code: '',
            trademark_code: '',
            trademark_model_code: '',
        },
        defaultItem: {
            oil_uuid: '',
            oil: '',
            viscosity: '',
            description: '',
            production_date: '',
            expiration_date: '',
            quantity: '',
            active: false,
            oil_category_code: '',
            trademark_code: '',
            trademark_model_code: '',
        },
        oil_categories: [],
        trademarks: [],
        trademark_models: [],
    }),
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Nuevo aceite' : 'Editar aceite'
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
            this.editedIndex = this.oils.indexOf(item)
            item.active = item.active == "1" ? true : false
            item.oil_category_code = item.category.oil_category_code;
            item.trademark_code = item.trademark.trademark_code;
            item.trademark_model_code = item.trademark.model.trademark_model_code;
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },
        deleteItem(item) {
            this.editedIndex = this.oils.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },
        deleteItemConfirm(item) {
            this.oils.splice(this.editedIndex, 1)
            const putRequest = () => {
                return axios.delete('api/oils/' + item);
            };
            toast.promise(putRequest, {
                loading: 'Procesando...',
                success: (data) => {
                    this.closeDelete()
                    return 'Aceite eliminado correctamente';
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
                'oil': this.editedItem.oil,
                'viscosity': this.editedItem.viscosity,
                'description': this.editedItem.description,
                'oil_category_code': this.editedItem.oil_category_code,
                'trademark_code': this.editedItem.trademark_code,
                'trademark_model_code': this.editedItem.trademark_model_code,
                'production_date': this.editedItem.production_date,
                'expiration_date': this.editedItem.expiration_date,
                'quantity': this.editedItem.quantity,
                'active': this.editedItem.active,
            };

            if (this.editedIndex > -1) {
                const putRequest = () => {
                    return axios.put('api/oils/' + this.editedItem.oil_uuid, formData);
                };
                toast.promise(putRequest(), {
                    loading: 'Procesando...',
                    success: (data) => {
                        this.$inertia.reload()
                        this.close()
                        return 'Aceite actualizado correctamente';
                    },
                    error: (data) => {
                        this.handleErrors(data);
                    }
                });
            } else {
                const postRequest = () => {
                    return axios.post('api/oils', formData);
                };

                toast.promise(postRequest(), {
                    loading: 'Procesando...',
                    success: (data) => {
                        this.$inertia.reload()
                        this.close()
                        return 'Aceite creado correctamente';
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
        getOilCategories() {
            axios.get('api/oil/categories')
                .then(response => {
                    this.oil_categories = response.data.data;
                })
                .catch(error => {
                    toast.error('Error al obtener las categorias de aceites');
                })
        },
        getTrademarks() {
            axios.get('api/trademarks')
                .then(response => {
                    this.trademarks = response.data.data;
                })
                .catch(error => {
                    toast.error('Error al obtener las marcas');
                })
        },
        getTrademarkModels() {
            axios.get('api/trademark/models')
                .then(response => {
                    this.trademark_models = response.data.data;
                })
                .catch(error => {
                    toast.error('Error al obtener los modelos de la marca');
                })
        },
    },
    mounted() {
        this.getOilCategories();
        this.getTrademarks();
        this.getTrademarkModels();
    }
}
</script>
