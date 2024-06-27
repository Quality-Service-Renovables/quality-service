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
                                    <template v-slot:item.status.status="{ value, item }">
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
                                            <ActionButton text="Cancelar proyecto" icon="mdi-table-cancel"
                                                v-if="hasPermissionTo('projects.update')" size="small" />
                                            <ActionButton text="Eliminar" icon="mdi-delete"
                                                v-if="hasPermissionTo('projects.delete')" @click="deleteItem(item)"
                                                size="small" />
                                            <ActionButton text="Asignar técnico" icon="mdi-account-plus-outline"
                                                v-if="hasPermissionTo('projects.update') && checkStatus(item, ['proyecto_asignado', 'proyecto_iniciado'])"
                                                size="small" @click="asignTechniciensDialog('update', item)"
                                                color="text-success" />
                                            <ActionButton text="Asignar inspección" icon="mdi-table-plus"
                                                v-if="hasPermissionTo('projects.update') && checkStatus(item, ['proyecto_asignado', 'proyecto_iniciado']) && item.inspections.length"
                                                size="small" @click="asignInspectionDialog('update', item)"
                                                color="text-success" />
                                            <ActionButton text="Generar PDF" icon="mdi-file-eye"
                                                v-if="hasPermissionTo('projects.update') && checkStatus(item, ['proyecto_asignado', 'proyecto_iniciado']) && item.inspections.length"
                                                size="small" @click="generatePdf(item)" color="text-success" />
                                        </div>
                                    </template>
                                    <template v-slot:item.inspection_actions="{ item }">
                                        <div class="d-flex">
                                            <ActionButton text="Asignar técnico" icon="mdi-account-plus-outline"
                                                v-if="hasPermissionTo('projects.update') && checkStatus(item, ['proyecto_creado'])"
                                                size="small" @click="asignTechniciensDialog('create', item)"
                                                color="text-primary" />
                                            <ActionButton text="Asignar inspección" icon="mdi-table-plus"
                                                v-if="hasPermissionTo('projects.update') && checkStatus(item, ['proyecto_asignado']) && !item.inspections.length"
                                                size="small" @click="asignInspectionDialog('create', item)"
                                                color="text-primary" />
                                            <!--<ActionButton text="Iniciar inspección" icon="mdi-play-speed"
                                                v-if="hasPermissionTo('projects.update') && checkStatus(item, 'proyecto_asignado') && item.inspections.length > 0"
                                                size="small" />-->
                                            <ActionButton text="Cargar información" icon="mdi-file-edit"
                                                v-if="hasPermissionTo('projects.update') && checkStatus(item, ['proyecto_iniciado'])"
                                                size="small" @click="formDialog(item)" color="text-primary" />
                                            <ActionButton text="Finalizar proyecto" icon="mdi-note-check"
                                                v-if="hasPermissionTo('projects.update') && checkStatus(item, ['proyecto_iniciado', 'inspeccion_iniciada']) && item.inspections.length > 0"
                                                size="small" color="text-primary" />
                                            <ActionButton text="Validar proyecto" icon="mdi-check-circle-outline"
                                                v-if="hasPermissionTo('projects.update') && checkStatus(item, ['proyecto_finalizado'])"
                                                size="small" />
                                            <ActionButton text="Cerrar proyecto" icon="mdi-close-circle-outline"
                                                v-if="hasPermissionTo('projects.update') && checkStatus(item, ['proyecto_validado'])"
                                                size="small" color="text-primary" />

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
                                            <span class="text-h5" v-if="editedItem.action == 'create'">Asignar
                                                técnicos</span>
                                            <span class="text-h5" v-if="editedItem.action == 'update'">Actualizar
                                                técnicos</span>
                                        </v-card-title>

                                        <v-card-text>
                                            <v-container>
                                                <v-row>
                                                    <v-col cols="12">
                                                        <v-select v-model="editedItem.employees_uuid" :items="employees"
                                                            item-title="name" item-value="uuid"
                                                            label="Seleccionar técnicos" variant="outlined" hide-details
                                                            required multiple chips></v-select>
                                                    </v-col>
                                                </v-row>
                                            </v-container>
                                        </v-card-text>

                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn color="blue-darken-1" variant="text" @click="closeAsignTechniciens">
                                                Cerrar
                                            </v-btn>
                                            <v-btn color="blue-darken-1" variant="text" @click="asignTechniciens()"
                                                :disabled="!editedItem.employees_uuid.length">
                                                Guardar
                                            </v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-dialog>

                                <!-- Dialog para asignar inspección -->
                                <v-dialog v-model="dialogAsignInspection" width="auto" min-height="600" scrollable
                                    v-if="hasPermissionTo('projects.update')">
                                    <v-card :loading="loadingInspectionDialog" :disabled="loadingInspectionDialog">
                                        <v-card-title>
                                            <span class="text-h5" v-if="!this.inspectionForm.isUpdating">Asignando
                                                inspección al
                                                proyecto "{{
        inspectionForm.project_name }}"</span>
                                            <span class="text-h5" v-if="this.inspectionForm.isUpdating">Actualizando
                                                inspección
                                                al proyecto "{{
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
                                                            theme="snow" toolbar="essential" heigth="100%"
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

                                <!-- Dialog para cargar informaciónd de secciones de la inspección -->
                                <v-dialog v-model="dialogForm" v-if="hasPermissionTo('projects.update')"
                                    transition="dialog-bottom-transition" fullscreen>
                                    <v-toolbar>
                                        <v-btn icon="mdi-close" @click="closeSectionDialog()"></v-btn>
                                        <v-toolbar-title class="w-100">
                                            Carga de información
                                            <p><small>Proyecto: "{{ this.inspectionForm.project_name }}"</small></p>
                                        </v-toolbar-title>
                                        <v-spacer></v-spacer>
                                    </v-toolbar>
                                    <v-card>
                                        <v-tabs v-model="tab" align-tabs="center"
                                            class="position-fixed w-100 bg-primary-color">
                                            <v-tab value="sections">Secciones</v-tab>
                                            <v-tab value="evidences">Evidencias</v-tab>
                                            <v-tab value="recomendations">Concluciones y Recomendaciones</v-tab>
                                        </v-tabs>

                                        <v-card-text class="mt-10">
                                            <v-tabs-window v-model="tab">
                                                <v-tabs-window-item v-if="tab === 'sections'">
                                                    <Section :dialogForm="dialogForm"
                                                        :ct_inspection_uuid="ctInspectionUuid"
                                                        :inspection_uuid="inspectionUuid"
                                                        @closeSectionDialog="closeSectionDialog" />
                                                </v-tabs-window-item>

                                                <v-tabs-window-item v-if="tab === 'evidences'">
                                                    <Evidence :inspection_uuid="inspectionUuid" />
                                                </v-tabs-window-item>

                                                <v-tabs-window-item v-if="tab === 'recomendations'">
                                                    <ConclutionAndRecomendation :inspection_uuid="inspectionUuid" />
                                                </v-tabs-window-item>
                                            </v-tabs-window>
                                        </v-card-text>
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
import { Toaster, toast } from 'vue-sonner'
import ActionButton from '@/Pages/Projects/Partials/ActionButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Section from '@/Pages/Projects/Partials/Section.vue';
import Evidence from '@/Pages/Projects/Partials/Evidence.vue';
import ConclutionAndRecomendation from '@/Pages/Projects/Partials/ConclutionAndRecomendation.vue';
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';

