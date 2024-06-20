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
                                    <template v-slot:item.employees="{ value }">
                                        <p v-for="(employee, index) in value" :key="index">
                                            <v-icon class="mdi mdi-vector-point text-primary"></v-icon>
                                            {{ employee.user.name }}
                                        </p>
                                        <p v-if="!value.length">Por asignar</p>
                                    </template>
                                    <template v-slot:item.inspections="{ value }">
                                        <p v-for="inspection in value" :key="inspection.ct_inspection_uuid">
                                            {{ inspection.category.ct_inspection }}
                                        </p>
                                        <p v-if="!value.length">Por asignar</p>
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

                                            <!-- Dialog para editar proyecto -->
                                            <v-dialog v-model="dialog" width="auto"
                                                v-if="hasPermissionTo('projects.create') || hasPermissionTo('projects.update')">

                                                <template v-slot:activator="{ props }"
                                                    v-if="hasPermissionTo('projects.create')">
                                                    <v-btn class="mb-2" color="primary" dark
                                                        icon="mdi-lightbulb-on-outline"
                                                        @click="dialogHelp = true"></v-btn>
                                                    <v-btn class="mb-2" color="primary" dark v-bind="props"
                                                        icon="mdi-plus"></v-btn>
                                                </template>
                                                <v-card :loading="false">
                                                    <v-card-title>
                                                        <span class="text-h5">{{ formTitle }}</span>
                                                    </v-card-title>

                                                    <v-card-text>
                                                        <v-container>
                                                            <v-row>
                                                                <v-col cols="12">
                                                                    <v-text-field v-model="editedItem.project_name"
                                                                        label="Nombre" variant="outlined" hide-details
                                                                        required></v-text-field>
                                                                </v-col>
                                                                <v-col cols="6">
                                                                    <v-textarea v-model="editedItem.description"
                                                                        label="Descripción" variant="outlined"
                                                                        hide-details required></v-textarea>
                                                                </v-col>
                                                                <v-col cols="6">
                                                                    <v-textarea v-model="editedItem.comments"
                                                                        label="Comentarios" variant="outlined"
                                                                        hide-details></v-textarea>
                                                                </v-col>
                                                                <v-col cols="12">
                                                                    <v-select v-model="editedItem.client_uuid"
                                                                        :items="clients" item-title="client"
                                                                        item-value="client_uuid" label="Cliente"
                                                                        variant="outlined" hide-details
                                                                        required></v-select>
                                                                </v-col>
                                                                <v-col cols="12" class="text-right">
                                                                    <PrimaryButton @click="save">Guardar</PrimaryButton>
                                                                </v-col>
                                                                <v-col cols="12" class="text-right">
                                                                    <v-divider></v-divider>
                                                                </v-col>
                                                                <v-col cols="12"
                                                                    v-if="editedItem.project_uuid && checkStatus(editedItem, 'proceso_asignado')">
                                                                    <v-select v-model="editedItem.employees_uuid"
                                                                        :items="employees" item-title="name"
                                                                        item-value="uuid" label="Técnicos asignados"
                                                                        variant="outlined" hide-details required
                                                                        multiple chips clearable></v-select>
                                                                </v-col>
                                                                <v-col cols="12" class="text-right"
                                                                    v-if="editedItem.project_uuid && checkStatus(editedItem, 'proceso_asignado')">
                                                                    <PrimaryButton @click="asignTechniciens('update')">
                                                                        Guardar
                                                                    </PrimaryButton>
                                                                </v-col>
                                                            </v-row>
                                                        </v-container>
                                                    </v-card-text>

                                                    <v-card-actions>
                                                        <v-spacer></v-spacer>
                                                        <v-btn color="blue-darken-1" variant="text" @click="close">
                                                            Cerrar
                                                        </v-btn>

                                                    </v-card-actions>
                                                </v-card>
                                            </v-dialog>

                                            <!-- Dialog para eliminar proyecto -->
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
                                        <div class="d-flex">
                                            <ActionButton text="Editar" icon="mdi-pencil"
                                                v-if="hasPermissionTo('projects.update')" @click="editItem(item)"
                                                size="small" />
                                            <ActionButton text="Eliminar" icon="mdi-delete"
                                                v-if="hasPermissionTo('projects.delete')" @click="deleteItem(item)"
                                                size="small" />
                                        </div>
                                    </template>
                                    <template v-slot:item.inspection_actions="{ item }">
                                        <div class="d-flex">
                                            <ActionButton text="Asignar técnico" icon="mdi-account-plus-outline"
                                                v-if="hasPermissionTo('projects.update') && checkStatus(item, 'proceso_creado')"
                                                size="small" @click="asignTechniciensDialog(item)" />
                                            <ActionButton text="Asignar inspección" icon="mdi-table-plus"
                                                v-if="hasPermissionTo('projects.update') && checkStatus(item, 'proceso_asignado') && !item.inspections.length"
                                                size="small" @click="asignInspectionDialog(item)" />
                                            <ActionButton text="Iniciar inspección" icon="mdi-play-speed"
                                                v-if="hasPermissionTo('projects.update') && checkStatus(item, 'proceso_asignado') && item.inspections.length > 0"
                                                size="small" />
                                            <ActionButton text="Finalizar proyecto" icon="mdi-note-check"
                                                v-if="hasPermissionTo('projects.update') && checkStatus(item, 'proceso_iniciado')"
                                                size="small" />
                                            <ActionButton text="Validar proyecto" icon="mdi-check-circle-outline"
                                                v-if="hasPermissionTo('projects.update') && checkStatus(item, 'proceso_finalizado')"
                                                size="small" />
                                            <ActionButton text="Cerrar proyecto" icon="mdi-close-circle-outline"
                                                v-if="hasPermissionTo('projects.update') && checkStatus(item, 'proceso_validado')"
                                                size="small" />
                                            <ActionButton text="Cancelar proyecto" icon="mdi-table-cancel"
                                                v-if="hasPermissionTo('projects.update')" size="small" />
                                        </div>
                                    </template>
                                </v-data-table>

                                <!-- Help Dialog -->
                                <v-dialog v-model="dialogHelp" width="auto">
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
                                                @click="dialogHelp = false">Cerrar</v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-dialog>

                                <!-- Dialog para asignar técnicos -->
                                <v-dialog v-model="dialogAsignEmployees" width="400"
                                    v-if="hasPermissionTo('projects.update')">
                                    <v-card>
                                        <v-card-title>
                                            <span class="text-h5">Asignar técnicos</span>
                                        </v-card-title>

                                        <v-card-text>
                                            <v-container>
                                                <v-row>
                                                    <v-col cols="12">
                                                        <v-select v-model="editedItem.employees_uuid" :items="employees"
                                                            item-title="name" item-value="uuid"
                                                            label="Seleccionar técnicos" variant="outlined" hide-details
                                                            required multiple></v-select>
                                                    </v-col>
                                                </v-row>
                                            </v-container>
                                        </v-card-text>

                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn color="blue-darken-1" variant="text" @click="closeAsignTechniciens">
                                                Cerrar
                                            </v-btn>
                                            <v-btn color="blue-darken-1" variant="text"
                                                @click="asignTechniciens('create')"
                                                :disabled="!editedItem.employees_uuid.length">
                                                Guardar
                                            </v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-dialog>

                                <!-- Dialog para asignar técnicos -->
                                <v-dialog v-model="dialogAsignInspection" width="auto" min-height="600" scrollable
                                    v-if="hasPermissionTo('projects.update')">
                                    <v-card :loading="loadingInspectionDialog"
                                        :disabled="loadingInspectionDialog">
                                        <v-card-title>
                                            <span class="text-h5">Asignando inspección al proyecto "{{
        inspectionForm.project_name }}"</span>
                                        </v-card-title>

                                        <v-card-text>
                                            <v-container>
                                                <v-row>
                                                    <v-col cols="12">
                                                        <v-select v-model="inspectionForm.ct_inspection_code"
                                                            :items="inspections" item-title="ct_inspection"
                                                            item-value="ct_inspection_code"
                                                            label="Seleccionar inspección" variant="outlined"
                                                            hide-details required></v-select>
                                                    </v-col>
                                                    <v-col cols="6">
                                                        <v-select v-model="inspectionForm.ct_equipment_uuid"
                                                            :items="inspectionsEquipmentsCategories"
                                                            item-title="ct_equipment" item-value="ct_equipment_uuid"
                                                            label="Seleccionar categoría de equipo" variant="outlined"
                                                            hide-details required
                                                            @update:modelValue="getInspectionEquipmentsByCategory(inspectionForm.ct_equipment_uuid)"></v-select>
                                                    </v-col>
                                                    <v-col cols="6">
                                                        <v-select v-model="inspectionForm.equipment_uuid"
                                                            :items="equipmentsByCategory" item-title="equipment"
                                                            item-value="equipment_uuid"
                                                            label="Seleccionar equipo a inspeccionar" variant="outlined"
                                                            hide-details clearable></v-select>
                                                    </v-col>
                                                    <v-col cols="12">
                                                        <v-select v-model="inspectionForm.equipments_uuid"
                                                            :items="inspectionsEquipmentsToUseInInspections"
                                                            item-title="equipment" item-value="equipment_uuid"
                                                            label="Seleccionar equipos a utilizar en la inspcección"
                                                            variant="outlined" hide-details multiple chips
                                                            clearable></v-select>
                                                    </v-col>
                                                    <v-col cols="12">
                                                        <p class="text-grey mb-2">Define el resumen de la inspección a
                                                            realizar
                                                        </p>
                                                        <QuillEditor v-model:content="inspectionForm.resume"
                                                            theme="snow" toolbar="full" heigth="100%"
                                                            contentType="html" />
                                                    </v-col>
                                                </v-row>
                                            </v-container>
                                        </v-card-text>

                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn color="blue-darken-1" variant="text" @click="closeAsignInspection">
                                                Cerrar
                                            </v-btn>
                                            <v-btn color="blue-darken-1" variant="text" @click="asignInspection()"
                                                :disabled="false" :loading="loadingInspectionDialog">
                                                Guardar
                                            </v-btn>
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
import ActionButton from '@/Pages/Projects/Partials/ActionButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { mdiCarLightHigh } from '@mdi/js';
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';

