<script setup>
import {Head} from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
</script>

<template>
    <Toaster position="top-right" richColors :visibleToasts="10" />

    <Head title="Equipos" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Equipos</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <v-card>
                        <v-row>
                            <v-col cols="12" sm="12">
                                <v-data-table :headers="headers" :items="equipments" fixed-header :search="search">
                                    <template v-slot:item.equipment_image="{ item }">
                                        <v-avatar :image="'../../' + item.equipment_image" size="40" class="ma-1 avatar"
                                            @click="showImage(item.equipment_image)"></v-avatar>
                                    </template>
                                    <template v-slot:item.equipment_diagram="{ item }">
                                        <v-avatar :image="'../../' + item.equipment_diagram" size="40" class="ma-1 avatar"
                                            @click="showImage(item.equipment_diagram)"></v-avatar>
                                    </template>
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
                                            <v-dialog v-model="dialog" max-width="500px" v-if="hasPermissionTo('equipments.create') || hasPermissionTo('equipments.update')">
                                                <template v-slot:activator="{ props }" v-if="hasPermissionTo('equipments.create')">
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
                                                                    <v-text-field v-model="editedItem.equipment"
                                                                        label="Nombre" variant="solo" hide-details></v-text-field>
                                                                </v-col>
                                                                <v-col cols="12">
                                                                    <v-select
                                                                        v-model="editedItem.ct_equipment_code"
                                                                        :items="ct_equipments"
                                                                        item-title="ct_equipment"
                                                                        item-value="ct_equipment_code"
                                                                        label="Categoría" variant="solo" hide-details></v-select>
                                                                </v-col>
                                                                <v-col cols="12">
                                                                    <v-select v-model="editedItem.trademark_code"
                                                                        :items="trademarks" item-title="trademark"
                                                                        item-value="trademark_code" label="Marca"
                                                                        @update:model-value="setTradermarkModels()" variant="solo" hide-details></v-select>
                                                                </v-col>
                                                                <v-col cols="12">
                                                                    <v-select v-model="editedItem.trademark_model_code"
                                                                        :items="editedItem.models"
                                                                        item-title="trademark_model"
                                                                        item-value="trademark_model_code"
                                                                        label="Modelo" variant="solo" hide-details></v-select>
                                                                </v-col>
                                                                <v-col cols="12">
                                                                    <v-select v-model="editedItem.status_code"
                                                                        :items="status" item-title="status"
                                                                        item-value="status_code"
                                                                        label="Estatus" variant="solo" hide-details></v-select>
                                                                </v-col>
                                                                <v-col cols="12">
                                                                    <v-text-field v-model="editedItem.serial_number"
                                                                        label="Número de serie" variant="solo" hide-details></v-text-field>
                                                                </v-col>
                                                                <v-col cols="12">
                                                                    <v-file-input variant="solo" label="Manual"
                                                                        v-model="editedItem.manual"
                                                                        accept=".pdf" prepend-icon="" prepend-inner-icon="mdi-file-upload" hide-details></v-file-input>
                                                                </v-col>
                                                                <v-col cols="12">
                                                                    <v-file-input variant="solo" label="Imagen"
                                                                        v-model="editedItem.equipment_image"
                                                                        accept="image/*" prepend-icon="" prepend-inner-icon="mdi-image-plus" hide-details></v-file-input>
                                                                </v-col>
                                                                <v-col cols="12">
                                                                    <v-file-input variant="solo" label="Diagrama"
                                                                        v-model="editedItem.equipment_diagram"
                                                                        accept="image/*" prepend-icon="" prepend-inner-icon="mdi-image-plus" hide-details></v-file-input>
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
                                                            @click="deleteItemConfirm(editedItem.equipment_uuid)">Si,
                                                            eliminar</v-btn>
                                                        <v-spacer></v-spacer>
                                                    </v-card-actions>
                                                </v-card>
                                            </v-dialog>
                                        </v-toolbar>
                                    </template>
                                    <template v-slot:item.actions="{ item }">

                                        <a v-if="item.manual" :href="item.manual" target="_blank" class="v-btn v-btn--depressed">
                                            <v-icon class="me-2" size="small">
                                                mdi-file
                                            </v-icon>
                                        </a>
                                        <v-icon class="me-2" size="small" @click="editItem(item)" v-if="hasPermissionTo('equipments.update')">
                                            mdi-pencil
                                        </v-icon>
                                        <v-icon class="me-2" size="small" @click="deleteItem(item)" v-if="hasPermissionTo('equipments.delete')">
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

