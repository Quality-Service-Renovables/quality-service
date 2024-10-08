<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
</script>

<template>
    <Toaster position="top-right" richColors :visibleToasts="10" />

    <Head title="Categorias de Inspecciones" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">Categorias de Inspecciones</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <v-card>
                        <v-row>
                            <v-col cols="12" sm="12">
                                <v-data-table :headers="headers" :items="ct_inspections" fixed-header :search="search" :mobile="isMobile()">
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
                                            <div
                                                v-if="hasPermissionTo('inspections.create') || hasPermissionTo('inspections.update')">
                                                <!-- Dialog for create and update -->
                                                <v-dialog v-model="dialog" max-width="500px">
                                                    <template v-slot:activator="{ props }"
                                                        v-if="hasPermissionTo('inspections.create')">
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
                                                                        <v-text-field v-model="editedItem.ct_inspection"
                                                                            label="Nombre" variant="solo"
                                                                            hide-details></v-text-field>
                                                                    </v-col>
                                                                    <v-col cols="12">
                                                                        <v-textarea v-model="editedItem.description"
                                                                            label="Descripción" variant="solo"
                                                                            hide-details></v-textarea>
                                                                    </v-col>
                                                                    <v-col cols="12">
                                                                        <v-switch label="Activo"
                                                                            v-model="editedItem.active"
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
                                                <!-- Dialog for create and update -->
                                                <!-- Dialog for show and edit template -->
                                                <v-dialog v-model="dialogTemplate" transition="dialog-bottom-transition"
                                                    fullscreen persistent>
                                                    <v-card>
                                                        <v-toolbar>
                                                            <v-btn icon="mdi-close" @click="closeTemplate"></v-btn>
                                                            <v-toolbar-title>Template</v-toolbar-title>
                                                            <v-spacer></v-spacer>
                                                            <v-toolbar-items>
                                                                <v-btn text="Cerrar" variant="text"
                                                                    @click="closeTemplate"></v-btn>
                                                            </v-toolbar-items>
                                                        </v-toolbar>
                                                        <v-card-text>
                                                            <v-container v-if="editedItem.template">
                                                                <TemplateInspectionCategory :item="editedItem"></TemplateInspectionCategory>
                                                            </v-container>
                                                        </v-card-text>
                                                    </v-card>
                                                </v-dialog>
                                                <!-- Dialog for show and edit template -->
                                            </div>
                                            <v-dialog v-model="dialogDelete" max-width="500px">
                                                <v-card>
                                                    <v-card-title class="text-h5 text-center">¿Estás seguro de
                                                        eliminar?</v-card-title>
                                                    <v-card-actions>
                                                        <v-spacer></v-spacer>
                                                        <v-btn color="blue-darken-1" variant="text"
                                                            @click="closeDelete">Cancel</v-btn>
                                                        <v-btn color="blue-darken-1" variant="text"
                                                            @click="deleteItemConfirm(editedItem.ct_inspection_uuid)">Si,
                                                            eliminar</v-btn>
                                                        <v-spacer></v-spacer>
                                                    </v-card-actions>
                                                </v-card>
                                            </v-dialog>
                                        </v-toolbar>
                                    </template>
                                    <template v-slot:item.actions="{ item }">
                                        <div class="d-flex" v-if="!item.inspection_in_process">
                                            <v-icon class="me-2" size="small" @click="editItem(item)"
                                                v-if="hasPermissionTo('inspections.update')">
                                                mdi-pencil
                                            </v-icon>
                                            <v-icon class="me-2" size="small" @click="showTemplate(item)"
                                                v-if="hasPermissionTo('inspections.update')">
                                                mdi-file-tree-outline
                                            </v-icon>
                                            <v-icon size="small" @click="deleteItem(item)"
                                                v-if="hasPermissionTo('inspections.delete')">
                                                mdi-delete
                                            </v-icon>
                                        </div>
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
import TemplateInspectionCategory from './InspectionCategory/Template.vue';

export default {
    components: {
        Toaster,
        TemplateInspectionCategory
    },
    props: {
        ct_inspections: {
            type: Array,
            required: true
        }
    },
    data: () => ({
        panel: [0, 1],
        search: '',
        dialog: false,
        dialogDelete: false,
        dialogTemplate: false,
        headers: [
            { title: 'Inspección', key: 'ct_inspection' },
            { title: 'Descripción', key: 'description' },
            { title: 'Estado', key: 'active' },
            { title: 'Actions', key: 'actions', sortable: false }
        ],
        editedIndex: -1,
        editedItem: {
            ct_inspection_code: '',
            ct_inspection_uuid: '',
            ct_inspection: '',
            description: '',
            active: false,
            template: {}
        },
        defaultItem: {
            ct_inspection_code: '',
            ct_inspection_uuid: '',
            ct_inspection: '',
            description: '',
            active: false,
            template: {}
        },
    }),
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Nueva tipo de inspección' : 'Editar tipo de inspección'
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
            this.editedIndex = this.ct_inspections.indexOf(item)
            item.active = item.active == "1" ? true : false
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },
        deleteItem(item) {
            this.editedIndex = this.ct_inspections.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },
        deleteItemConfirm(item) {
            this.ct_inspections.splice(this.editedIndex, 1)
            const putRequest = () => {
                return axios.delete('api/inspection/categories/' + item);
            };
            toast.promise(putRequest, {
                loading: 'Procesando...',
                success: (data) => {
                    this.closeDelete()
                    return 'Tipo de inspección eliminado correctamente';
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
        closeTemplate() {
            this.dialogTemplate = false
            this.editedItem.template = {}
        },
        save() {
            if (this.editedIndex > -1) {
                const putRequest = () => {
                    return axios.put('api/inspection/categories/' + this.editedItem.ct_inspection_uuid, {
                        ct_inspection: this.editedItem.ct_inspection,
                        description: this.editedItem.description,
                        active: this.editedItem.active
                    });
                };
                toast.promise(putRequest(), {
                    loading: 'Procesando...',
                    success: (data) => {
                        this.$inertia.reload()
                        this.close()
                        return 'Tipo de inspección actualizado correctamente';
                    },
                    error: (data) => {
                        this.handleErrors(data);
                    }
                });
            } else {
                const postRequest = () => {
                    return axios.post('api/inspection/categories', {
                        ct_inspection: this.editedItem.ct_inspection,
                        description: this.editedItem.description,
                        active: this.editedItem.active
                    });
                };

                toast.promise(postRequest(), {
                    loading: 'Procesando...',
                    success: (data) => {
                        this.$inertia.reload()
                        this.close()
                        return 'Tipo de inspección creada correctamente';
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
        showTemplate(item) {
            this.editedItem = Object.assign({}, item)
            console.log("Consultando template de inspección " + item.ct_inspection_uuid);
            return axios.get('api/inspection/forms/get-form/' + item.ct_inspection_uuid)
                .then(response => {
                    this.editedItem.template = response.data.data;
                    this.dialogTemplate = true;
                })
                .catch(error => {
                    console.log(error);
                })
        },
    },

}
</script>
