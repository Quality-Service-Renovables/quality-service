<template>
    <div>
        <div id="tui-image-editor-container" class="w-100"></div>
        <div class="text-center">
            <PrimaryButton @click="saveImage()" class="mt-2">Guardar
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

export default {
    components: {
        PrimaryButton
    },
    props: {
        evidence: {
            type: String,
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
                theme: whiteTheme, // or whiteTheme
                locale: locale_es_ES,
                // Ocultamos los botones de load y download
            },

            //cssMaxWidth: 700,
            //cssMaxHeight: 500,
        });
    },
    methods: {
        saveImage() {
            console.log("Save image");
            const dataURL = this.imageEditor.toDataURL();
            console.log(dataURL);
            // Enviar dataURL al endpoint
        },
    },
};
</script>


<style scoped></style>