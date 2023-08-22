<script setup>
import { ref } from 'vue';

const { flash } = defineProps({
    flash: Object,
});

const snackbar = ref(flash && flash.message ? true : false);

const timeout = ref(5000);
</script>

<template>
    <div class="text-center">
        <v-snackbar v-model="snackbar" :timeout="timeout" color="white" elevation="24">
            <div v-if="flash">
                {{ flash.message }}
            </div>
        </v-snackbar>
    </div>
</template>
