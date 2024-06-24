<template>
    <v-card class="mx-auto">
        <file-pond name="evidence" ref="pond"
            label-idle="Arrastra y suelta tu archivo o <span class='filepond--label-action'>selecciona</span>"
            :allow-multiple="false" accepted-file-types="image/jpeg, image/png" :files="myFiles"
            @init="handleFilePondInit" :server="serverConfig" instantUpload="false" allowProcess="true"
            allowReplace="true" allowImagePreview="true" 
            labelInvalidField="Tipo de archivo no permitido"
            labelFileLoading="Cargando"
            labelFileLoadError="Error al subir el archivo"
            labelFileProcessing="Procesando"
            labelFileProcessingComplete="Proceso completado"
            labelFileProcessingAborted="Proceso abortado"
            labelFileProcessingError="Error al procesar"
            labelTapToCancel="Toca para cancelar"
            labelTapToRetry="Toca para reintentar"
            labelTapToUndo="Toca para deshacer"
            labelButtonAbortItemLoad = "Cancelar"
            labelButtonRetryItemLoad = "Reintentar"
            labelButtonAbortItemProcessing="Cancelar"
            labelButtonProcessItem="Subir"
            />

        <v-card-title>
            <v-text-field label="Título" v-model="form.title" variant="outlined" hide-details
                density="compact"></v-text-field>
        </v-card-title>
        <!--<v-card-title>
            <v-text-field label="Título secundario" v-model="form.title_secondary" variant="outlined" hide-details
                density="compact"></v-text-field>
        </v-card-title>-->
        <v-card-title>
            <v-textarea label="Descripción" v-model="form.description" variant="outlined" rows="2" hide-details
                density="compact"></v-textarea>
        </v-card-title>
        <!--<v-card-title>
            <v-textarea label="Descripción secundaría" v-model="form.description_secondary" variant="outlined" rows="2"
                hide-details density="compact"></v-textarea>
        </v-card-title>-->
    </v-card>
</template>

<script>
import { Toaster, toast } from 'vue-sonner'
// Import Vue FilePond
import vueFilePond from "vue-filepond";
import axios from 'axios';
// Import FilePond styles
import "filepond/dist/filepond.min.css";
// Import image preview plugin styles
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

// Import image preview and file type validation plugins
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";

// Create component
const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview,
);
export default {
    props: {
        inspection_uuid: {
            type: String,
            required: true
        },
        evidence: {
            type: Object,
            required: false
        }
    },
    data() {
        return {
            myFiles: [],
            action: 'create',
            form: {
                inspection_uuid: this.inspection_uuid,
                evidence_store: null,
                evidence_store_secondary: null,
                title: 'Título',
                title_secondary: null,
                description: 'Descripción',
                description_secondary: null,
                inspection_evidence_secondary: null,
            },
            formDefault: {
                inspection_uuid: this.inspection_uuid,
                evidence_store: null,
                evidence_store_secondary: null,
                title: 'Título',
                title_secondary: null,
                description: 'Descripción',
                description_secondary: null,
                inspection_evidence_secondary: null,
            },
            serverConfig: {
                process: (fieldName, file, metadata, load, error, progress, abort) => {
                    this.form.evidence_store = file;

                    // Create a CancelToken source
                    const CancelToken = axios.CancelToken;
                    const source = CancelToken.source();

                    if (!this.form.title) {
                        toast.error("El título es requerido");
                        this.abort(source);
                    }

                    this.save(source, load, error, progress);
                }
            }
        };
    },
    mounted() {
        if (this.evidence) {
            this.action = 'update';
            this.form.evidence_store = this.evidence.inspection_evidence;
            //this.form.evidence_store_secondary = this.evidence.inspection_evidence_secondary;
            this.form.title = this.evidence.title;
            //this.form.title_secondary = this.evidence.title_secondary;
            this.form.description = this.evidence.description;
            //this.form.description_secondary = this.evidence.description_secondary;
            this.myFiles = [
                {
                    source: this.evidence.inspection_evidence,
                    options: {
                        type: 'remote',
                    },
                },
            ];
        }
    },
    methods: {
        handleFilePondInit() {
            // FilePond instance methods are available on `this.$refs.pond`
        },
        save(source, load, error, progress) {
            // Send the file to the backend using axios
            axios.post('api/inspection/evidences', this.form, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
                cancelToken: source.token,
                onUploadProgress: (e) => {
                    progress(e.lengthComputable, e.loaded, e.total);
                }
            })
                .then(response => {
                    load(response.data.fileId);
                    setTimeout(() => {
                        this.myFiles = [];
                        this.form = this.formDefault;
                        this.$emit('getEvidences');
                    }, 2000);
                })
                .catch(thrown => {
                    if (axios.isCancel(thrown)) {
                        this.abort(source);
                    } else {
                        error('Error al subir la información.');
                        this.handleErrors(thrown);
                    }
                });
        },
        abort() {
            source.cancel('Operación cancelada por el usuario.');
        }
    },
    components: {
        FilePond,
        Toaster
    },
};
</script>



<style scoped></style>