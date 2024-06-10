<template>
    <div>
        <p class="text-h4">{{ item.ct_inspection }}</p>
        <br>
        <v-divider></v-divider>
        <div class="d-flex align-center justify-end mb-2 ">
            <PrimaryButton @click="dialog = true" class="me-2" :prependIcon="'mdi-plus'">
                Agregar sección
            </PrimaryButton>
            <SecondaryButton @click="updateSections" :prependIcon="'mdi-reload'">
                Recargar
            </SecondaryButton>
        </div>
        <v-col cols="12">
            <v-progress-linear indeterminate color="primary" v-if="loading"></v-progress-linear>
        </v-col>
        <div v-for="(section, index) in item.template.sections" :key="index">
            <SectionCard :section="section" :title="section.section_details.ct_inspection_section" :type="'section'"
                :inspection="item" @save-section="saveSection" @update-sections="updateSections"
                @delete-section="deleteSection">

                <template v-if="section.fields">
                    <p class="text-h6 font-weight-black my-2">Campos ({{ section.fields.length }})</p>
                    <FieldCard v-for="field in section.fields" :key="field.id" :field="field"
                        @delete-field="deleteField" />
                </template>

                <div v-if="section.sub_sections && section.sub_sections.length > 0">
                    <p class="text-h6 font-weight-black my-2">Sub-secciones ({{ section.sub_sections.length }})</p>
                    <div v-for="(sub_section, index2) in section.sub_sections" :key="index2">

                        <SectionCard :section="sub_section" :title="sub_section.ct_inspection_section"
                            :type="'sub_section'" :inspection="item" @save-section="saveSection"
                            @update-sections="updateSections" @delete-section="deleteSection">

                            <template v-if="sub_section.fields">
                                <p class="text-h6 font-weight-black my-2">Campos ({{ sub_section.fields.length }})</p>
                                <FieldCard v-for="field in sub_section.fields" :key="field.id" :field="field"
                                    @delete-field="deleteField" />
                            </template>

                        </SectionCard>

                    </div>
                </div>

            </SectionCard>
        </div>

        <v-dialog v-model="dialog" width="auto">
            <v-card min-width="400" prepend-icon="mdi-plus" title="Nueva sección">
                <v-card-text>
                    <v-row dense>
                        <v-col cols="12">
                            <v-text-field label="Nombre*" variant="outlined" required hide-details
                                v-model="sectionForm.name"></v-text-field>
                        </v-col>
                    </v-row>
                </v-card-text>
                <template v-slot:actions>
                    <v-btn class="ms-auto" text="Cancelar" @click="dialog = false"></v-btn>
                    <v-btn color="primary" text
                        @click="saveSection(item.ct_inspection_uuid, sectionForm.name)">Guardar</v-btn>
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

        <!-- Delete section dialog -->
        <v-dialog v-model="dialogDeleteSection" max-width="500px">
            <v-card>
                <v-card-title class="text-h5 text-center">¿Estás seguro de
                    eliminar esta sección?</v-card-title>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue-darken-1" variant="text" @click="closeDeleteSection">Cancel</v-btn>
                    <v-btn color="blue-darken-1" variant="text" @click="deleteSectionConfirm()">Si,
                        eliminar</v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </div>
</template>

<script>
import { Toaster, toast } from 'vue-sonner'
import SectionCard from './Partials/SectionCard.vue';
import FieldCard from './Partials/FieldCard.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

export default {
    components: {
        Toaster,
        SectionCard,
        FieldCard,
        PrimaryButton,
        SecondaryButton,
    },
    props: {
        item: {
            type: Object,
            required: true,
        },
    },
    mounted() {
        console.log(this.item);
    },
    data() {
        return {
            dialog: false,
            sectionForm: {
                name: '',
            },
            dialogDeleteField: false,
            fieldToDeleteUuid: null,
            dialogDeleteSection: false,
            sectionToDeleteUuid: null,
            loading: false,
        }
    },
    methods: {
        /**
         * Save a new section
         * @param {string} ct_inspection_uuid - The inspection uuid
         * @param {string} ct_inspection_section - The section name
         * @param {string} ct_inspection_relation_uuid - Si es una sección, se envía el uuid de la sección padre
         */
        async saveSection(ct_inspection_uuid, ct_inspection_section, ct_inspection_relation_uuid = null) {
            try {
                await this.postSection(ct_inspection_uuid, ct_inspection_section, ct_inspection_relation_uuid);
                this.resetForm();
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
        /**
         * Update the sections
         */
        async updateSections() {
            this.loading = true;
            const getRequest = () => {
                return axios.get(`api/inspection/forms/get-form/${this.item.ct_inspection_uuid}`);
            };

            await toast.promise(getRequest(), {
                loading: 'Actualizando secciones...',
                success: (data) => {
                    this.loading = false;
                    this.item.template.sections = data.data.data.sections;
                    return 'Secciónes actualizadas correctamente';
                },
                error: (data) => {
                    this.handleErrors(data);
                }
            });
        },

        resetForm() {
            this.dialog = false;
            this.sectionForm.name = '';
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
        // Delete section
        closeDeleteSection() {
            this.dialogDeleteSection = false;
            this.sectionToDeleteUuid = null;
        },
        deleteSection(ct_inspection_section_uuid) {
            this.dialogDeleteSection = true
            this.sectionToDeleteUuid = ct_inspection_section_uuid
        },
        async deleteSectionConfirm() {
            const deleteRequest = () => {
                return axios.delete('api/inspection/sections/' + this.sectionToDeleteUuid);
            };
            await toast.promise(deleteRequest(), {
                loading: 'Eliminando...',
                success: (data) => {
                    this.closeDeleteSection();
                    return 'Sección eliminada correctamente';
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