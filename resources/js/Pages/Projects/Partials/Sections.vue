<template>
    <v-card :loading="dialogFormLoading">
        <v-toolbar>
            <v-btn icon="mdi-close" @click="closeSectionDialog()"></v-btn>

            <v-toolbar-title>Carga de información</v-toolbar-title>

            <v-spacer></v-spacer>

            <v-toolbar-items>
                <v-btn text="Guardar" variant="text" @click="dialogForm = false"></v-btn>
            </v-toolbar-items>
        </v-toolbar>

        <v-card-text>
            <v-container>
                <v-row>
                    <v-col cols="12">
                        <v-expansion-panels multiple v-model="expandedPanel">
                            <v-expansion-panel v-for="(section, indexSection) in sectionsForm" :key="indexSection"
                                class="my-5" :expanded="true">

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
                                            class="my-5">
                                            <v-card-title>
                                                {{ field.ct_inspection_form }}
                                            </v-card-title>
                                            <v-card-subtitle>
                                                Campo {{ field.required ? '*Requerido' :
        'Opcional'
                                                }}
                                            </v-card-subtitle>
                                            <v-card-text>
                                                <QuillEditor v-model:content="field.content" theme="snow"
                                                    toolbar="essential" heigth="100%" contentType="html" />
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
                                                        <v-card v-for="(fieldSub, indexFieldSub) in subSection.fields"
                                                            :key="indexFieldSub" class="my-5">
                                                            <v-card-title>
                                                                {{
        fieldSub.ct_inspection_form
    }}
                                                            </v-card-title>
                                                            <v-card-subtitle>
                                                                Campo {{
            fieldSub.required ?
                '*Requerido' :
                                                                'Opcional' }}
                                                            </v-card-subtitle>
                                                            <v-card-text>
                                                                <QuillEditor v-model:content="fieldSub.content"
                                                                    theme="snow" toolbar="essential" heigth="100%"
                                                                    contentType="html" />
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
</template>

<script>
import { QuillEditor } from '@vueup/vue-quill'

export default {
    components: {
        QuillEditor
    },
    props: {
        dialogForm: {
            type: Boolean,
            required: true
        },
        ct_inspection_uuid: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            dialogFormLoading: false,
            sectionsForm: [],
            expandedPanel: [0,1,2,3,4,5]
        }
    },
    methods: {
        getForm() {
            this.dialogFormLoading = true;
            axios.get('api/inspection/forms/get-form/' + this.ct_inspection_uuid)
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
    },
    mounted() {
        this.getForm();
    }
}
</script>