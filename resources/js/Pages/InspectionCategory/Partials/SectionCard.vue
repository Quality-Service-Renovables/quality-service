<template>
    <div class="d-flex">
        <v-icon class="mdi mdi-subdirectory-arrow-right mt-4"></v-icon>
        <v-card class="w-100 mb-5" rounded="lg" border="dashed thin dark md">
            <v-card-title class="bg-blue-grey">
                <div class="d-flex justify-between">
                    <p class="text-h6 mr-2">{{ title }}</p>

                    <div class="bg-white rounded-xl border-0 px-2" v-if="type == 'section'">
                        <v-btn density="compact" icon="mdi-plus" variant="plain" class="me-1" color="primary"
                            @click="dialogSection = true"></v-btn>
                        <v-btn density="compact" icon="mdi-focus-field-horizontal" variant="plain" class="me-1" color="primary"
                            @click="dialogField = true"></v-btn>
                        <v-btn density="compact" icon="mdi-pencil" variant="plain" class="me-1" @click="edit"></v-btn>
                        <v-btn density="compact" icon="mdi-trash-can" variant="plain" class="me-1" color="red"
                            @click="deleteSection"></v-btn>
                    </div>

                    <div class="bg-white rounded-xl border-0 px-2" v-if="type == 'sub_section'">
                        <v-btn density="compact" icon="mdi-focus-field-horizontal" variant="plain" class="me-1" color="primary"
                            @click="dialogField = true"></v-btn>
                        <v-btn density="compact" icon="mdi-pencil" variant="plain" class="me-1" @click="edit"></v-btn>
                        <v-btn density="compact" icon="mdi-trash-can" variant="plain" class="me-1" color="red"
                            @click="deleteSection"></v-btn>
                    </div>

                </div>
            </v-card-title>
            <v-card-text>
                <slot></slot>
            </v-card-text>
        </v-card>

        <v-dialog v-model="dialogSection" width="auto">
            <v-card min-width="400">
                <v-card-title>
                    <p>Nueva sub-sección</p>
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

        <v-dialog v-model="dialogField" width="auto">
            <v-card min-width="400">
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

    </div>
</template>

<script>
import { Toaster, toast } from 'vue-sonner'
export default {
    components: {
        Toaster,
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
                name: '',
            },
            fieldForm: {
                name: '',
                required: true
            },
        };
    },
    methods: {
        async saveSectionForm() {
            let ct_inspection_relation_uuid = this.type == 'section' ? this.section.section_details.ct_inspection_section_uuid : this.section.ct_inspection_section_uuid;
            await this.saveSection(ct_inspection_relation_uuid);
            this.resetFormSection();
        },
        async saveFieldForm() {
            let ct_inspection_relation_uuid = this.type == 'section' ? this.section.section_details.ct_inspection_section_uuid : this.section.ct_inspection_section_uuid;
            await this.saveField(ct_inspection_relation_uuid);
            await this.updateSections();
            this.resetFormField();
        },
        saveSection(ct_inspection_relation_uuid) {
            this.$emit('save-section', this.inspection.ct_inspection_uuid, this.sectionForm.name, ct_inspection_relation_uuid);
        },
        updateSections() {
            this.$emit('update-sections');
        },
        resetFormSection() {
            this.dialogSection = false;
            this.sectionForm.name = '';
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
            this.$emit('delete-section', ct_inspection_section_uuid);
        },
        edit() {
            let ct_inspection_section = this.type == 'section' ? this.section.section_details.ct_inspection_section : this.section.ct_inspection_section;
            this.dialogSection = true;
            this.sectionForm.name = ct_inspection_section;
        },
    }
}
</script>