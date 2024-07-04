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
                                            <v-chip color="primary" variant="elevated">
                                                {{ section.section_details.ct_inspection_section
                                                }}
                                            </v-chip>
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
                                                    <v-card-title class="d-lg-flex justify-between">
                                                        <div class="d-flex align-center">
                                                            <v-chip color="primary">
                                                                {{ field.ct_inspection_form }}
                                                            </v-chip>
                                                            <v-card-subtitle>Campo</v-card-subtitle>
                                                        </div>
                                                        <div class="d-flex align-center gap-3">
                                                            <v-switch v-model="field.switch_comment" color="blue" 
                                                                label="Comentario" hide-details></v-switch>
                                                            <v-switch v-model="field.switch_ct_risk" color="blue" 
                                                                label="Riesgo" hide-details
                                                                @click="setRiesgo(field)"></v-switch>
                                                            <v-icon color="success"
                                                                v-if="!isEmptyField(field.content.inspection_form_value)">mdi-check</v-icon>
                                                            <v-icon color="red"
                                                                v-if="isEmptyField(field.content.inspection_form_value) && field.required">mdi-alert-circle-outline</v-icon>
                                                        </div>

                                                    </v-card-title>
                                                    <v-card-text class="pt-0">
                                                        <p class="text-grey">Contenido ({{
                field.required ?
                    '*Requerido' :
                    'Opcional' }}):</p>
                                                        <QuillEditor
                                                            v-model:content="field.content.inspection_form_value"
                                                            theme="snow" toolbar="essential" heigth="100%"
                                                            contentType="html" />
                                                        <!-- Comments Field -->
                                                        <p class="mt-3 text-grey" v-if="field.switch_comment">
                                                            Comentarios:</p>
                                                        <QuillEditor
                                                            v-model:content="field.content.inspection_form_comments"
                                                            theme="snow" toolbar="essential" heigth="100%"
                                                            contentType="html" v-if="field.switch_comment" />
                                                        <!-- ct_risk Selector -->
                                                        <p class="mt-3 text-grey" v-if="field.switch_ct_risk">
                                                            Riesgo:</p>
                                                        <v-select v-model="field.content.ct_risk_id" :items="ct_risks"
                                                            item-title="ct_risk" item-value="ct_risk_id"
                                                            variant="outlined" hide-details v-if="field.switch_ct_risk"
                                                            class="w-50 rounded" density="compact"
                                                            :style="{ 'background-color': getBgColor(field.content.ct_risk_id) }">
                                                            <template v-slot:item="{ props, item }">
                                                                <v-list-item v-bind="props" :title="item.raw.ct_risk"
                                                                    :style="{ 'background-color': item.raw.ct_color }"
                                                                    value="ct_risk"></v-list-item>
                                                            </template>
                                                        </v-select>
                                                        <!-- Save Button -->
                                                        <PrimaryButton @click="saveField(field)" class="mt-2"
                                                            :disabled="field.loading">Guardar
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
                                                            <v-chip color="primary" variant="elevated">{{
                subSection.ct_inspection_section
            }}</v-chip>
                                                            <v-card-subtitle class="ml-2 mt-0 pt-0">
                                                                Sub-sección
                                                            </v-card-subtitle>
                                                        </v-expansion-panel-title>
                                                        <v-expansion-panel-text>
                                                            <!-- Campos -->
                                                            <div v-if="subSection.fields">
                                                                <v-card
                                                                    v-for="(fieldSub, indexFieldSub) in subSection.fields"
                                                                    :key="indexFieldSub" class="my-5"
                                                                    :loading="fieldSub.loading">
                                                                    {{ complementData(fieldSub) }}
                                                                    <v-card-title class="d-lg-flex justify-between">
                                                                        <div class="d-flex align-center">
                                                                            <v-chip color="primary">{{
                fieldSub.ct_inspection_form
            }}</v-chip>
                                                                            <v-card-subtitle>Campo</v-card-subtitle>
                                                                        </div>
                                                                        <div class="d-lg-flex align-center gap-3">
                                                                            <v-switch v-model="fieldSub.switch_comment"
                                                                                color="blue"  label="Comentario"
                                                                                hide-details></v-switch>
                                                                            <v-switch v-model="fieldSub.switch_ct_risk"
                                                                                color="blue"  label="Riesgo"
                                                                                hide-details
                                                                                @click="setRiesgo(fieldSub)"></v-switch>
                                                                            <v-icon color="success"
                                                                                v-if="!isEmptyField(fieldSub.content.inspection_form_value)">mdi-check</v-icon>
                                                                            <v-icon color="red"
                                                                                v-if="isEmptyField(fieldSub.content.inspection_form_value) && fieldSub.required">mdi-alert-circle-outline</v-icon>
                                                                        </div>

                                                                    </v-card-title>
                                                                    <v-card-text class="pt-0">
                                                                        <p class="text-grey"> Contenido ({{
                fieldSub.required ?
                    '*Requerido' :
                    'Opcional' }}):</p>
                                                                        <QuillEditor
                                                                            v-model:content="fieldSub.content.inspection_form_value"
                                                                            theme="snow" toolbar="essential"
                                                                            heigth="100%" contentType="html" />
                                                                        <!-- Comments Field -->
                                                                        <p class="mt-3 text-grey"
                                                                            v-if="fieldSub.switch_comment">Comentarios:
                                                                        </p>
                                                                        <QuillEditor
                                                                            v-model:content="fieldSub.content.inspection_form_comments"
                                                                            theme="snow" toolbar="essential"
                                                                            heigth="100%" contentType="html"
                                                                            v-if="fieldSub.switch_comment" />
                                                                        <!-- ct_risk Selector -->
                                                                        <p class="mt-3 text-grey"
                                                                            v-if="fieldSub.switch_ct_risk">
                                                                            Riesgo:</p>
                                                                        <v-select v-model="fieldSub.content.ct_risk_id"
                                                                            :items="ct_risks" item-title="ct_risk"
                                                                            item-value="ct_risk_id" variant="outlined"
                                                                            hide-details v-if="fieldSub.switch_ct_risk"
                                                                            class="w-50 rounded" density="compact"
                                                                            :style="{ 'background-color': getBgColor(fieldSub.content.ct_risk_id) }">
                                                                            <template v-slot:item="{ props, item }">
                                                                                <v-list-item v-bind="props"
                                                                                    :title="item.raw.ct_risk"
                                                                                    :style="{ 'background-color': item.raw.ct_color }"
                                                                                    value="ct_risk"></v-list-item>
                                                                            </template>
                                                                        </v-select>
                                                                        <!-- Save Button -->
                                                                        <PrimaryButton @click="saveField(fieldSub)"
                                                                            class="mt-2" :disabled="fieldSub.loading">
                                                                            Guardar</PrimaryButton>
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
            expandedPanel: [0, 1, 2, 3, 4, 5, 6],
            ct_risks: []
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
                    ct_inspection_form_uuid: field.ct_inspection_form_uuid,
                    ct_risk_id: field.content.ct_risk_id
                }]
            }

            if (this.isEmptyField(formData.form[0].inspection_form_value)) {
                toast.error('El contenido no puede estar vacío');
                field.loading = false;
                return;
            } else {
                axios.post('api/inspection/forms/set-form-inspection', formData)
                    .then(response => {
                        field.loading = false;
                        toast.success('Campo guardado correctamente');
                        if (response.data.data.length > 0) {
                            field.content = response.data.data[0];
                        } else {
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
                    inspection_form_comments: '',
                    ct_risk_id: null
                }
                field.switch_comment = false;
                field.switch_ct_risk = false;
            } else {
                field.switch_comment = field.content.inspection_form_comments !== "" && field.content.inspection_form_comments !== null && field.content.inspection_form_comments !== "<p><br></p>" ? true : false;
                field.switch_ct_risk = field.content.ct_risk_id && field.content.ct_risk_id !== null ? true : false;
            }

        },
        isEmptyField(field) {
            if (field == null || field == '' || field == '<p><br></p>') {
                return true;
            } else {
                return false;
            }
        },
        getRisks() {
            axios.get('api/risks')
                .then(response => {
                    this.ct_risks = response.data.data;
                })
                .catch(error => {
                    this.handleErrors(error);
                });
        },
        getBgColor(ct_risk_id) {
            let color = this.ct_risks.filter(risk => {
                return ct_risk_id === risk.ct_risk_id;
            });
            return color.length > 0 ? color[0].ct_color : '';
        },
        setRiesgo(field) {
            if (field.switch_ct_risk == true) {
                field.switch_ct_risk = false;
                field.content.ct_risk_id = null;
            } else if (field.switch_ct_risk == false) {
                field.switch_ct_risk = true;
            }
        }
    },
    mounted() {
        this.getForm();
        this.getRisks();
    }
}
</script>

<style scoped>
@media screen and (min-width: 375px) {
    .padding-0 {
        padding: 0px !important;
    }
}

.ql-toolbar.ql-snow {
    border-radius: 15px 15px 0px 0px !important;
}

.ql-container.ql-snow {
    border-radius: 0px 0px 15px 15px !important;
}
</style>