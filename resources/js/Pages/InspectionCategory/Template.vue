<template>
    <div>
        <p class="text-h4">{{ item.ct_inspection }}</p>
        <br>
        <v-divider></v-divider>
        <div class="d-flex align-center justify-end mb-2">
            <PrimaryButton @click="dialog = true" class="me-2" :prependIcon="'mdi-plus'">
                Agregar sección
            </PrimaryButton>
            <SecondaryButton @click="updateSections" :prependIcon="'mdi-reload'">
                Recargar
            </SecondaryButton>
        </div>
        <v-col cols="12" v-if="loading">
            <v-progress-linear indeterminate color="primary"></v-progress-linear>
        </v-col>
        <div v-for="(section, index) in item.template.sections" :key="index">
            <SectionCard :section="section" :title="section.section_details.ct_inspection_section" :type="'section'"
                :inspection="item" @update-sections="updateSections" @delete-section="deleteSection"
                ref="sectionCardRef">
            </SectionCard>
        </div>

        <!-- Add section dialog -->
        <v-dialog v-model="dialog" width="auto">
            <v-card min-width="500" prepend-icon="mdi-plus" title="Nueva sección">
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
                    <v-btn color="primary" text @click="saveSection">Guardar</v-btn>
                </template>
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
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

export default {
    components: {
        Toaster,
        SectionCard,
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
            dialogDeleteSection: false,
            sectionToDeleteUuid: null,
            loading: false,
        }
    },
    methods: {
        async saveSection() {
            console.log(this.$refs.sectionCardRef);
            if (this.$refs.sectionCardRef) {
                await this.$refs.sectionCardRef[0].saveSection('create', this.item.ct_inspection_uuid, this.sectionForm.name, null);
                this.resetForm();
            } else {
                const postRequest = () => {
                    return axios.post('api/inspection/sections', {
                        ct_inspection_uuid: this.item.ct_inspection_uuid,
                        ct_inspection_section: this.sectionForm.name,
                        ct_inspection_relation_uuid: null,
                    })
                };

                await toast.promise(postRequest(), {
                    loading: 'Creando sección...',
                    success: (data) => {
                        this.resetForm();
                        this.dialog = false;
                        this.updateSections();
                        return 'Sección creada correctamente';
                    },
                    error: (data) => {
                        this.handleErrors(data);
                    }
                });
            }
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
                    return 'Template actualizado correctamente';
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
        // Delete section
        closeDeleteSection() {
            this.dialogDeleteSection = false;
            this.sectionToDeleteUuid = null;
        },
        deleteSection(ct_inspection_section_uuid) {
            this.dialogDeleteSection = true
            this.sectionToDeleteUuid = ct_inspection_section_uuid;
            console.log("delete section: ", this.sectionToDeleteUuid);
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