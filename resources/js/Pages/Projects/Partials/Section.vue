<template>
    <div class="max-w-7xl mx-auto sm:px-4 lg:px-6 mb-5 pb-5">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <v-card :loading="dialogFormLoading">
                <v-card-text class="padding-0">
                    <v-container>
                        <v-row>
                            <v-col cols="12" class="padding-0">
                                <v-expansion-panels multiple v-model="expandedPanel">
                                    <v-expansion-panel v-for="(section, indexSection) in sectionsForm"
                                        :key="indexSection" class="my-5" :expanded="true">

                                        <v-expansion-panel-title class="text-h6">
                                            {{ section.section_details.ct_inspection_section
                                            }}
                                            <v-card-subtitle class="ml-2 mt-0 pt-0">
                                                Sección
                                            </v-card-subtitle>
                                        </v-expansion-panel-title>


                                        <v-expansion-panel-text>
                                            <!-- Campos -->
                                            <div v-if="section.fields">
                                                <v-card v-for="(field, indexField) in section.fields" :key="indexField"
                                                    class="my-5" :loading="field.loading">
                                                    {{ complementData(field) }}
                                                    <v-card-title class="d-flex justify-between">
                                                        {{ field.ct_inspection_form }}
                                                        <v-icon color="success"
                                                            v-if="field.content.inspection_form_value">mdi-check</v-icon>
                                                        <v-icon color="red"
                                                            v-if="isEmptyField(field) && field.required">mdi-alert-circle-outline</v-icon>
                                                    </v-card-title>
                                                    <v-card-subtitle class="d-flex align-center justify-between">
                                                        Campo {{ field.required ? '*Requerido' :
                'Opcional'
                                                        }}
                                                        <v-switch v-model="field.switch_comment" color="secondary"
                                                            label="Comentario" hide-details></v-switch>
                                                    </v-card-subtitle>
                                                    <v-card-text class="pt-0">
                                                        <QuillEditor
                                                            v-model:content="field.content.inspection_form_value"
                                                            theme="snow" toolbar="essential" heigth="100%"
                                                            contentType="html" />
                                                        <p class="mt-3 text-grey" v-if="field.switch_comment">Comentarios:</p>
                                                        <QuillEditor
                                                            v-model:content="field.content.inspection_form_comments"
                                                            theme="snow" toolbar="essential" heigth="100%"
                                                            contentType="html" v-if="field.switch_comment"/>
                                                        <PrimaryButton @click="saveField(field)" class="mt-2" :disabled="field.loading">Guardar
                                                        </PrimaryButton>
                                                    </v-card-text>
                                                </v-card>
                                            </div>

                                            <!-- Secciones -->
                                            <div v-if="section.sub_sections">
                                                <v-expansion-panels multiple>
                                                    <v-expansion-panel
                                                        v-for="(subSection, indexSubSection) in section.sub_sections"
                                                        :key="indexSubSection" class="my-5">
                                                        <v-expansion-panel-title class="text-h6">
                                                            {{ subSection.ct_inspection_section
                                                            }}
                                                            <v-card-subtitle class="ml-2 mt-0 pt-0">
                                                                Sub-sección
                                                            </v-card-subtitle>
                                                        </v-expansion-panel-title>
                                                        <v-expansion-panel-text>
                                                            <!-- Campos -->
                                                            <div v-if="subSection.fields">
                                                                <v-card
                                                                    v-for="(fieldSub, indexFieldSub) in subSection.fields"
                                                                    :key="indexFieldSub" class="my-5" :loading="fieldSub.loading">
                                                                    {{ complementData(fieldSub) }}
                                                                    <v-card-title class="d-flex justify-between">
                                                                        {{
                fieldSub.ct_inspection_form
            }}
                                                                        <v-icon color="success"
                                                                            v-if="fieldSub.content.inspection_form_value">mdi-check</v-icon>
                                                                        <v-icon color="red"
                                                                            v-if="isEmptyField(fieldSub) && fieldSub.required">mdi-alert-circle-outline</v-icon>
                                                                    </v-card-title>
                                                                    <v-card-subtitle
                                                                        class="d-flex align-center justify-between">
                                                                        Campo {{
                fieldSub.required ?
                    '*Requerido' :
                                                                        'Opcional' }}
                                                                        <v-switch v-model="fieldSub.switch_comment"
                                                                            color="secondary" label="Comentario"
                                                                            hide-details></v-switch>
                                                                    </v-card-subtitle>
                                                                    <v-card-text>
                                                                        <QuillEditor
                                                                            v-model:content="fieldSub.content.inspection_form_value"
                                                                            theme="snow" toolbar="essential"
                                                                            heigth="100%" contentType="html" />
                                                                        <p class="mt-3 text-grey" v-if="fieldSub.switch_comment">Comentarios:</p>
                                                                        <QuillEditor
                                                                            v-model:content="fieldSub.content.inspection_form_comments"
                                                                            theme="snow" toolbar="essential"
                                                                            heigth="100%" contentType="html" v-if="fieldSub.switch_comment"/>
                                                                        <PrimaryButton @click="saveField(fieldSub)"
                                                                            class="mt-2" :disabled="fieldSub.loading">Guardar</PrimaryButton>
                                                                    </v-card-text>
                                                                </v-card>
                                                            </div>
                                                        </v-expansion-panel-text>
                                                    </v-expansion-panel>
                                                </v-expansion-panels>
                                            </div>

                                        </v-expansion-panel-text>
                                    </v-expansion-panel>
                                </v-expansion-panels>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
            </v-card>
        </div>
    </div>
