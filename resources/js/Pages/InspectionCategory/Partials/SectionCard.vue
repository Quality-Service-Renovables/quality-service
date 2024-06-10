<template>
    <div class="d-flex">
        <v-icon class="mdi mdi-subdirectory-arrow-right mt-4"></v-icon>
        <v-card class="w-100 mb-5" rounded="lg" border="dashed thin dark md">
            <v-card-title class="bg-blue-grey">
                <div class="d-flex justify-between">
                    <p class="text-h6 mr-2">{{ title }}</p>
                    <div class="bg-white rounded-xl border-0 px-2">
                        <v-btn density="compact" icon="mdi-plus" variant="plain" class="me-1" color="primary"
                            @click="dialog = true"></v-btn>
                        <v-btn density="compact" icon="mdi-pencil" variant="plain" class="me-1"></v-btn>
                        <v-btn density="compact" icon="mdi-trash-can" variant="plain" class="me-1" color="red"
                            @click="deleteSection"></v-btn>
                    </div>
                </div>
            </v-card-title>
            <v-card-text>
                <slot></slot>
            </v-card-text>
        </v-card>

        <v-dialog v-model="dialog" width="auto">
            <v-card min-width="400">
                <v-card-title>
                    <p v-if="type == 'section'">Nueva sección o campo</p>
                    <p v-if="type == 'sub_section'">Nuevo campo</p>
                </v-card-title>
                <v-card-text>
                    <v-row dense>
                        <v-col cols="12">
                            <v-text-field label="Nombre*" variant="outlined" required hide-details
                                v-model="sectionForm.name"></v-text-field>
                        </v-col>
                        <v-col cols="12" v-if="type == 'section'">
                            <v-select label="Tipo*" variant="outlined" required hide-details v-model="sectionForm.type"
                                :items="types" item-title="name" item-value="id"></v-select>
                        </v-col>
                        <v-col cols="12" v-if="sectionForm.type === 'field' && type == 'section'">
                            <v-checkbox label="Requerido" v-model="sectionForm.required"></v-checkbox>
                        </v-col>
                    </v-row>
                </v-card-text>
                <template v-slot:actions>
                    <v-btn class="ms-auto" text="Cancelar" @click="dialog = false"></v-btn>
                    <v-btn color="primary" text @click="save">Guardar</v-btn>
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
            dialog: false,
            types: [
                { id: 'field', name: 'Campo' },
                { id: 'section', name: 'Sección' },
            ],
            sectionForm: {
                name: '',
                type: 'section',
                required: true
            },
        };
    },
    mounted() {
        if (this.type == 'sub_section') {
            this.sectionForm.type = 'field';
        }
    },
    methods: {
        async save() {
            let ct_inspection_relation_uuid = this.type == 'section' ? this.section.section_details.ct_inspection_section_uuid : this.section.ct_inspection_section_uuid;
            if (this.type == 'sub_section') {
                this.sectionForm.type = 'field';
            }
            console.log("Inspection:");
            console.log(this.inspection.ct_inspection_uuid);
            console.log("Section:");
            console.log(this.sectionForm.name);
            console.log("Padre:");
            console.log(ct_inspection_relation_uuid);

            if (this.sectionForm.type === 'section') {
                await this.saveSection(ct_inspection_relation_uuid);
                this.resetForm();
                console.log("Entro a sección");
            } else if (this.sectionForm.type === 'field') {
                console.log("Entro a campo");
                await this.saveField(ct_inspection_relation_uuid);
                await this.updateSections();
                this.resetForm();
            }
        },
        saveSection(ct_inspection_relation_uuid) {
            this.$emit('save-section', this.inspection.ct_inspection_uuid, this.sectionForm.name, ct_inspection_relation_uuid);
        },
        updateSections() {
            this.$emit('update-sections');
        },
        resetForm() {
            this.dialog = false;
            this.sectionForm.name = '';
            this.sectionForm.type = 'section';
            this.sectionForm.required = true;
        },
        async saveField(ct_inspection_relation_uuid) {
            const postRequest = () => {
                return axios.post('api/inspection/forms/set-form-fields', {
                    ct_inspection_section_uuid: ct_inspection_relation_uuid,
                    fields: [
                        {
                            ct_inspection_form: this.sectionForm.name,
                            required: this.sectionForm.required
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
        }
    }
}
</script>