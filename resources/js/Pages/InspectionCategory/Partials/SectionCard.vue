<template>
    <div class="d-flex">
        <v-icon class="mdi mdi-subdirectory-arrow-right mt-4"></v-icon>
        <v-card class="w-100 mb-5" rounded="lg" border="dashed thin dark md">
            <v-card-title class="bg-blue-grey">
                <div class="d-flex justify-between">
                    <p class="text-h6 mr-2">{{ title }}</p>
                    <div class="bg-white rounded-xl border-0 px-2">
                        <v-btn density="compact" icon="mdi-plus" variant="plain" class="me-1" color="primary"
                            @click="dialogSection = true" v-if="type == 'section'"></v-btn>
                        <v-btn density="compact" icon="mdi-focus-field-horizontal" variant="plain" class="me-1"
                            color="primary" @click="dialogField = true"></v-btn>
                        <v-btn density="compact" icon="mdi-pencil" variant="plain" class="me-1"
                            @click="editSection"></v-btn>
                        <v-btn density="compact" icon="mdi-trash-can" variant="plain" class="me-1" color="red"
                            @click="deleteSection"></v-btn>
                    </div>
                </div>
            </v-card-title>
            <v-card-text>
                <div v-if="section.fields">
                    <p class="text-h6 font-weight-black my-2">Campos ({{ section.fields.length }})</p>
                    <FieldCard v-for="field in section.fields" :key="field.id" :field="field"
                        @delete-field="deleteField" />
                </div>

                <div v-if="section.sub_sections && section.sub_sections.length > 0">
                    <p class="text-h6 font-weight-black my-2">Sub-secciones ({{ section.sub_sections.length }})</p>
                    <div v-for="(sub_section, index2) in section.sub_sections" :key="index2">

                        <SectionCard :section="sub_section" :title="sub_section.ct_inspection_section"
                            :type="'sub_section'" :inspection="inspection" @update-sections="updateSections"
                            @delete-section="deleteSection">

                            <div v-if="sub_section.fields">
                                <p class="text-h6 font-weight-black my-2">Campos ({{ sub_section.fields.length }})</p>
                                <FieldCard v-for="field in sub_section.fields" :key="field.id" :field="field"
                                    @delete-field="deleteField" />
                            </div>

                        </SectionCard>

                    </div>
                </div>
            </v-card-text>
        </v-card>

        <!-- Add sub-section dialog -->
        <v-dialog v-model="dialogSection" width="auto">
            <v-card min-width="500">
                <v-card-title>
                    <p v-if="!editingSection">Nueva sub-sección</p>
                    <p v-if="editingSection">Editar sub-sección</p>
                </v-card-title>
                <v-card-text>
                    <v-row dense>
                        <v-col cols="12">
                            <v-text-field label="Nombre*" variant="outlined" required hide-details
                                v-model="sectionForm.name"></v-text-field>
                        </v-col>
                    </v-row>
                </v-card-text>
                <template v-slot:actions>
                    <v-btn class="ms-auto" text="Cancelar" @click="dialogSection = false"></v-btn>
                    <v-btn color="primary" text @click="saveSectionForm">Guardar</v-btn>
                </template>
            </v-card>
        </v-dialog>

        <!-- Add field dialog -->
        <v-dialog v-model="dialogField" width="auto">
            <v-card min-width="500">
                <v-card-title>
                    <p>Nuevo campo</p>
                </v-card-title>
                <v-card-text>
                    <v-row dense>
                        <v-col cols="12">
                            <v-text-field label="Nombre*" variant="outlined" required hide-details
                                v-model="fieldForm.name"></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-checkbox label="Requerido" v-model="fieldForm.required" hide-details></v-checkbox>
                        </v-col>
                    </v-row>
                </v-card-text>
                <template v-slot:actions>
                    <v-btn class="ms-auto" text="Cancelar" @click="dialogField = false"></v-btn>
                    <v-btn color="primary" text @click="saveFieldForm">Guardar</v-btn>
                </template>
            </v-card>
        </v-dialog>

        <!-- Delete field dialog -->
        <v-dialog v-model="dialogDeleteField" max-width="500px">
            <v-card>
                <v-card-title class="text-h5 text-center">¿Estás seguro de
                    eliminar este campo?</v-card-title>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue-darken-1" variant="text" @click="closeDeleteField">Cancel</v-btn>
                    <v-btn color="blue-darken-1" variant="text" @click="deleteFieldConfirm()">Si,
                        eliminar</v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </div>
</template>

<script>
import { Toaster, toast } from 'vue-sonner'
import FieldCard from './FieldCard.vue';

