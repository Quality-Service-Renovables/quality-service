<template>
    <div class="max-w-7xl mx-auto sm:px-4 lg:px-6 mb-5 pb-5">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <v-card-text>
                <p class="text-grey mb-2 text-h5 font-weight-bold">
                    Define las
                    conclusiones y recomendaciones de la
                    inspección realizada
                </p>
                <v-divider></v-divider>
            </v-card-text>
            <v-card-text>
                <p class="text-grey mb-2 text-h6">Conclusiones:</p>
                <QuillEditor v-model:content="inspection_form.conclusion" theme="snow" toolbar="essential" heigth="100%"
                    contentType="html" v-if="!loading" />
                <v-skeleton-loader type="paragraph" v-else></v-skeleton-loader>
            </v-card-text>
            <v-card-text>
                <p class="text-grey mb-2 text-h6">Recomendaciones:</p>
                <QuillEditor v-model:content="inspection_form.recomendations" theme="snow" toolbar="essential"
                    heigth="100%" contentType="html" v-if="!loading" />
                <v-skeleton-loader type="paragraph" v-else></v-skeleton-loader>
            </v-card-text>
            <v-card-text v-if="!loading">
                <PrimaryButton @click="save">Guardar</PrimaryButton>
            </v-card-text>
        </div>
    </div>
</template>

<script>
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Toaster, toast } from 'vue-sonner'
import { getInspection } from '@/Functions/api';

export default {
    components: {
        QuillEditor,
        PrimaryButton,
        Toaster
    },
    props: {
        inspection_uuid: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            loading: false,
            inspection_form: {
                resume: '',
                conclusion: '',
                recomendations: '',
                ct_inspection_code: '',
                equipment_uuid: '',
                status_code: '',
                client_uuid: '',
                project_uuid: '',
            }
        }
    },
    mounted() {
        this.getInspection();
    },
    methods: {
        async getInspection() {
            try {
                this.loading = true;
                const response = await getInspection(this.inspection_uuid);
                this.inspection_form = response.data.data;
                this.loading = false;
            } catch (error) {
                this.loading = false;
                this.handleErrors(error);
            }
        },
        save() {
            let formData = {
                resume: this.inspection_form.resume ?? 'Por definir',
                conclusion: this.inspection_form.conclusion ?? 'Por definir',
                recomendations: this.inspection_form.recomendations ?? 'Por definir',
                ct_inspection_code: this.inspection_form.category.ct_inspection_code,
                equipment_uuid: this.inspection_form.equipment.equipment_uuid,
                status_code: this.inspection_form.status.status_code,
                client_uuid: this.inspection_form.client.client_uuid,
                project_uuid: this.inspection_form.project.project_uuid,
            }

            let request = () => {
                return axios.put('api/inspections/' + this.inspection_uuid, formData);
            };

            toast.promise(request(), {
                loading: 'Guardando...',
                success: (data) => {
                    this.getInspection();
                    return 'Guardado correctamente';
                },
                error: (data) => {
                    this.handleErrors(data);
                }
            });
        }
    },
}
</script>