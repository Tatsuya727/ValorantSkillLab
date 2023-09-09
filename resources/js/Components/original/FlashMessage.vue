<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    flash: Object,
});

// props.flashが変更されたらsnackbarを表示
watch(
    () => props.flash,
    () => {
        snackbar.value = true;
    }
);
const snackbar = ref(false);

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
