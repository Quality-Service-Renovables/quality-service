<template>
    <div class="max-w-7xl mx-auto sm:px-4 lg:px-6 mb-5 pb-5">
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <v-form ref="form">
                <v-card :loading="loading" :disabled="loading">
                    <v-card-text>
                        <p class="text-grey mb-2 text-h5 font-weight-bold">
                            Información del proyecto
                        </p>
                        <p class="text-primary">Rellena la información relacionada a la inspección a realizar.</p>
                        <v-divider class="my-3"></v-divider>
                        <v-row>
                            <v-col cols="12">
                                <v-autocomplete v-model="inspection_form.ct_inspection_code" :items="inspections"
                                    item-title="ct_inspection" item-value="ct_inspection_code"
                                    label="Seleccionar inspección" variant="outlined" hide-details
                                    required :rules="rules"></v-autocomplete>
                            </v-col>
                            <v-col cols="12" lg="6">
                                <v-autocomplete v-model="inspection_form.ct_equipment_uuid"
                                    :items="inspectionsEquipmentsCategories" item-title="ct_equipment"
                                    item-value="ct_equipment_uuid"
                                    label="Seleccionar categoría de equipo a inspeccionar" variant="outlined"
                                    hide-details required
                                    @update:modelValue="setEquipmentFields(inspection_form.ct_equipment_uuid)"></v-autocomplete>
                            </v-col>
                            <v-col cols="12" lg="6">
                                <v-autocomplete v-model="inspection_form.equipments_uuid" :items="equipmentsByCategory"
                                    item-title="equipment" item-value="equipment_uuid"
                                    label="Seleccionar equipos a utilizar en la inspección" variant="outlined"
                                    hide-details multiple chips clearable required :rules="rules"></v-autocomplete>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field v-model="inspection_form.location" label="Ubicación" variant="outlined"
                                    hide-details required :rules="rules"></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <p class="text-grey mb-1">Define el resumen de la inspección a
                                    realizar (opcional)
                                </p>
                                <QuillEditor v-model:content="inspection_form.resume" theme="snow" toolbar="essential"
                                    heigth="100%" contentType="html" />
                            </v-col>
                            <v-col cols="12">
                                <v-row v-if="inspection_form.fields && inspection_form.fields.length">
                                    <v-col cols="12">
                                        <p class="text-primary">Define los datos del equipo a
                                            inspeccionar.
                                        </p>
                                    </v-col>
                                    <v-col cols="12" lg="6" v-for="(field, index) in inspection_form.fields" v-show="field.active"
                                        :key="index">
                                        <v-text-field v-model="field.value"
                                            :label="field.name + ' (' + isRequiredLabel(field.required) + ')'"
                                            variant="outlined" hide-details
                                            :rules="field.required ? rules : []"></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row v-else>
                                    <v-col cols="12">
                                        <p class="text-red mb-2">*No se han definido campos para
                                            la
                                            categoría seleccionada</p>
                                    </v-col>
                                </v-row>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <p class="text-primary mb-2">Define la Escala de condición.</p>
                                <p class="text-grey mb-1">Escala de condición
                                </p>
                                <QuillEditor v-model:content="inspection_form.escala_condicion" theme="snow"
                                    toolbar="essential" heigth="100%" contentType="html" />
                                <p class="mt-3 text-grey">
                                    Riesgo:</p>
                                <v-autocomplete v-model="inspection_form.ct_risk_id" :items="ct_risks"
                                    item-title="ct_risk" item-value="ct_risk_id" variant="outlined" hide-details
                                    class="w-50 rounded" density="compact"
                                    :style="{ 'background-color': getBgColor(inspection_form.ct_risk_id) }">
                                    <template v-slot:item="{ props, item }">
                                        <v-list-item v-bind="props" :title="item.raw.ct_risk"
                                            :style="{ 'background-color': item.raw.ct_color }"
                                            value="ct_risk"></v-list-item>
                                    </template>
                                </v-autocomplete>
                            </v-col>
                        </v-row>
                        <PrimaryButton @click="asignInspection($event)" :disabled="false" :loading="false" class="mt-3">
                            Guardar
                        </PrimaryButton>
                    </v-card-text>
                </v-card>
            </v-form>
        </div>
    </div>
