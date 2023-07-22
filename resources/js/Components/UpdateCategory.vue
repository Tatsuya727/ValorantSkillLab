<script setup>
import { Inertia } from '@inertiajs/inertia';
import { ref, reactive, watchEffect } from 'vue';
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
    category: {
        type: Object,
        required: true,
    },
    modelValue: {
        type: Boolean,
        required: true,
    },
});

const emit = defineEmits(['update:modelValue']);

watchEffect(() => {
    form.id = props.category.id;
    form.name = props.category.name;
});
</script>

<template></template>