export default {
    components: {
        Toaster,
        FieldCard,
    },
    props: {
        section: {
            type: Object,
            required: true,
        },
        title: {
            type: String,
            required: true,
        },
        type: {
            type: String,
            required: true,
        },
        inspection: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            dialogSection: false,
            dialogField: false,
            types: [
                { id: 'field', name: 'Campo' },
                { id: 'section', name: 'Sección' },
            ],
            sectionForm: {
                ct_inspection_section_uuid: '',
                name: '',
            },
            fieldForm: {
                name: '',
                required: true
            },
            editingSection: false,
            dialogDeleteField: false,
            fieldToDeleteUuid: null,
        };
    },
    methods: {
        async saveSectionForm() {
            let ct_inspection_relation_uuid = this.type == 'section' ? this.section.section_details.ct_inspection_section_uuid : this.section.ct_inspection_section_uuid;
            let action = this.editingSection ? 'update' : 'create';
            await this.saveSection(action, this.inspection.ct_inspection_uuid, this.sectionForm.name, ct_inspection_relation_uuid);
            this.resetFormSection();
        },
        async saveFieldForm() {
            let ct_inspection_relation_uuid = this.type == 'section' ? this.section.section_details.ct_inspection_section_uuid : this.section.ct_inspection_section_uuid;
            await this.saveField(ct_inspection_relation_uuid);
            await this.updateSections();
            this.resetFormField();
        },
        test() {
            console.log('test');
        },
        /**
         * Save a new section
         * @param {string} action - The action to perform
         * @param {string} ct_inspection_uuid - The inspection uuid
         * @param {string} ct_inspection_section - The section name
         * @param {string} ct_inspection_relation_uuid - Si es una sección, se envía el uuid de la sección padre
         */
        async saveSection(action, ct_inspection_uuid, ct_inspection_section, ct_inspection_relation_uuid = null) {
            console.log("llego a saveSection");
            try {
                if (action == 'create') {
                    console.log("llego a create");
                    await this.postSection(ct_inspection_uuid, ct_inspection_section, ct_inspection_relation_uuid);
                } else if (action == 'update') {
                    console.log("llego a update");
                    await this.updateSection(ct_inspection_uuid, ct_inspection_section, ct_inspection_relation_uuid);
                }
                this.resetFormSection();
                await this.updateSections();
                //toast.success('Sección guardada correctamente');
            } catch (error) {
                this.handleErrors(error);
            }
        },
        /**
         * Post a new section
         */
        async postSection(ct_inspection_uuid, ct_inspection_section, ct_inspection_relation_uuid = null) {
            const postRequest = () => {
                return axios.post('api/inspection/sections', {
                    ct_inspection_uuid: ct_inspection_uuid,
                    ct_inspection_section: ct_inspection_section,
                    ct_inspection_relation_uuid: ct_inspection_relation_uuid,
                })
            };

            await toast.promise(postRequest(), {
                loading: 'Creando sección...',
                success: (data) => {
                    return 'Sección creada correctamente';
                },
                error: (data) => {
                    this.handleErrors(data);
                }
            });
        },
        async updateSection(ct_inspection_uuid, ct_inspection_section, ct_inspection_relation_uuid = null) {
            const postRequest = () => {
                return axios.put('api/inspection/sections/' + ct_inspection_relation_uuid, {
                    ct_inspection_uuid: ct_inspection_uuid,
                    ct_inspection_section: ct_inspection_section,
                })
            };

            await toast.promise(postRequest(), {
                loading: 'Actualizando sección...',
                success: (data) => {
                    return 'Sección actualizada correctamente';
                },
                error: (data) => {
                    this.handleErrors(data);
                }
            });
        },
        updateSections() {
            this.$emit('update-sections');
        },
        resetFormSection() {
            this.dialogSection = false;
            this.sectionForm.name = '';
            this.sectionForm.ct_inspection_section_uuid = '';
            this.editingSection = false;
        },
        resetFormField() {
            this.dialogField = false;
            this.fieldForm.name = '';
            this.fieldForm.required = true;
        },
        async saveField(ct_inspection_relation_uuid) {
            const postRequest = () => {
                return axios.post('api/inspection/forms/set-form-fields', {
                    ct_inspection_section_uuid: ct_inspection_relation_uuid,
                    fields: [
                        {
                            ct_inspection_form: this.fieldForm.name,
                            required: this.fieldForm.required
                        }
                    ]
                })
            };

            await toast.promise(postRequest(), {
                loading: 'Creando campo...',
                success: (data) => {
                    return 'Campo creado correctamente';
                },
                error: (data) => {
                    this.handleErrors(data);
                }
            });
        },
        deleteSection() {
            let ct_inspection_section_uuid = this.type == 'section' ? this.section.section_details.ct_inspection_section_uuid : this.section.ct_inspection_section_uuid;
            //console.log("La sección a eliminar es: ", ct_inspection_section_uuid);
            this.$emit('delete-section', ct_inspection_section_uuid);
        },
        editSection() {
            this.editingSection = true;
            this.dialogSection = true;
            let ct_inspection_section_uuid = this.type == 'section' ? this.section.section_details.ct_inspection_section_uuid : this.section.ct_inspection_section_uuid;
            let ct_inspection_section = this.type == 'section' ? this.section.section_details.ct_inspection_section : this.section.ct_inspection_section;
            this.sectionForm.name = ct_inspection_section;
            this.sectionForm.ct_inspection_section_uuid = ct_inspection_section_uuid;
        },
        editField(field) {
            this.dialogField = true;
            this.fieldForm.name = field.ct_inspection_form;
            this.fieldForm.required = field.required == 1 ? true : false;
        },
        // Delete field
        closeDeleteField() {
            this.dialogDeleteField = false;
            this.fieldToDeleteUuid = null;
        },
        deleteField(ct_inspection_form_uuid) {
            this.dialogDeleteField = true
            this.fieldToDeleteUuid = ct_inspection_form_uuid
        },
        async deleteFieldConfirm() {
            const deleteRequest = () => {
                return axios.delete('api/inspection/forms/delete-form-field/' + this.fieldToDeleteUuid);
            };
            await toast.promise(deleteRequest(), {
                loading: 'Eliminando...',
                success: (data) => {
                    this.closeDeleteField();
                    return 'Campo eliminado correctamente';
                },
                error: (data) => {
                    this.handleErrors(data);
                }
            });
            await this.updateSections();
        },
    }
}
</script>