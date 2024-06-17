<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
</script>

<template>
    <Toaster position="top-right" richColors :visibleToasts="10" />

    <Head title="Proyectos de inspección" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Proyectos de inspección</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <v-card>
                        <v-row>
                            <v-col cols="12" sm="12">

                                <v-data-table :headers="headers" :items="projects" fixed-header :search="search">
                                    <template v-slot:item.status.status="{ value }">
                                        <v-chip size="small" class="m-1">{{ value }}</v-chip>
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
                                            <v-dialog v-model="dialog" width="auto"
                                                v-if="hasPermissionTo('projects.create') || hasPermissionTo('projects.update')">

                                                <template v-slot:activator="{ props }"
                                                    v-if="hasPermissionTo('projects.create')">
                                                    <v-btn class="mb-2" color="primary" dark
                                                        icon="mdi-lightbulb-on-outline"
                                                        @click="helpDialog = true"></v-btn>
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
                                                                    <v-text-field v-model="editedItem.project_name"
                                                                        label="Nombre" variant="solo" hide-details
                                                                        required></v-text-field>
                                                                </v-col>
                                                                <v-col cols="6">
                                                                    <v-textarea v-model="editedItem.description"
                                                                        label="Descripción" variant="solo" hide-details
                                                                        required></v-textarea>
                                                                </v-col>
                                                                <v-col cols="6">
                                                                    <v-textarea v-model="editedItem.comments"
                                                                        label="Comentarios" variant="solo"
                                                                        hide-details></v-textarea>
                                                                </v-col>
                                                                <v-col cols="12">
                                                                    <v-select v-model="editedItem.client_uuid"
                                                                        :items="clients" item-title="client"
                                                                        item-value="client_uuid" label="Cliente"
                                                                        variant="solo" hide-details required></v-select>
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
                                                            @click="deleteItemConfirm(editedItem.project_uuid)">Si,
                                                            eliminar</v-btn>
                                                        <v-spacer></v-spacer>
                                                    </v-card-actions>
                                                </v-card>
                                            </v-dialog>
                                        </v-toolbar>
                                    </template>
                                    <template v-slot:item.actions="{ item }">
                                        <v-icon class="me-2" @click="editItem(item)"
                                            v-if="hasPermissionTo('projects.update')">
                                            mdi-pencil
                                        </v-icon>
                                        <v-icon @click="deleteItem(item)" v-if="hasPermissionTo('projects.delete')">
                                            mdi-delete
                                        </v-icon>
                                    </template>
                                    <template v-slot:item.inspection_actions="{ item }">
                                        <div class="d-flex">
                                            <v-tooltip text="Asignar inspección" location="top"
                                                v-if="hasPermissionTo('projects.update') && checkStatus(item, 'proceso_creado')">
                                                <template v-slot:activator="{ props }">
                                                    <v-btn icon="mdi-table-plus" v-bind="props" size="small"
                                                        class="m-1" />
                                                </template>
                                            </v-tooltip>
                                            <v-tooltip text="Asignar técnico" location="top"
                                                v-if="hasPermissionTo('projects.update') && checkStatus(item, 'proceso_creado')">
                                                <template v-slot:activator="{ props }">
                                                    <v-btn icon="mdi-account-plus-outline" v-bind="props" size="small"
                                                        class="m-1" />
                                                </template>
                                            </v-tooltip>
                                            <v-tooltip text="Iniciar proyecto" location="top"
                                                v-if="hasPermissionTo('projects.update') && checkStatus(item, 'proceso_asignado')">
                                                <template v-slot:activator="{ props }">
                                                    <v-btn icon="mdi-play-speed" v-bind="props" size="small"
                                                        class="m-1" />
                                                </template>
                                            </v-tooltip>
                                            <v-tooltip text="Finalizar proyecto" location="top"
                                                v-if="hasPermissionTo('projects.update') && checkStatus(item, 'proceso_iniciado')">
                                                <template v-slot:activator="{ props }">
                                                    <v-btn icon="mdi-note-check" v-bind="props" size="small"
                                                        class="m-1" />
                                                </template>
                                            </v-tooltip>
                                            <v-tooltip text="Validar proyecto" location="top"
                                                v-if="hasPermissionTo('projects.update') && checkStatus(item, 'proceso_finalizado')">
                                                <template v-slot:activator="{ props }">
                                                    <v-btn icon="mdi-check-circle-outline" v-bind="props" size="small"
                                                        class="m-1" />
                                                </template>
                                            </v-tooltip>
                                            <v-tooltip text="Cerrar proyecto" location="top"
                                                v-if="hasPermissionTo('projects.update') && checkStatus(item, 'proceso_validado')">
                                                <template v-slot:activator="{ props }">
                                                    <v-btn icon="mdi-close-circle-outline" v-bind="props" size="small"
                                                        class="m-1" />
                                                </template>
                                            </v-tooltip>
                                            <v-tooltip text="Cancelar proyecto" location="top">
                                                <template v-slot:activator="{ props }">
                                                    <v-btn icon="mdi-table-cancel" v-bind="props"
                                                        v-if="hasPermissionTo('projects.update')" size="small"
                                                        class="m-1" />
                                                </template>
                                            </v-tooltip>
                                        </div>
                                    </template>
                                </v-data-table>

                                <!-- Help Dialog -->
                                <v-dialog v-model="helpDialog" width="auto">
                                    <v-card>
                                        <v-card-title class="text-h5 text-center">Ayuda</v-card-title>
                                        <v-card-text>
                                            <v-container>
                                                <v-row>
                                                    <v-col cols="12">
                                                        <p class="text-h6 mb-2">Estatus:</p>
                                                        <v-timeline align="start" density="compact">
                                                            <v-timeline-item v-for="data in helpData" :key="data.title"
                                                                size="x-small" dot-color="grey">
                                                                <div class="mb-4">
                                                                    <div class="font-weight-normal">
                                                                        <strong>{{ data.title }}</strong>
                                                                    </div>

                                                                    <div>{{ data.description }}</div>
                                                                </div>
                                                            </v-timeline-item>
                                                        </v-timeline>
                                                    </v-col>
                                                </v-row>
                                            </v-container>
                                        </v-card-text>
                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn color="blue-darken-1" variant="text"
                                                @click="helpDialog = false">Cerrar</v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-dialog>
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
        projects: {
            type: Array,
            required: true
        }
    },
    data: () => ({
        search: '',
        dialog: false,
        helpDialog: false,
        dialogDelete: false,
        headers: [
            { title: 'Nombre', key: 'project_name' },
            { title: 'Descripción', key: 'description' },
            { title: 'Cliente', key: 'client.client' },
            { title: 'Comentarios', key: 'comments' },
            { title: 'Estado', key: 'status.status' },
            { title: 'Acciones', key: 'actions', sortable: false },
            { title: 'Inspección', key: 'inspection_actions', sortable: false },
        ],
        editedIndex: -1,
        editedItem: {
            project_uuid: '',
            project_name: '',
            description: '',
            comments: '',
            client_uuid: '',
        },
        defaultItem: {
            project_uuid: '',
            project_name: '',
            description: '',
            comments: '',
            client_uuid: '',
        },
        helpData: [
            { title: 'Proceso creado', description: 'El proyecto ha sido creado, falta asignar técnico e inspección.' },
            { title: 'Proceso asignado', description: 'El proyecto ha sido asignado a un técnico, ya se puede iniciar.' },
            { title: 'Proceso iniciado', description: 'El proyecto ha sido iniciado, ya se puede comenzar a cargar información para el reporte final.' },
            { title: 'Proceso finalizado', description: 'El proyecto ha sido finalizado, ya puede comenzar la fase de validación de información.' },
            { title: 'Proceso validado', description: 'El proyecto ha sido validado, en este punto el cliente podrá visualizar el reporte final.' },
            { title: 'Proceso cerrado', description: 'El proyecto ha sido cerrado y no se podrá realizar más cambios.' },
            { title: 'Proceso cancelado', description: 'El proyecto ha sido cancelado y no se podrá realizar más cambios.' },
        ],
        clients: [],
    }),
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Nueva proyecto' : 'Editar proyecto'
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
    mounted() {
        this.getClients();
    },
    methods: {
        editItem(item) {
            this.editedIndex = this.projects.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.editedItem.client_uuid = item.client.client_uuid;
            this.dialog = true
        },
        deleteItem(item) {
            this.editedIndex = this.projects.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },
        deleteItemConfirm(item) {
            this.projects.splice(this.editedIndex, 1)
            const putRequest = () => {
                return axios.delete('api/projects/' + item);
            };
            toast.promise(putRequest, {
                loading: 'Procesando...',
                success: (data) => {
                    this.closeDelete()
                    return 'Proyecto eliminado correctamente';
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
                project_name: this.editedItem.project_name,
                description: this.editedItem.description,
                comments: this.editedItem.comments,
                client_uuid: this.editedItem.client_uuid,
            };
            if (this.editedIndex > -1) {
                formData.status_uuid = this.editedItem.status.status_uuid;
                const putRequest = () => {
                    return axios.put('api/projects/' + this.editedItem.project_uuid, formData);
                };
                toast.promise(putRequest(), {
                    loading: 'Procesando...',
                    success: (data) => {
                        this.$inertia.reload()
                        this.close()
                        return 'Proyecto actualizado correctamente';
                    },
                    error: (data) => {
                        this.handleErrors(data);
                    }
                });
            } else {
                const postRequest = () => {
                    return axios.post('api/projects', formData);
                };

                toast.promise(postRequest(), {
                    loading: 'Procesando...',
                    success: (data) => {
                        this.$inertia.reload()
                        this.close()
                        return 'Proyecto creado correctamente';
                    },
                    error: (data) => {
                        this.handleErrors(data);
                    }
                });
            }

        },
        getClients() {
            axios.get('api/clients')
                .then(response => {
                    this.clients = response.data.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        checkStatus(item, status) {
            return item.status.status_code == status;
        }
    },

}
</script>
