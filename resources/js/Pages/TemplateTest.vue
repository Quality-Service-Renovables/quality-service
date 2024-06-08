<template>
    <div>
        <Toaster position="top-right" richColors :visibleToasts="10" />
        <p class="text-h4">{{ item.ct_inspection }}</p>
        <br>
        <v-divider></v-divider>
        <v-btn class="text-none text-subtitle-1 me-1 mb-2" color="primary" @click="dialog = true">
            Agregar sección
        </v-btn>

        <div v-for="(section, index) in item.template.sections" :key="index">
            <SectionCard :section="section" :title="section.section_details.ct_inspection_section" :type="'section'"
                :inspection="item" @save-section="saveSection" @update-sections="updateSections">

                <template v-if="section.fields">
                    <p class="text-h6 font-weight-black my-2">Campos ({{ section.fields.length }})</p>
                    <FieldCard v-for="field in section.fields" :key="field.id" :field="field" />
                </template>

                <div v-if="section.sub_sections && section.sub_sections.length > 0">
                    <p class="text-h6 font-weight-black my-2">Sub-secciones ({{ section.sub_sections.length }})</p>
                    <div v-for="(sub_section, index2) in section.sub_sections" :key="index2">
                     
                        <SectionCard :section="sub_section" :title="sub_section.ct_inspection_section"
                            :type="'sub_section'" :inspection="item" @save-section="saveSection"
                            @update-sections="updateSections">

                            <template v-if="sub_section.fields">
                                <p class="text-h6 font-weight-black my-2">Campos ({{ sub_section.fields.length }})</p>
                                <FieldCard v-for="field in sub_section.fields" :key="field.id" :field="field" />
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

    </div>
</template>

<script>
import { Toaster, toast } from 'vue-sonner'
import SectionCard from './SectionCard.vue';
import FieldCard from '@/Pages/InspectionCategory/Partials/FieldCard.vue';

export default {
    components: {
        Toaster,
        SectionCard,
        FieldCard,
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
                toast.success('Sección guardada correctamente');
            } catch (error) {
                console.log("Hubo un error al guardar la sección 1: " + error);
                this.handleErrors(error);
            }
        },
        /**
         * Post a new section
         */
        async postSection(ct_inspection_uuid, ct_inspection_section, ct_inspection_relation_uuid = null) {
            try {
                await axios.post('api/inspection/sections', {
                    ct_inspection_uuid: ct_inspection_uuid,
                    ct_inspection_section: ct_inspection_section,
                    ct_inspection_relation_uuid: ct_inspection_relation_uuid,
                });
            } catch (error) {
                console.log("Hubo un error al guardar la sección 2");
                throw error;
            }
        },
        /**
         * Update the sections
         */
        async updateSections() {
            try {
                const response = await axios.get(`api/inspection/forms/get-form/${this.item.ct_inspection_uuid}`);
                this.item.template.sections = response.data.data.sections;
            } catch (error) {
                console.log("Hubo un error en la actualización de las secciones");
                throw error;
            }
        },

        resetForm() {
            this.dialog = false;
            this.sectionForm.name = '';
        },
    }
}
</script>