<template>
    <div class="max-w-7xl mx-auto my-auto sm:px-4 lg:px-6 mt-5 mb-5 pb-5">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <v-row class="d-flex justify-center">
                <v-col cols="12" lg="4">
                    <EvidenceForm :inspection_uuid="inspection_uuid" @getEvidences="getEvidences" />
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" class="text-center">
                    <v-divider></v-divider>
                    <p class="text-h5 mt-4" v-if="evidences.length">Evidencias cargadas</p>
                </v-col>
                <template v-if="!loading">
                    <v-col cols="12" lg="4" v-for="(evidence, index) in evidences" :key="index">
                        <EvidenceForm :inspection_uuid="inspection_uuid" :evidence="evidence"
                            @getEvidences="getEvidences" />
                    </v-col>
                </template>
                <template v-else>
                    <v-col cols="12" lg="4" v-for="i in 3" :key="i">
                        <v-skeleton-loader type="card"></v-skeleton-loader>
                        <v-skeleton-loader type="paragraph" />
                        <v-skeleton-loader type="paragraph" />
                    </v-col>
                </template>
            </v-row>
        </div>
    </div>
</template>

<script>
import EvidenceForm from './EvidenceForm.vue';
import { Toaster, toast } from 'vue-sonner'
import { getInspection } from '@/Functions/api';
// Import Vue FilePond
import vueFilePond from "vue-filepond";

// Import FilePond styles
import "filepond/dist/filepond.min.css";

// Import FilePond plugins
// Please note that you need to install these plugins separately

// Import image preview plugin styles
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

// Import image preview and file type validation plugins
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginImageEdit from "filepond-plugin-image-edit";

// Create component
const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview,
    FilePondPluginImageEdit
);

export default {
    props: {
        inspection_uuid: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            evidences: [],
            loading: false,
        }
    },
    mounted() {
        this.getEvidences();
    },
    methods: {
        async getEvidences() {
            this.loading = true;
            this.evidences = [];
            try {
                this.loading = true;
                const response = await getInspection(this.inspection_uuid);
                this.evidences = response.data.data.evidences;
                this.loading = false;
            } catch (error) {
                this.loading = false;
                this.handleErrors(error);
            }
        },
    },
    components: {
        FilePond,
        Toaster,
        EvidenceForm
    },
};
</script>