export default {
    components: {
        Toaster,
        ActionButton,
        PrimaryButton,
        QuillEditor
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
        dialogHelp: false,
        dialogAsignEmployees: false,
        dialogDelete: false,
        dialogAsignInspection: false,
        headers: [
            { title: 'Nombre', key: 'project_name' },
            //{ title: 'Descripción', key: 'description' },
            { title: 'Cliente', key: 'client.client' },
            //{ title: 'Comentarios', key: 'comments' },
            { title: 'Técnicos asignados', key: 'employees' },
            { title: 'Inspección asignada', key: 'inspections' },
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
            employees_uuid: [],
        },
        defaultItem: {
            project_uuid: '',
            project_name: '',
            description: '',
            comments: '',
            client_uuid: '',
            employees_uuid: [],
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
        employees: [],
        editingProjectUuid: '',
        inspections: [],
        inspectionsEquipmentsCategories: [],
        inspectionsEquipmentsToUseInInspections: [],
        loadingInspectionDialog: false,
        equipmentsByCategory: [],
        inspectionForm: {
            inspection_uuid: '',
            project_name: '',
            resume: '',
            ct_inspection_code: null,
            status_code: 'inspeccion_iniciada',
            project_id: null,
            client_uuid: null,
            ct_equipment_uuid: null,
            equipment_uuid: [],
            equipments_uuid: [],
        },
        defaultInspectionForm: {
            inspection_uuid: '',
            project_name: '',
            resume: '',
            ct_inspection_code: null,
            status_code: 'inspeccion_iniciada',
            project_id: null,
            client_uuid: null,
            ct_equipment_uuid: null,
            equipment_uuid: [],
            equipments_uuid: [],
        },
        errorAssigningInspection: false,
    }),
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Nuevo proyecto' : 'Editar proyecto'
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
        this.getTechniciens();
        this.getInspections();
        this.getinspectionsEquipmentsCategories();
    },
    methods: {
        // Save/edit project
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
        close() {
            this.dialog = false
            this.$nextTick(() => {
                console.log("Cambiando estatus en close");
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },
        editItem(item) {
            this.dialog = true
            this.editedIndex = this.projects.indexOf(item)
            this.getProject(item.project_uuid);
        },
        getProject(project_uuid) {
            axios.get('api/projects/' + project_uuid)
                .then(response => {
                    this.editedItem = response.data.data;
                    this.editedItem.client_uuid = this.editedItem.client.client_uuid;
                    //this.editedItem.employee_uuid = this.editedItem.employees.length > 0 ? this.editedItem.employees[0].user.uuid : '';
                    this.editedItem.employees_uuid = this.editedItem.employees.map(employee => employee.user.uuid);
                })
                .catch(error => {
                    this.handleErrors(error);
                });
        },

        // Delete project
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
        closeDelete() {
            this.dialogDelete = false
            this.$nextTick(() => {
                console.log("Cambiando estatus en closeDelete");
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        // Asinar técnicos
        asignTechniciensDialog(item) {
            this.dialogAsignEmployees = true;
            this.editingProjectUuid = item.project_uuid;
            console.log("Asignar técnico");
        },
        asignTechniciens(action) {
            let formData = {
                project_uuid: action === 'create' ? this.editingProjectUuid : this.editedItem.project_uuid,
                employees: []
            };

            this.editedItem.employees_uuid.forEach(employee => {
                formData.employees.push({
                    employee_uuid: employee
                });
            });
            if (action === 'update') {
                const putRequest = () => {
                    return axios.put('api/project/employees/' + formData.project_uuid, formData);
                };
                toast.promise(putRequest(), {
                    loading: 'Procesando...',
                    success: (data) => {
                        this.$inertia.reload()
                        this.close();
                        return 'Técnicos actualizados correctamente';
                    },
                    error: (data) => {
                        this.handleErrors(data);
                    }
                });
            } else if (action === 'create') {
                const postRequest = () => {
                    return axios.post('api/project/employees', formData);
                };
                toast.promise(postRequest(), {
                    loading: 'Procesando...',
                    success: (data) => {
                        this.$inertia.reload()
                        this.closeAsignTechniciens();
                        return 'Técnicos asignados correctamente';
                    },
                    error: (data) => {
                        this.handleErrors(data);
                    }
                });
            }
        },
        closeAsignTechniciens() {
            this.dialogAsignEmployees = false;
            this.editingProjectUuid = '';
        },

        // Asignar inspección
        async asignInspectionDialog(item) {
            this.dialogAsignInspection = true;
            this.editingProjectUuid = item.project_uuid;
            this.inspectionForm.project_name = item.project_name;
            this.inspectionForm.project_id = item.project_uuid;
            this.inspectionForm.client_uuid = item.client.client_uuid;
        },
        async asignInspection() {
            console.log("Asignar inspección");
            this.loadingInspectionDialog = true;
            try {
                await this.createInspection();
                await this.asignEquipmentToInspection();
            } catch (error) {
                toast.error('Error al asignar inspección, favor de verificar los datos ingresados.');
            }
            this.loadingInspectionDialog = false;

            if (!this.errorAssigningInspection) {
                this.$inertia.reload();
                this.closeAsignInspection();
            }
        },
        createInspection() {
            return new Promise((resolve, reject) => {
                const postRequest = () => {
                    return axios.post('api/inspections', {
                        resume: this.inspectionForm.resume,
                        conclusion: 'Por definir',
                        ct_inspection_code: this.inspectionForm.ct_inspection_code,
                        status_code: this.inspectionForm.status_code,
                        equipment_uuid: this.inspectionForm.equipment_uuid,
                        project_uuid: this.inspectionForm.project_id,
                        client_uuid: this.inspectionForm.client_uuid
                    });
                };
                toast.promise(postRequest(), {
                    loading: 'Asignando inspección...',
                    success: (data) => {
                        this.inspectionForm.inspection_uuid = data.data.data.inspection_uuid;
                        resolve('Inspección asignada correctamente');
                        return 'Inspección asignada correctamente';
                    },
                    error: (data) => {
                        this.errorAssigningInspection = true;
                        this.handleErrors(data);
                        reject(data);
                    }
                });
            });
        },
        asignEquipmentToInspection() {
            return new Promise((resolve, reject) => {
                let equipments = this.inspectionForm.equipments_uuid.map(equipment => {
                    return {
                        equipment_uuid: equipment
                    };
                });
                const postRequest = () => {
                    return axios.post('api/inspection/equipments', {
                        inspection_uuid: this.inspectionForm.inspection_uuid,
                        equipments: equipments
                    });
                };
                toast.promise(postRequest(), {
                    loading: 'Asignando equipos a inspección...',
                    success: (data) => {
                        resolve('Asignación completada correctamente');
                        return 'Asignación completada correctamente';
                    },
                    error: (data) => {
                        this.errorAssigningInspection = true;
                        this.handleErrors(data);
                        reject(data);
                    }
                });
            });
        },
        closeAsignInspection() {
            this.dialogAsignInspection = false;
            this.inspectionForm = Object.assign({}, this.defaultInspectionForm);
        },

        // Dependencies
        getClients() {
            axios.get('api/clients')
                .then(response => {
                    this.clients = response.data.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getTechniciens() {
            axios.get('api/users/get-rol-users/tecnico')
                .then(response => {
                    this.employees = response.data.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getInspections() {
            axios.get('api/inspection/categories')
                .then(response => {
                    this.inspections = response.data.data;
                })
                .catch(error => {
                    this.handleErrors(error);
                });
        },
        getinspectionsEquipmentsCategories() {
            axios.get('api/equipment/categories')
                .then(response => {
                    this.inspectionsEquipmentsCategories = response.data.data;
                    this.inspectionsEquipmentsToUseInInspections = this.inspectionsEquipmentsCategories
                        .filter(item => item.ct_equipment_code === 'inspeccion')
                    this.inspectionsEquipmentsToUseInInspections = this.inspectionsEquipmentsToUseInInspections.length ? this.inspectionsEquipmentsToUseInInspections[0].equipments : [];
                })
                .catch(error => {
                    this.handleErrors(error);
                });
        },

        // Helpers
        checkStatus(item, status) {
            return item.status.status_code == status;
        },
        getInspectionEquipmentsByCategory(ct_equipment_uuid) {
            let equipments = this.inspectionsEquipmentsCategories.find(category => category.ct_equipment_uuid === ct_equipment_uuid).equipments;
            this.equipmentsByCategory = equipments.length > 0 ? equipments : [];
        },
    }

}
</script>