export default {
    components: {
        Toaster,
        ActionButton,
        PrimaryButton,
        QuillEditor,
        Section,
        Evidence,
        ConclutionAndRecomendation
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
            isUpdating: false,
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
            isUpdating: false,
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

        // Sections
        dialogForm: false,
        ctInspectionUuid: '',
        tab: 'sections',
        inspectionUuid: null,
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
        // 1 - Save/edit project
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

        // 1 - Delete project
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

        // 2 - Asignar técnicos
        asignTechniciensDialog(action, item) {
            this.dialogAsignEmployees = true;
            this.editingProjectUuid = item.project_uuid;

            if (action === 'update') {
                this.editedItem.action = 'update';
                this.editedItem.employees_uuid = item.employees.map(employee => employee.user.uuid);
            } else {
                this.editedItem.action = 'create';
                this.editedItem.employees_uuid = [];
            }
            console.log("Asignar técnico");
        },
        asignTechniciens() {
            let action = this.editedItem.action;
            let formData = {
                project_uuid: this.editingProjectUuid,
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
                        this.closeAsignTechniciens();
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

        // 2 - Asignar inspección
        async asignInspectionDialog(action, item) {
            this.dialogAsignInspection = true;
            this.editingProjectUuid = item.project_uuid;

            if (action == 'update') {
                this.inspectionForm.isUpdating = true;
                this.inspectionForm.inspection_uuid = item.inspections[0].inspection_uuid;
                this.inspectionForm.project_name = item.project_name;
                this.inspectionForm.resume = item.inspections[0].resume;
                this.inspectionForm.ct_inspection_code = item.inspections[0].category.ct_inspection_code;
                this.inspectionForm.status_code = item.status.status_code;
                this.inspectionForm.project_id = item.project_uuid;
                this.inspectionForm.client_uuid = item.client.client_uuid;
                this.inspectionForm.ct_equipment_uuid = item.inspections[0].equipment.category.ct_equipment_uuid;
                this.getInspectionEquipmentsByCategory(this.inspectionForm.ct_equipment_uuid);
                this.inspectionForm.equipment_uuid = item.inspections[0].equipment.equipment_uuid;
                this.inspectionForm.equipments_uuid = item.inspections[0].inspection_equipments.map(equipment => equipment.equipment.equipment_uuid);
            } else if (action == 'create') {
                this.inspectionForm.isUpdating = false;
                this.inspectionForm.project_name = item.project_name;
                this.inspectionForm.project_id = item.project_uuid;
                this.inspectionForm.client_uuid = item.client.client_uuid;
            }
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
                console.log("this.errorAssigningInspection: " + this.errorAssigningInspection);
                this.$inertia.reload();
                this.closeAsignInspection();
            }
        },
        createInspection() {
            return new Promise((resolve, reject) => {
                let request = null;
                if (!this.inspectionForm.isUpdating) {
                    let formData = {
                        resume: this.inspectionForm.resume,
                        conclusion: 'Por definir',
                        ct_inspection_code: this.inspectionForm.ct_inspection_code,
                        status_code: this.inspectionForm.status_code,
                        equipment_uuid: this.inspectionForm.equipment_uuid,
                        project_uuid: this.inspectionForm.project_id,
                        client_uuid: this.inspectionForm.client_uuid
                    }
                    request = () => {
                        return axios.post('api/inspections', formData);
                    };
                } else {
                    request = () => {
                        return axios.put('api/inspections/' + this.inspectionForm.inspection_uuid, formData);
                    };
                    let formData = {
                        resume: this.inspectionForm.resume,
                        conclusion: 'Por definir',
                        ct_inspection_code: this.inspectionForm.ct_inspection_code,
                        status_code: this.inspectionForm.status_code,
                        equipment_uuid: this.inspectionForm.equipment_uuid,
                        project_uuid: this.inspectionForm.project_id,
                        client_uuid: this.inspectionForm.client_uuid
                    }
                }

                toast.promise(request(), {
                    loading: !this.inspectionForm.isUpdating ? 'Asignando inspección...' : 'Actualizando inspección...',
                    success: (data) => {
                        this.inspectionForm.inspection_uuid = data.data.data.inspection_uuid;
                        let label = !this.inspectionForm.isUpdating ? 'Inspección asignada correctamente' : 'Inspección actualizada correctamente';
                        resolve(label);
                        return label;
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
                const request = () => {
                    if (!this.inspectionForm.isUpdating) {
                        return axios.post('api/inspection/equipments', {
                            inspection_uuid: this.inspectionForm.inspection_uuid,
                            equipments: equipments
                        });
                    } else {
                        return axios.put('api/inspection/equipments/' + this.inspectionForm.inspection_uuid, {
                            inspection_uuid: this.inspectionForm.inspection_uuid,
                            equipments: equipments
                        });
                    }

                };
                toast.promise(request(), {
                    loading: !this.inspectionForm.isUpdating ? 'Asignando equipos a inspección...' : 'Actualizando equipos de inspección...',
                    success: (data) => {
                        let label = !this.inspectionForm.isUpdating ? 'Asignación completada correctamente' : 'Actualización completada correctamente';
                        resolve(label);
                        return label;
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

        // Sections
        formDialog(item) {
            this.dialogForm = true;
            this.ctInspectionUuid = item.inspections[0].category.ct_inspection_uuid;
            this.inspectionUuid = item.inspections[0].inspection_uuid;
            this.inspectionForm.project_name = item.project_name;
        },
        closeSectionDialog() {
            this.dialogForm = false;
            this.ctInspectionUuid = '';
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
            return status.includes(item.status.status_code);
        },
        getInspectionEquipmentsByCategory(ct_equipment_uuid) {
            this.inspectionForm.equipment_uuid = null;
            let equipments = this.inspectionsEquipmentsCategories.find(category => category.ct_equipment_uuid === ct_equipment_uuid).equipments;
            this.equipmentsByCategory = equipments.length > 0 ? equipments : [];
        },
        generatePdf(item) {
            toast.warning('Solicitando documento, espere...');
            axios.get('inspection/get-document/' + item.inspections[0].inspection_uuid)
                .then(response => {
                    window.open(response.data.data.path_storage, '_blank');
                })
                .catch(error => {
                    toast.error('No fue posible recuperar el documento');
                    console.log(error);
                });
        },
    }
}
</script>

<style scoped>
.position-fixed {
    z-index: 9999;
}
</style>
