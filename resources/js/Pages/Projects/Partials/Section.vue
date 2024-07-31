<template>
    <div class="max-w-7xl mx-auto sm:px-4 lg:px-6 mb-5 pb-5">
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <v-card :loading="dialogFormLoading">
                <v-card-text class="padding-0">
                    <v-container>
                        <v-row>
                            <v-col cols="12" class="padding-0">
                                <v-expansion-panels multiple v-model="expandedPanel">
                                    <v-expansion-panel v-for="(section, indexSection) in sectionsForm"
                                        :key="indexSection" class="my-5 border" :expanded="true">

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
                                                    class="my-5 border" :loading="field.loading">
                                                    {{ complementData(field) }}
                                                    <v-card-title class="d-lg-flex justify-between">
                                                        <div class="d-flex align-center">
                                                            <v-chip color="primary">
                                                                {{ field.ct_inspection_form }}
                                                            </v-chip>
                                                            <v-card-subtitle>Campo</v-card-subtitle>
                                                        </div>
                                                        <div class="d-flex align-center gap-3">
                                                            <v-icon color="success"
                                                                v-if="!isEmptyField(field.content.inspection_form_value)">mdi-check</v-icon>
                                                            <v-icon color="red"
                                                                v-if="isEmptyField(field.content.inspection_form_value) && field.required">mdi-alert-circle-outline</v-icon>
                                                        </div>

                                                    </v-card-title>
                                                    <v-card-text class="pt-0">
                                                        <v-row>
                                                            <v-col cols="12" lg="6">
                                                                <p class="text-grey">Código de falla ({{
                field.required ?
                    '*Requerido' :
                    'Opcional' }}):</p>
                                                                <v-autocomplete v-model="field.content.inspection_form_value"
                                                                    :items="failures" item-title="failure"
                                                                    item-value="failure" variant="outlined" hide-details
                                                                    class="rounded" density="compact">
                                                                </v-autocomplete>
                                                            </v-col>
                                                            <v-col cols="12" lg="6">
                                                                <!-- ct_risk Selector -->
                                                                <p class="text-grey">
                                                                    Riesgo:</p>
                                                                <v-autocomplete v-model="field.content.ct_risk_id"
                                                                    :items="ct_risks" item-title="ct_risk"
                                                                    item-value="ct_risk_id" variant="outlined"
                                                                    hide-details class="rounded" density="compact"
                                                                    :style="{ 'background-color': getBgColor(field.content.ct_risk_id) }">
                                                                    <template v-slot:item="{ props, item }">
                                                                        <v-list-item v-bind="props"
                                                                            :title="item.raw.ct_risk"
                                                                            :style="{ 'background-color': item.raw.ct_color }"
                                                                            value="ct_risk"></v-list-item>
                                                                    </template>
                                                                </v-autocomplete>
                                                            </v-col>

                                                        </v-row>

                                                        <!-- Comments Field -->
                                                        <p class="mt-3 text-grey">
                                                            Comentarios:</p>
                                                        <v-row>
                                                            <v-col cols="12" lg="8">
                                                                <QuillEditor
                                                                    v-model:content="field.content.inspection_form_comments"
                                                                    theme="snow" toolbar="essential" contentType="html"
                                                                    @click="getSuggestions(field)" />
                                                            </v-col>
                                                            <v-col cols="12" lg="4">
                                                                <v-card class="mx-auto border" color="primary"
                                                                    variant="outlined">
                                                                    <v-card-subtitle class="mt-2 mb-0"><span
                                                                            class="mdi mdi-lightbulb-on-outline"></span>
                                                                        Sugerencias</v-card-subtitle>
                                                                    <v-card-text
                                                                        class="py-1 card-suggestions overflow-y-auto"
                                                                        v-if="!field.loadingSuggestions">
                                                                        <v-card variant="tonal" class="my-1"
                                                                            v-for="(sueggest, idx_sueggest) in field.suggestions"
                                                                            :key="idx_sueggest"
                                                                            @click="setComment(field, sueggest)">
                                                                            <div class="m-1" v-html="sueggest"></div>
                                                                        </v-card>
                                                                    </v-card-text>
                                                                    <v-skeleton-loader type="paragraph"
                                                                        v-else></v-skeleton-loader>
                                                                    <v-card-text
                                                                        class="pt-0 card-suggestions overflow-y-auto"
                                                                        v-if="!field.suggestions">No hay
                                                                        sugerencias</v-card-text>
                                                                </v-card>
                                                            </v-col>
                                                        </v-row>
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
                                                        :key="indexSubSection" class="my-5 border">
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
                                                                    :key="indexFieldSub" class="my-5 border"
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
                                                                            <v-icon color="success"
                                                                                v-if="!isEmptyField(fieldSub.content.inspection_form_value)">mdi-check</v-icon>
                                                                            <v-icon color="red"
                                                                                v-if="isEmptyField(fieldSub.content.inspection_form_value) && fieldSub.required">mdi-alert-circle-outline</v-icon>
                                                                        </div>

                                                                    </v-card-title>
                                                                    <v-card-text class="pt-0">
                                                                        <v-row>
                                                                            <v-col cols="12" lg="6">
                                                                                <p class="text-grey">Código de falla ({{
                fieldSub.required ?
                    '*Requerido' :
                    'Opcional' }}):</p>
                                                                                <v-autocomplete
                                                                                    v-model="fieldSub.content.inspection_form_value"
                                                                                    :items="failures"
                                                                                    item-title="failure"
                                                                                    item-value="failure"
                                                                                    variant="outlined" hide-details
                                                                                    class="rounded" density="compact">
                                                                                </v-autocomplete>
                                                                            </v-col>
                                                                            <v-col cols="12" lg="6">
                                                                                <!-- ct_risk Selector -->
                                                                                <p class="text-grey">
                                                                                    Riesgo:</p>
                                                                                <v-autocomplete
                                                                                    v-model="fieldSub.content.ct_risk_id"
                                                                                    :items="ct_risks"
                                                                                    item-title="ct_risk"
                                                                                    item-value="ct_risk_id"
                                                                                    variant="outlined" hide-details
                                                                                    class="rounded"
                                                                                    density="compact"
                                                                                    :style="{ 'background-color': getBgColor(fieldSub.content.ct_risk_id) }">
                                                                                    <template
                                                                                        v-slot:item="{ props, item }">
                                                                                        <v-list-item v-bind="props"
                                                                                            :title="item.raw.ct_risk"
                                                                                            :style="{ 'background-color': item.raw.ct_color }"
                                                                                            value="ct_risk"></v-list-item>
                                                                                    </template>
                                                                                </v-autocomplete>
                                                                            </v-col>
                                                                        </v-row>
                                                                        <!-- Comments Field -->
                                                                        <p class="mt-3 text-grey">
                                                                            Comentarios:
                                                                        </p>
                                                                        <v-row>
                                                                            <v-col cols="12" lg="8">
                                                                                <QuillEditor
                                                                                    v-model:content="fieldSub.content.inspection_form_comments"
                                                                                    theme="snow" toolbar="essential"
                                                                                    heigth="100%" contentType="html"
                                                                                    @click="getSuggestions(fieldSub)" />
                                                                            </v-col>
                                                                            <v-col cols="12" lg="4">
                                                                                <v-card class="mx-auto border"
                                                                                    color="primary" variant="outlined">
                                                                                    <v-card-subtitle
                                                                                        class="mt-2 mb-0"><span
                                                                                            class="mdi mdi-lightbulb-on-outline"></span>
                                                                                        Sugerencias</v-card-subtitle>
                                                                                    <v-card-text
                                                                                        class="py-1 card-suggestions overflow-y-auto"
                                                                                        v-if="!fieldSub.loadingSuggestions">
                                                                                        <v-card variant="tonal"
                                                                                            class="my-1"
                                                                                            v-for="(sueggest, idx_sueggest) in fieldSub.suggestions"
                                                                                            :key="idx_sueggest"
                                                                                            @click="setComment(fieldSub, sueggest)">
                                                                                            <div class="m-1"
                                                                                                v-html="sueggest"></div>
                                                                                        </v-card>
                                                                                    </v-card-text>
                                                                                    <v-skeleton-loader type="paragraph"
                                                                                        v-else></v-skeleton-loader>
                                                                                    <v-card-text
                                                                                        class="pt-0 card-suggestions overflow-y-auto"
                                                                                        v-if="!fieldSub.suggestions">No
                                                                                        hay sugerencias</v-card-text>
                                                                                </v-card>
                                                                            </v-col>
                                                                        </v-row>

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
            ct_risks: [],
            suggestions: [],
            failures: []
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
                            this.getSuggestions(field);
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
        getFailures() {
            axios.get('api/failures')
                .then(response => {
                    this.failures = response.data.data;
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
        async getSuggestions(field) {
            field.loadingSuggestions = true;
            await axios.get('api/inspection/forms/get-field-suggestions/' + field.ct_inspection_form_uuid)
                .then(response => {
                    field.loadingSuggestions = false;
                    field.suggestions = response.data.data;
                })
                .catch(error => {
                    field.loadingSuggestions = false;
                    this.handleErrors(error);
                });
        },
        setComment(field, comment) {
            field.content.inspection_form_comments = comment;
        },
    },
    mounted() {
        this.getForm();
        this.getRisks();
        this.getFailures();
    }
}
</script>

<style>
@media screen and (min-width: 375px) {
    .padding-0 {
        padding: 0px !important;
    }
}

.ql-toolbar.ql-snow {
    border-radius: 5px 5px 0px 0px !important;
}

.ql-container {
    border-radius: 0px 0px 5px 5px !important;
    height: auto !important;
}

.card-suggestions {
    max-height: 200px !important;
}

.sticky-subtitle {
    position: sticky;
    top: 0;
    z-index: 999;
    /* Asegura que el subtítulo esté por encima del contenido */
    background-color: white;
    /* Mantén el mismo color de fondo para el subtítulo */
}
</style>