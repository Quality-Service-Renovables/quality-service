<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
</script>

<template>
    <Toaster position="top-right" richColors :visibleToasts="10" />

    <Head title="Marcas" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Marcas</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <v-card>
                        <v-row>
                            <v-col cols="12" sm="12">
                                <v-data-table :headers="headers" :items="trademarks" fixed-header
                                    :search="search">
                                    <template v-slot:item.active="{ value }">
                                        <v-icon :color="getColor(value)">mdi-circle-slice-8</v-icon>
                                    </template>
                                    <template v-slot:top>
                                        <v-toolbar flat>
                                            <v-toolbar-title class="ml-1">
                                                <v-text-field v-model="search" label="Buscar" hide-details
                                                    variant="solo" append-inner-icon="mdi-magnify" density="compact"></v-text-field>
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
                                                                    <v-text-field
                                                                        v-model="editedItem.trademark"
                                                                        label="Nombre" variant="solo"
                                                                        hide-details></v-text-field>
                                                                </v-col>
                                                                <v-col cols="12">
                                                                    <v-select v-model="editedItem.ct_trademark_code"
                                                                        :items="ct_trademarks"
                                                                        item-title="ct_trademark"
                                                                        item-value="ct_trademark_code"
                                                                        label="Categoría" variant="solo" hide-details></v-select>
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
                                                            @click="deleteItemConfirm(editedItem.trademark_uuid)">Si,
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
        trademarks: {
            type: Array,
            required: true
        }
    },
    data: () => ({
        search: '',
        dialog: false,
        dialogDelete: false,
        headers: [
            { title: 'Marca', key: 'trademark' },
            { title: 'Estado', key: 'active' },
            { title: 'Categoría', key: 'category.ct_trademark'},
            { title: 'Acciones', key: 'actions', sortable: false }
        ],
        editedIndex: -1,
        editedItem: {
            trademark_uuid: '',
            trademark: '',
            active: false,
            ct_trademark_code: '',
        },
        defaultItem: {
            trademark_uuid: '',
            trademark: '',
            active: false,
            ct_trademark_code: '',
        },
        ct_trademarks: [],
    }),
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Nueva marca' : 'Editar marca'
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
            this.editedIndex = this.trademarks.indexOf(item)
            item.active = item.active == "1" ? true : false
            item.ct_trademark_code = item.category.ct_trademark_code
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },
        deleteItem(item) {
            this.editedIndex = this.trademarks.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },
        deleteItemConfirm(item) {
            const putRequest = () => {
                return axios.delete('api/trademarks/' + item);
            };
            toast.promise(putRequest, {
                loading: 'Procesando...',
                success: (data) => {
                    this.closeDelete()
                    this.$inertia.reload()
                    return 'Marca eliminada correctamente';
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
                    return axios.put('api/trademarks/' + this.editedItem.trademark_uuid, {
                        trademark: this.editedItem.trademark,
                        active: this.editedItem.active,
                        ct_trademark_code: this.editedItem.ct_trademark_code,
                    });
                };
                toast.promise(putRequest(), {
                    loading: 'Procesando...',
                    success: (data) => {
                        this.close()
                        this.$inertia.reload()
                        return 'Marca actualizada correctamente';
                    },
                    error: (data) => {
                        this.handleErrors(data);
                    }
                });
            } else {
                const postRequest = () => {
                    return axios.post('api/trademarks', {
                        trademark: this.editedItem.trademark,
                        active: this.editedItem.active,
                        ct_trademark_code: this.editedItem.ct_trademark_code,
                    });
                };

                toast.promise(postRequest(), {
                    loading: 'Procesando...',
                    success: (data) => {
                        this.close()
                        this.$inertia.reload()
                        return 'Marca creada correctamente';
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
        getTrademarkCategories(){
            axios.get('api/trademark/categories')
            .then(response => {
                this.ct_trademarks = response.data.data;
            })
            .catch(error => {
                toast.error('Error al cargar las categorías de marcas');
            });
        },
    },
    mounted() {
        this.getTrademarkCategories();
    }
}
</script>
