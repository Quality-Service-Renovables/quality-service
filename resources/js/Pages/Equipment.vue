<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
</script>

<template>
    <Toaster position="top-right" richColors />

    <Head title="Equipments" />
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
                                <v-data-table :headers="headers" :items="equipments" fixed-header
                                    :search="search">
                                    <template v-slot:item.equipment_image="{ item }">
                                        <v-avatar :image="'../'+item.equipment_image" size="40" class="ma-1"></v-avatar>
                                    </template>
                                    <template v-slot:item.active="{ value }">
                                        <v-icon :color="getColor(value)">mdi-circle-slice-8</v-icon>
                                    </template>
                                    <template v-slot:top>
                                        <v-toolbar flat>
                                            <v-toolbar-title class="ml-1">
                                                <v-text-field v-model="search" label="Buscar" hide-details
                                                    variant="solo"></v-text-field>
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
                                                                        v-model="editedItem.equipment"
                                                                        label="Nombre"></v-text-field>
                                                                </v-col>
                                                                <v-col cols="12">
                                                                    <v-text-field
                                                                        v-model="editedItem.model"
                                                                        label="Modelo"></v-text-field>
                                                                </v-col>
                                                                <v-col cols="12">
                                                                    <v-text-field
                                                                        v-model="editedItem.serial_number"
                                                                        label="Número de serie"></v-text-field>
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
                                        <v-icon class="me-2" size="small" @click="editItem(item)">
                                            mdi-pencil
                                        </v-icon>
                                        <v-icon size="small" @click="deleteItem(item)">
                                            mdi-delete
                                        </v-icon>
                                    </template>
                                    <template v-slot:no-data>
                                        <v-btn color="primary" @click="initialize">
                                            Reset
                                        </v-btn>
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
            { title: '', key: 'equipment_image', value: 'equipment_image' },
            {
                title: 'Equipo',
                align: 'start',
                key: 'equipment',
            },
            { title: 'Marca', key: 'trademark.trademark' },
            { title: 'Modelo', key: 'model' },
            { title: 'No. Serie', key: 'serial_number' },
            { title: 'Category', key: 'category.equipment_category' },
            { title: 'Estado', key: 'status.status' },
            { title: 'Actions', key: 'actions', sortable: false },
        ],
        editedIndex: -1,
        editedItem: {
            equipment_uuid: '',
            equipment_image: '',
            equipment: '',
            trademark: '',
            model: '',
            serial_number: '',
            status: '',
        },
        defaultItem: {
            equipment_uuid: '',
            equipment_image: '',
            equipment: '',
            trademark: '',
            model: '',
            serial_number: '',
            status: '',
        },
    }),
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Nueva equipo' : 'Editar equipo'
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
            this.editedIndex = this.equipments.indexOf(item)
            item.active = item.active == "1" ? true : false
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },
        deleteItem(item) {
            this.editedIndex = this.equipments.indexOf(item)
            this.editedItem = Object.assign({}, item)
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
                    return 'Categoria eliminada correctamente';
                },
                error: (data) => {
                    if (data.response) {
                        // Si hay una respuesta de error, puedes acceder a los datos así:
                        const responseData = data.response.data;

                        // Verificamos si el error contiene un mensaje
                        if (responseData && responseData.status === 'fail' && responseData.message) {
                            // Iteramos sobre cada campo que contiene errores y mostramos los mensajes
                            for (const field in responseData.message) {
                                const errors = responseData.message[field];
                                // Aquí puedes manejar los errores como desees
                                toast.error(`Errores en el campo ${field}:`, {
                                    description: `${errors.join(', ')}`,
                                })
                            }
                        }
                    }
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
                Object.assign(this.equipments[this.editedIndex], this.editedItem)
                const putRequest = () => {
                    return axios.put('api/equipments/' + this.editedItem.equipment_uuid, {
                        equipment: this.editedItem.equipment,
                        trademark: this.editedItem.trademark.trademark,
                        model: this.editedItem.model,
                        serial_number: this.editedItem.serial_number,
                        status: this.editedItem.active
                    });
                };
                toast.promise(putRequest(), {
                    loading: 'Procesando...',
                    success: (data) => {
                        this.close()
                        return 'Equipo actualizado correctamente';
                    },
                    error: (data) => {
                        if (data.response) {
                            // Si hay una respuesta de error, puedes acceder a los datos así:
                            const responseData = data.response.data;

                            // Verificamos si el error contiene un mensaje
                            if (responseData && responseData.status === 'fail' && responseData.message) {
                                // Iteramos sobre cada campo que contiene errores y mostramos los mensajes
                                for (const field in responseData.message) {
                                    console.log(responseData.message[field]);
                                    const errors = responseData.message[field];
                                    // Aquí puedes manejar los errores como desees
                                    toast.error(`Errores en el campo ${field}:`, {
                                        description: `${errors.join(', ')}`,
                                    })
                                }
                            }
                        }
                    }
                });
            } else {
                this.equipments.push(this.editedItem)
                const postRequest = () => {
                    return axios.post('api/equipments', {
                        equipment_category: this.editedItem.equipment_category,
                        description: this.editedItem.description,
                        active: this.editedItem.active
                    });
                };

                toast.promise(postRequest(), {
                    loading: 'Procesando...',
                    success: (data) => {
                        this.close()
                        return 'Equipo creada correctamente';
                    },
                    error: (data) => {
                        if (data.response) {
                            // Si hay una respuesta de error, puedes acceder a los datos así:
                            const responseData = data.response.data;

                            // Verificamos si el error contiene un mensaje
                            if (responseData && responseData.status === 'fail' && responseData.message) {
                                // Iteramos sobre cada campo que contiene errores y mostramos los mensajes
                                for (const field in responseData.message) {
                                    console.log(responseData.message[field]);
                                    const errors = responseData.message[field];
                                    // Aquí puedes manejar los errores como desees
                                    toast.error(`Errores en el campo ${field}:`, {
                                        description: `${errors.join(', ')}`,
                                    })
                                }
                            }
                        }
                    }
                });
            }

        },
        getColor(value) {
            return value ? 'green' : 'red';
        },
    },
    mounted() {
        console.log("Equipments mounted");
        console.log(this.equipments);
    }

}
</script>