export default {
    components: {
        Toaster,
    },
    props: {
        equipments: {
            type: Array,
            required: true
        }
    },
    data: () => ({
        search: '',
        dialog: false,
        dialogDelete: false,
        headers: [
            { title: 'Foto', key: 'equipment_image', sortable: false },
            {
                title: 'Equipo',
                align: 'start',
                key: 'equipment',
            },
            { title: 'Marca', key: 'trademark.trademark' },
            { title: 'Modelo', key: 'model.trademark_model' },
            { title: 'No. Serie', key: 'serial_number' },
            { title: 'Categoría', key: 'category.ct_equipment' },
            { title: 'Estado', key: 'status.status' },
            { title: 'Diagrama', key: 'equipment_diagram' },
            { title: 'Activo', key: 'active' },
            { title: 'Actions', key: 'actions', sortable: false },
        ],
        editedIndex: -1,
        editedItem: {
            equipment_uuid: '',
            equipment: '',
            ct_equipment_code: '',
            trademark_code: '',
            trademark_model_code: '',
            status_code: '',
            serial_number: '',
            active: false,
            manual: null,
            equipment_image: null,
            equipment_diagram: null,
            models: [],
        },
        defaultItem: {
            equipment_uuid: '',
            equipment: '',
            ct_equipment_code: '',
            trademark_code: '',
            trademark_model_code: '',
            status_code: '',
            serial_number: '',
            active: false,
            manual: null,
            equipment_image: null,
            equipment_diagram: null,
            models: [],
        },
        trademarks: [],
        ct_equipments: [],
        status: [],
    }),
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Nuevo equipo' : 'Editar equipo'
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
        getItem(item) {
            return {
                equipment_uuid: item.equipment_uuid,
                equipment: item.equipment,
                ct_equipment_code: item.category.ct_equipment_code,
                trademark_code: item.trademark.trademark_code,
                trademark_model_code: item.model.trademark_model_code,
                status_code: item.status.status_code,
                serial_number: item.serial_number,
                active: item.active,
                manual: item.manual,
                equipment_image: item.equipment_image,
                equipment_diagram: item.equipment_diagram,
                models: this.trademarks.find(trademark => trademark.trademark_code === item.trademark.trademark_code).models
            }
        },
        editItem(item) {
            this.editedIndex = this.equipments.indexOf(item)
            item.active = item.active == "1" ? true : false
            this.editedItem = Object.assign({}, this.getItem(item))
            this.editedItem.manual = null
            this.editedItem.equipment_image = null
            this.editedItem.equipment_diagram = null
            this.dialog = true
        },
        deleteItem(item) {
            this.editedIndex = this.equipments.indexOf(item)
            this.editedItem = Object.assign({}, this.getItem(item))
            this.dialogDelete = true
        },
        deleteItemConfirm(item) {
            this.equipments.splice(this.editedIndex, 1)
            const putRequest = () => {
                return axios.delete('api/equipments/' + item);
            };
            toast.promise(putRequest, {
                loading: 'Procesando...',
                success: (data) => {
                    this.closeDelete()
                    return 'Equipo eliminado correctamente';
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
                'equipment': this.editedItem.equipment,
                'ct_equipment_code': this.editedItem.ct_equipment_code,
                'trademark_code': this.editedItem.trademark_code,
                'trademark_model_code': this.editedItem.trademark_model_code,
                'status_code': this.editedItem.status_code,
                'serial_number': this.editedItem.serial_number,
                'active': this.editedItem.active ? 1 : 0,
                'manual_storage': this.editedItem.manual,
                'equipment_image_storage': this.editedItem.equipment_image,
                'equipment_diagram_storage': this.editedItem.equipment_diagram,
            };

            if (this.editedIndex > -1) {
                const putRequest = () => {
                    return axios.post('api/equipments/update/' + this.editedItem.equipment_uuid, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    });
                };
                toast.promise(putRequest(), {
                    loading: 'Procesando...',
                    success: (data) => {
                        this.close()
                        this.$inertia.reload()
                        return 'Equipo actualizado correctamente';
                    },
                    error: (data) => {
                        this.handleErrors(data);
                    }
                });
            } else {
                const postRequest = () => {
                    return axios.post('api/equipments', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    });
                };

                toast.promise(postRequest(), {
                    loading: 'Procesando...',
                    success: (data) => {
                        this.close()
                        this.$inertia.reload()
                        return 'Equipo creado correctamente';
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
                    toast.error('Error al cargar el catálogo de marcas');
                });
        },
        setTradermarkModels() {
            this.editedItem.trademark_model_code = '';
            this.editedItem.models = this.trademarks.find(trademark => trademark.trademark_code === this.editedItem.trademark_code).models;
        },
        getCategories() {
            axios.get('api/equipment/categories')
                .then(response => {
                    this.ct_equipments = response.data.data;
                })
                .catch(error => {
                    toast.error('Error al cargar el catálogo de categorías');
                });
        },
        getStatus() {
            axios.get('api/status')
                .then(response => {
                    this.status = response.data.data;
                })
                .catch(error => {
                    toast.error('Error al cargar el catálogo de estatus');
                });
        },
        downloadManual(item) {
            window.open('../' + item.manual, '_blank');
        },
        showImage(url) {
            window.open('../' + url, '_blank');
        },
    },
    mounted() {
        this.getTrademarks();
        this.getCategories();
        this.getStatus();
    }

}
</script>

<style scoped>
.avatar {
    cursor: pointer;
}
</style>
