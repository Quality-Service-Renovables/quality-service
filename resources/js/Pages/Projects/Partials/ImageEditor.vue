<template>
    <div>
        <div id="tui-image-editor-container" class="w-100"></div>
        <div class="text-center">
            <PrimaryButton @click="saveImage()" class="mt-2" :loading="form.loading" :disabled="form.loading">Guardar
            </PrimaryButton>
        </div>
    </div>
</template>

<script>
import ImageEditor from 'tui-image-editor';
import 'tui-image-editor/dist/tui-image-editor.css';
import whiteTheme from '@/Plugins/tui-image-editor/white-theme.js';
import locale_es_ES from '@/Plugins/tui-image-editor/locale_es_ES';
import '@/Plugins/tui-image-editor/service-mobile.css';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Toaster, toast } from 'vue-sonner'

export default {
    components: {
        PrimaryButton,
        Toaster
    },
    props: {
        evidence: {
            type: String,
            required: true
        },
        form: {
            type: Object,
            required: true
        },
        editImage: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            imageEditor: null,
        };
    },
    mounted() {
        this.imageEditor = new ImageEditor(document.querySelector('#tui-image-editor-container'), {
            includeUI: {
                loadImage: {
                    path: this.evidence.inspection_evidence,
                    name: 'SampleImage',
                },
                menu: ['crop', 'text', 'draw'],
                initMenu: 'draw',
                uiSize: {
                    width: '100%',
                    height: '700px',
                },
                menuBarPosition: 'bottom',
                theme: whiteTheme,
                locale: locale_es_ES,
            },
        });
    },
    methods: {
        saveImage() {
            const dataURL = this.imageEditor.toDataURL();
            // Convertimos el dataURL a un objeto File
            const blob = this.dataURLtoBlob(dataURL);
            const file = new File([blob], 'image.png', { type: 'image/png' });
            this.form.evidence_store = file;
            this.updateImage();
        },
        dataURLtoBlob(dataURL) {
            const byteString = atob(dataURL.split(',')[1]);
            const mimeString = dataURL.split(',')[0].split(':')[1].split(';')[0];
            const ab = new ArrayBuffer(byteString.length);
            const ia = new Uint8Array(ab);
            for (let i = 0; i < byteString.length; i++) {
                ia[i] = byteString.charCodeAt(i);
            }
            return new Blob([ab], { type: mimeString });
        },
        updateImage() {
            this.form.loading = true;
            axios.post('api/inspection/evidences/update/' + this.evidence.inspection_evidence_uuid, this.form, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
            })
                .then(response => {
                    this.form.loading = false;
                    toast.success("Imagen actualizada correctamente.");
                    this.$emit('closeEditImageDialog');
                    this.$emit('setEvidence', response.data.data);
                })
                .catch(thrown => {
                    this.form.loading = false;
                    toast.error('Error al actualizar la imagen.');
                    this.handleErrors(thrown);
                });
        }
    },
};
</script>


<style scoped></style>