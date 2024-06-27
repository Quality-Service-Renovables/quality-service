<template>
    <div class="max-w-7xl mx-auto my-auto sm:px-4 lg:px-6 mt-5 mb-5 pb-5">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <v-row class="d-flex justify-center">
                <v-col cols="12" lg="4">
                    <EvidenceForm :inspection_uuid="inspection_uuid" @getEvidences="getEvidences" :position="evidences.length+1"/>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" class="text-center">
                    <v-divider></v-divider>
                    <p class="text-h5 mt-4" v-if="evidences.length">Evidencias cargadas</p>
                </v-col>
                <v-row v-if="!loading">
                    <draggable class="dragArea list-group w-full row wrap d-contents" :list="evidences" @change="log">
                        <v-col cols="12" lg="4" class="list-group-item" v-for="(evidence, index) in evidences"
                            :key="evidence.inspection_evidence_uuid">
                            <EvidenceForm :inspection_uuid="inspection_uuid" :evidence="evidence"
                                @getEvidences="getEvidences" :position="index+1"/>
                        </v-col>
                    </draggable>
                </v-row>
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
import { defineComponent } from 'vue'
import { VueDraggableNext } from 'vue-draggable-next'

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
export default defineComponent({
    components: {
        draggable: VueDraggableNext,
        FilePond,
        Toaster,
        EvidenceForm
    },
    props: {
        inspection_uuid: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            enabled: true,
            list: [
                { name: 'John', id: 1 },
                { name: 'Pros', id: 2 },
                { name: 'Rosi', id: 3 },
                { name: 'Gerard', id: 4 },
            ],
            dragging: true,
            evidences: [],
            loading: false,
        }
    },
    mounted() {
        this.getEvidences();
    },
    methods: {
        log(event) {
            console.log(event)
        },
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
})
</script>

<style scoped>
.d-contents {
    display: contents;
}
</style>