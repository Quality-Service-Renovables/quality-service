<template>
    <v-tooltip :text="text" location="top">
        <template v-slot:activator="{ props }">
            <v-btn :icon="icon" v-bind="props" :size="size" class="m-1" @click="handleClick" :class="color"/>
        </template>
    </v-tooltip>
</template>

<script>
export default {
    props: {
        text: {
            type: String,
            required: true
        },
        icon: {
            type: String,
            required: true
        },
        size: {
            type: String,
            default: 'small'
        },
        color: {
            type: String,
            default: 'text-dark'
        }
    },
    methods: {
        handleClick() {
            this.$emit('click');
        }
    }
}
</script>
