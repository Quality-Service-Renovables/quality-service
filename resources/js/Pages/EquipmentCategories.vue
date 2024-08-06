<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
</script>

<template>
    <Toaster position="top-right" richColors :visibleToasts="10" />

    <Head title="Categorias de Equipos" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl  leading-tight">Categorias de Equipos</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <v-card>
                        <v-row>
                            <v-col cols="12" sm="12">
                                <v-data-table :headers="headers" :items="ct_equipments" fixed-header :search="search"
                                    :mobile="isMobile()">
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
                                            <v-dialog v-model="dialog" max-width="500px"
                                                v-if="hasPermissionTo('equipments_categories.create') || hasPermissionTo('equipments_categories.update')">
                                                <template v-slot:activator="{ props }"
                                                    v-if="hasPermissionTo('equipments_categories.create')">
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
                                                                    <v-text-field v-model="editedItem.ct_equipment"
                                                                        label="Nombre" variant="solo"
                                                                        hide-details></v-text-field>
                                                                </v-col>
                                                                <v-col cols="12">
                                                                    <v-textarea v-model="editedItem.description"
                                                                        label="Descripción" variant="solo"
                                                                        hide-details></v-textarea>
                                                                </v-col>
                                                                <v-col cols="12">
                                                                    <v-switch label="Activo" v-model="editedItem.active"
                                                                        color="primary" hide-details></v-switch>
                                                                </v-col>
                                                                <v-col cols="12">
                                                                    <div class="d-flex justify-between">
                                                                        <p class="text-grey">Campos requeridos para el
                                                                            informe:
                                                                        </p>
                                                                        <v-btn v-if="!showCreateField" density="compact"
                                                                            prepend-icon="mdi-plus"
                                                                            class="mb-1 pr-0 text-none text-primary"
                                                                            variant="plain"
                                                                            @click="showCreateField = true">Agregar</v-btn>
                                                                        <v-btn v-if="showCreateField" density="compact"
                                                                            prepend-icon="mdi-close"
                                                                            class="mb-1 pr-0 text-none text-red"
                                                                            variant="plain"
                                                                            @click="showCreateField = false">Cancelar</v-btn>
                                                                        <v-btn v-if="showCreateField" density="compact"
                                                                            prepend-icon="mdi-content-save-check-outline"
                                                                            class="mb-1 pr-0 text-none text-primary"
                                                                            variant="plain" @click="addField"
                                                                            :disabled="!new_field">Guardar</v-btn>
                                                                    </div>
                                                                    <v-text-field v-model="new_field" label="Campo"
                                                                        variant="solo" hide-details
                                                                        v-if="showCreateField"></v-text-field>
                                                                    <div v-if="editedItem.required_fields_report">
                                                                        <v-checkbox
                                                                            v-for="perm in editedItem.required_fields_report.fields"
                                                                            :key="perm.key" :label="perm.name"
                                                                            hide-details class="py-0"
                                                                            v-model="perm.required"></v-checkbox>
                                                                    </div>
                                                                    <div v-else>
                                                                        <p class="text-red"><small>No se han registrado
                                                                                campos requeridos
                                                                                para el informe.</small></p>
                                                                    </div>
                                                                </v-col>
                                                            </v-row>
                                                        </v-container>
                                                    </v-card-text>

                                                    <v-card-actions>
                                                        <v-spacer></v-spacer>
                                                        <v-btn color="blue-darken-1" variant="text" @click="close">
                                                            Cerrar
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
                                                            @click="deleteItemConfirm(editedItem.ct_equipment_uuid)">Si,
                                                            eliminar</v-btn>
                                                        <v-spacer></v-spacer>
                                                    </v-card-actions>
                                                </v-card>
                                            </v-dialog>
                                        </v-toolbar>
                                    </template>
                                    <template v-slot:item.actions="{ item }">
                                        <v-icon class="me-2" size="small" @click="editItem(item)"
                                            v-if="hasPermissionTo('equipments_categories.update')">
                                            mdi-pencil
                                        </v-icon>
                                        <v-icon size="small" @click="deleteItem(item)"
                                            v-if="hasPermissionTo('equipments_categories.delete')">
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
        ct_equipments: {
            type: Array,
            required: true
        }
    },
    data: () => ({
        search: '',
        dialog: false,
        dialogDelete: false,
        headers: [
            { title: 'Categoria', key: 'ct_equipment' },
            { title: 'Descripción', key: 'description' },
            { title: 'Estado', key: 'active' },
            { title: 'Actions', key: 'actions', sortable: false }
        ],
        editedIndex: -1,
        editedItem: {
            ct_equipment_uuid: '',
            ct_equipment: '',
            description: '',
            active: false,
        },
        defaultItem: {
            ct_equipment_uuid: '',
            ct_equipment: '',
            description: '',
            active: false
        },
        showCreateField: false,
        new_field: '',
    }),
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Nueva categoria' : 'Editar categoria'
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
            this.editedIndex = this.ct_equipments.indexOf(item)
            item.active = item.active == "1" ? true : false
            this.editedItem = Object.assign({}, item)
            this.editedItem.required_fields_report = JSON.parse(item.required_fields_report);
            this.dialog = true
        },
        deleteItem(item) {
            this.editedIndex = this.ct_equipments.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },
        deleteItemConfirm(item) {
            this.ct_equipments.splice(this.editedIndex, 1)
            const putRequest = () => {
                return axios.delete('api/equipment/categories/' + item);
            };
            toast.promise(putRequest, {
                loading: 'Procesando...',
                success: (data) => {
                    this.closeDelete()
                    return 'Categoria eliminada correctamente';
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
                Object.assign(this.ct_equipments[this.editedIndex], this.editedItem)
                const putRequest = () => {
                    return axios.put('api/equipment/categories/' + this.editedItem.ct_equipment_uuid, {
                        ct_equipment: this.editedItem.ct_equipment,
                        description: this.editedItem.description,
                        required_fields_report: JSON.stringify(this.editedItem.required_fields_report),
                        active: this.editedItem.active
                    });
                };
                toast.promise(putRequest(), {
                    loading: 'Procesando...',
                    success: (data) => {
                        this.$inertia.reload()
                        //this.close()
                        return 'Categoria actualizada correctamente';
                    },
                    error: (data) => {
                        this.handleErrors(data);
                    }
                });
            } else {
                this.ct_equipments.push(this.editedItem)
                const postRequest = () => {
                    return axios.post('api/equipment/categories', {
                        ct_equipment: this.editedItem.ct_equipment,
                        description: this.editedItem.description,
                        required_fields_report: JSON.stringify(this.editedItem.required_fields_report),
                        active: this.editedItem.active
                    });
                };

                toast.promise(postRequest(), {
                    loading: 'Procesando...',
                    success: (data) => {
                        this.$inertia.reload()
                        this.close()
                        return 'Categoria creada correctamente';
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
        addField() {
            if (this.new_field) {
                if (this.editedItem.required_fields_report == null) {
                    this.editedItem.required_fields_report = { fields: [] };
                }
                this.editedItem.required_fields_report.fields.push({ key: this.new_field, name: this.new_field, required: false });
                this.new_field = '';
                this.showCreateField = false;
            } else {
                toast.error('El campo no puede estar vacío');
            }
        }
    },

}
</script>
