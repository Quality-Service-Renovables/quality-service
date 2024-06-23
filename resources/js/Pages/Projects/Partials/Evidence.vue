<template>
    <v-row class="d-flex justify-center">
        <v-col cols="4">
            <EvidenceForm :inspection_uuid="inspection_uuid" />
        </v-col>
    </v-row>
    <v-row class="my-4">
        <v-col cols="12"><p class="text-h5 text-center">Evidencias cargadas</p></v-col>
        <v-col cols="4" v-for="(evidence, index) in evidences" :key="index">
            <EvidenceForm :inspection_uuid="inspection_uuid" />
        </v-col>
    </v-row>
</template>

<script>
import EvidenceForm from './EvidenceForm.vue';
import { Toaster, toast } from 'vue-sonner'
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
            evidences: []
        }
    },
    mounted() {
        this.getEvidences();
    },
    methods: {
        getEvidences() {
            //axios.get('api/inspection/evidences' + this.inspection_uuid)
            axios.get('api/inspection/evidences')
                .then(response => {
                    this.evidences = response.data.data;
                })
                .catch(error => {
                    this.handleErrors(error);
                });
        },
    },
    components: {
        FilePond,
        Toaster,
        EvidenceForm
    },
};
</script>