</template>

<script>
import { toast } from 'vue-sonner'
import { getInspection } from '@/Functions/api';
import { QuillEditor } from '@vueup/vue-quill'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import '@vueup/vue-quill/dist/vue-quill.snow.css';

export default {
    components: {
        QuillEditor,
        PrimaryButton
    },
    props: {
        inspection_uuid: String,
        project: Object,
    },
    data() {
        return {
            isUpdating: false,
            loading: false,
            inspection_form: {
                inspection_uuid: null,
                resume: '',
                recomendations: '',
                ct_inspection_code: '',
                status_code: '',
                client_uuid: '',
                project_uuid: '',
                fields: [],
            },
            inspections: [],
            inspectionsEquipmentsCategories: [],
            inspectionsEquipmentsToUseInInspections: [],
            loadingInspectionAsignin: false,
            errorAssigningInspection: false,
            equipmentsByCategory: [],
            ct_risks: [],
            rules: [
                value => {
                    if (value) return true
                    return 'Este campo es requerido.'
                },
            ],
        }
    },
    mounted() {
        this.getInspections();
        this.getinspectionsEquipmentsCategories();
        this.getRisks();
        if (this.inspection_uuid !== null) {
            this.isUpdating = true;
            this.getInspection();
        }
    },
    methods: {
        getInspections() {
            axios.get('api/inspection/categories')
                .then(response => {
                    this.inspections = response.data.data;
                })
                .catch(error => {
                    this.handleErrors(error);
                });
        },
        async getInspection() {
            try {
                this.loading = true;
                const response = await getInspection(this.inspection_uuid);
                this.inspection_form = response.data.data;
                this.inspection_form.ct_inspection_code = this.inspection_form.category.ct_inspection_code;
                this.inspection_form.ct_equipment_uuid = this.inspection_form.inspection_equipments.length > 0 ? this.inspection_form.inspection_equipments[0].equipment.category.ct_equipment_uuid : null;
                this.inspection_form.equipments_uuid = this.inspection_form.inspection_equipments.map(equipment => equipment.equipment.equipment_uuid);
                this.setEquipmentFields(this.inspection_form.ct_equipment_uuid);
                this.loading = false;
            } catch (error) {
                this.loading = false;
                this.handleErrors(error);
            }
        },
        getinspectionsEquipmentsCategories() {
            axios.get('api/equipment/categories')
                .then(response => {
                    this.inspectionsEquipmentsCategories = response.data.data;
                    this.inspectionsEquipmentsToUseInInspections = this.inspectionsEquipmentsCategories
                        .filter(item => item.ct_equipment_code === 'inspeccion')
                    this.inspectionsEquipmentsToUseInInspections = this.inspectionsEquipmentsToUseInInspections.length ? this.inspectionsEquipmentsToUseInInspections[0].equipments : [];
                })
                .catch(error => {
                    this.handleErrors(error);
                });
        },
        setEquipmentFields(ct_equipment_uuid) {
            console.log("Entro a setEquipmentFields");
            console.log("ct_equipment_uuid: " + ct_equipment_uuid);


            if (ct_equipment_uuid) {
                this.inspection_form.fields = null;
                //this.inspection_form.equipments_uuid = [];
                let equipments = this.inspectionsEquipmentsCategories.find(category => category.ct_equipment_uuid === ct_equipment_uuid);
                this.inspection_form.fields = equipments.required_fields_report && equipments.required_fields_report.length > 0 ? JSON.parse(equipments.required_fields_report).fields : [];
                let fields = this.inspection_form.equipment_fields_report != null ? JSON.parse(this.inspection_form.equipment_fields_report) : null;

                this.inspection_form.fields.forEach(field => {
                    if (fields && fields.length > 0) {
                        let fieldReport = fields.find(f => f.key === field.key);
                        field.value = fieldReport ? fieldReport.value : '';
                    } else {
                        field.value = '';
                    }
                });
                this.equipmentsByCategory = equipments.equipments.length > 0 ? equipments.equipments : [];
            }
        },
        isRequiredLabel(required) {
            return required ? 'Requerido' : 'Opcional';
        },
        async asignInspection(e) {
            e.preventDefault();
            const { valid } = await this.$refs.form.validate()

            if (valid) {
                console.log("Asignar inspección");
                this.loadingInspectionAsignin = true;
                try {
                    await this.createInspection();
                    await this.asignEquipmentToInspection();
                } catch (error) {
                    toast.error('Error al asignar inspección, favor de verificar los datos ingresados.');
                }
                this.loadingInspectionAsignin = false;

                if (!this.errorAssigningInspection) {
                    console.log("this.errorAssigningInspection: " + this.errorAssigningInspection);
                    this.$inertia.reload();
                }
            } else {
                toast.error('Parece que faltan algunos campos por rellenar.');
            }
        },
        createInspection() {
            return new Promise((resolve, reject) => {
                let request = null;
                if (!this.isUpdating) {
                    console.log("Creando inspección");
                    let formData = {
                        resume: this.inspection_form.resume,
                        ct_inspection_code: this.inspection_form.ct_inspection_code,
                        status_code: this.inspection_form.status_code,
                        equipment_uuid: this.inspection_form.equipment_uuid,
                        project_uuid: this.project.project_uuid,
                        client_uuid: this.project.client.client_uuid,
                        location: this.inspection_form.location,
                        equipment_fields_report: JSON.stringify(this.inspection_form.fields),
                        escala_condicion: this.inspection_form.escala_condicion,
                        ct_risk_id: this.inspection_form.ct_risk_id
                    }
                    request = () => {
                        return axios.post('api/inspections', formData);
                    };
                } else {
                    console.log("Actualizando inspección");
                    request = () => {
                        return axios.put('api/inspections/' + this.inspection_form.inspection_uuid, formData);
                    };
                    let formData = {
                        resume: this.inspection_form.resume,
                        ct_inspection_code: this.inspection_form.ct_inspection_code,
                        status_code: this.inspection_form.status_code,
                        equipment_uuid: this.inspection_form.equipment_uuid,
                        project_uuid: this.project.project_uuid,
                        client_uuid: this.project.client.client_uuid,
                        location: this.inspection_form.location,
                        equipment_fields_report: JSON.stringify(this.inspection_form.fields),
                        escala_condicion: this.inspection_form.escala_condicion,
                        ct_risk_id: this.inspection_form.ct_risk_id
                    }
                }

                toast.promise(request(), {
                    loading: !this.isUpdating ? 'Asignando inspección...' : 'Actualizando inspección...',
                    success: (data) => {
                        this.inspection_form.inspection_uuid = data.data.data.inspection_uuid;
                        this.$emit('setInspectionUuid', this.inspection_form.inspection_uuid);
                        let label = !this.isUpdating ? 'Inspección asignada correctamente' : 'Inspección actualizada correctamente';
                        resolve(label);
                        return label;
                    },
                    error: (data) => {
                        this.errorAssigningInspection = true;
                        this.handleErrors(data);
                        reject(data);
                    }
                });
            });
        },
        asignEquipmentToInspection() {
            return new Promise((resolve, reject) => {
                let equipments = this.inspection_form.equipments_uuid.map(equipment => {
                    return {
                        equipment_uuid: equipment
                    };
                });
                const request = () => {
                    if (!this.isUpdating) {
                        return axios.post('api/inspection/equipments', {
                            inspection_uuid: this.inspection_form.inspection_uuid,
                            equipments: equipments
                        });
                    } else {
                        return axios.put('api/inspection/equipments/' + this.inspection_form.inspection_uuid, {
                            inspection_uuid: this.inspection_form.inspection_uuid,
                            equipments: equipments
                        });
                    }

                };
                toast.promise(request(), {
                    loading: !this.isUpdating ? 'Asignando equipos a inspección...' : 'Actualizando equipos de inspección...',
                    success: (data) => {
                        let label = !this.isUpdating ? 'Asignación completada correctamente' : 'Actualización completada correctamente';
                        resolve(label);
                        return label;
                    },
                    error: (data) => {
                        this.errorAssigningInspection = true;
                        this.handleErrors(data);
                        reject(data);
                    }
                });
            });
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
    }
}
</script>