</template>

<script>
import { QuillEditor } from '@vueup/vue-quill'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import axios from 'axios';
import { Toaster, toast } from 'vue-sonner'

export default {
    components: {
        QuillEditor,
        PrimaryButton,
        Toaster
    },
    props: {
        dialogForm: {
            type: Boolean,
            required: true
        },
        ct_inspection_uuid: {
            type: String,
            required: true
        },
        inspection_uuid: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            dialogFormLoading: false,
            sectionsForm: [],
            expandedPanel: [0, 1, 2, 3, 4, 5, 6]
        }
    },
    methods: {
        getForm() {
            this.dialogFormLoading = true;
            axios.get('api/inspection/forms/get-form-inspection/' + this.inspection_uuid)
                .then(response => {
                    this.dialogFormLoading = false;
                    this.sectionsForm = response.data.data.sections;
                })
                .catch(error => {
                    this.dialogFormLoading = false;
                    this.handleErrors(error);
                });
        },
        closeSectionDialog() {
            this.$emit('closeSectionDialog');
        },
        saveField(field) {
            field.loading = true;

            let formData = {
                inspection_uuid: this.inspection_uuid,
                form: [{
                    inspection_form_value: field.content.inspection_form_value,
                    inspection_form_comments: field.content.inspection_form_comments,
                    ct_inspection_form_uuid: field.ct_inspection_form_uuid
                }]
            }

            console.log("formData: ");
            console.log(formData);

            if (formData.form[0].inspection_form_value == null || formData.form[0].inspection_form_value == '') {
                toast.error('El campo no puede estar vacío');
                field.loading = false;
                return;
            } else {
                axios.post('api/inspection/forms/set-form-inspection', formData)
                    .then(response => {
                        field.loading = false;
                        toast.success('Campo guardado correctamente');
                        if(response.data.data.length > 0){
                            field.content = response.data.data[0];
                        }else{
                            this.getForm();
                        }
                    })
                    .catch(error => {
                        field.loading = false;
                        this.handleErrors(error);
                    });
            }
        },
        complementData(field) {
            if (field.content == null) {
                field.content = {
                    inspection_form_value: '',
                    inspection_form_comments: ''
                }
                field.switch_comment = false;
            }else{
                field.switch_comment = field.content.inspection_form_comments !== "" && field.content.inspection_form_comments !== null && field.content.inspection_form_comments !== "<p><br></p>" ? true : false;
            }
            
        },
        isEmptyField(field) {
            if (field.content.inspection_form_value == null || field.content.inspection_form_value == '') {
                return true;
            } else {
                return false;
            }
        },
    },
    mounted() {
        this.getForm();
    }
}
</script>

<style scoped>
@media screen and (min-width: 375px) {
    .padding-0 {
        padding: 0px !important;
    }
}

.ql-toolbar.ql-snow{
    border-radius: 15px 15px 0px 0px !important;
}

.ql-container.ql-snow{
    border-radius: 0px 0px 15px 15px !important;
}
</style>