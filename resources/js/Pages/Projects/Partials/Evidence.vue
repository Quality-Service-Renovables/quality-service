<template>
    <v-col cols="12" lg="3">
        <EvidenceForm :inspection_uuid="inspection_uuid" @getEvidences="getEvidences"
            :positionAux="evidences.length + 1" :inspection_form_id="inspection_form_id" />
    </v-col>
    <v-col cols="12" lg="9">
        <template v-if="!loading">
            <draggable class="dragArea list-group w-full d-contents mt-0 pt-0" :list="evidences" @change="log">
                <v-row>
                    <v-col cols="12" lg="4" class="list-group-item" v-for="(evidence, index) in evidences"
                        :key="evidence.inspection_evidence_uuid">
                        <EvidenceForm :inspection_uuid="inspection_uuid" :evidence="evidence"
                            @getEvidences="getEvidences" :positionAux="index + 1"
                            :inspection_form_id="inspection_form_id" />
                    </v-col>
                </v-row>
            </draggable>
        </template>
        <template v-else>
            <v-row>
                <v-col cols="12" lg="4" v-for="i in 3" :key="i">
                    <v-skeleton-loader type="card"></v-skeleton-loader>
                    <v-skeleton-loader type="paragraph" />
                    <v-skeleton-loader type="paragraph" />
                </v-col>
            </v-row>
        </template>
    </v-col>
    <!-- Botón flotante -->
    <v-expand-transition>
        <v-btn prepend-icon="mdi-content-save-check" variant="flat" color="primary" class="fab m-5" @click="saveChanges"
            v-show="thereIsChanges" :loading="savingChanges">
            Guardar cambios
        </v-btn>
    </v-expand-transition>
</template>
<script>
import { defineComponent } from 'vue'
import { VueDraggableNext } from 'vue-draggable-next'
import EvidenceForm from './EvidenceForm.vue';
import { Toaster, toast } from 'vue-sonner'
import { getInspection } from '@/Functions/api';
import axios from 'axios';

export default defineComponent({
    components: {
        draggable: VueDraggableNext,
        Toaster,
        EvidenceForm
    },
    props: {
        inspection_uuid: {
            type: String,
            required: true
        },
        inspection_form_id: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            enabled: true,
            dragging: true,
            evidences: [],
            loading: false,
            thereIsChanges: false,
            savingChanges: false
        }
    },
    mounted() {
        this.getEvidences();
    },
    methods: {
        log(event) {
            this.thereIsChanges = true;
        },
        async getEvidences() {
            this.loading = true;
            this.evidences = [];
            try {
                this.loading = true;
                const response = await getInspection(this.inspection_uuid);
                this.evidences = response.data.data.evidences;
                this.evidences = this.evidences.sort((a, b) => a.position - b.position);
                this.loading = false;
            } catch (error) {
                this.loading = false;
                this.handleErrors(error);
            }
        },
        saveChanges() {
            this.savingChanges = true;
            let evidences = this.evidences.map((e, index) => {
                return {
                    inspection_evidence_uuid: e.inspection_evidence_uuid,
                    position: index + 1
                }
            });

            axios.put(`/api/inspection/evidence/positions`, { evidences: evidences })
                .then(() => {
                    this.getEvidences();
                    this.thereIsChanges = false;
                    this.savingChanges = false;
                    toast.success('Cambios guardados correctamente');
                })
                .catch(error => {
                    this.savingChanges = false;
                    this.handleErrors(error);
                });
        },
    },
})
</script>

<style scoped>
.d-contents {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.fab {
    position: fixed;
    bottom: 16px;
    right: 16px;
    z-index: 999;
    border-radius: 20px !important;
}
</style>