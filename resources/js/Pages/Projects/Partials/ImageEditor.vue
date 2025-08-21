<template>
    <div>
        <div id="tui-image-editor-container"></div>
        <div class="text-center">
            <PrimaryButton @click="saveImage()" class="mt-2" :loading="form.loading" :disabled="form.loading">Guardar
            </PrimaryButton>
        </div>
    </div>
</template>

<script>
import whiteTheme from '@/Plugins/tui-image-editor/white-theme.js';
import locale_es_ES from '@/Plugins/tui-image-editor/locale_es_ES';
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
        this.imageEditor = new tui.ImageEditor('#tui-image-editor-container', {
            includeUI: {
                loadImage: {
                    path: this.form.evidence_store,
                    name: 'SampleImage',
                },
                theme: {},
                menu: ['crop', 'draw', 'text', 'icon'],
                initMenu: 'draw',
                uiSize: {
                    width: '100%',
                    height: '85vh'
                },
                menuBarPosition: 'right',
                theme: whiteTheme,
                locale: locale_es_ES,
            },
            cssMaxWidth: 600,
            cssMaxHeight: 400,
        });
        this.imageEditor.setBrush({
            width: 10,
            color: '#ff0000'   // rojo
        });
    },
    methods: {
        saveImage() {
            const dataURL = this.imageEditor.toDataURL();
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


<style>
#tui-image-editor-container {
  width: 100%;
  height: 85vh;
}
.tui-image-editor-header-buttons, .tui-image-editor-download-btn, .tui-image-editor-header {
  display: none !important;
}
</style>
