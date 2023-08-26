<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, useForm } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const emailError = ref(null);

const submit = () => {
    Inertia.post(route('password.email'), form, {
        onSuccess: () => {
            form.reset();
            console.log('onSuccess');
        },
        onError: (errors) => {
            console.log('onError');
            emailError.value = errors.email;
        },
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Forgot Password" />

        <v-row class="mb-4 text-sm text-gray-600">
            <v-col cols="12"> パスワードを忘れた場合は、登録したメールアドレスを入力してください。パスワード再設定用のリンクを送信します。 </v-col>
        </v-row>

        <v-row v-if="status" class="mb-4 font-medium text-sm text-green-600">
            <v-col cols="12">
                {{ status }}
            </v-col>
        </v-row>

        <v-form>
            <v-row>
                <v-col cols="12">
                    <v-text-field label="Email" id="email" type="email" v-model="form.email" required autofocus autocomplete="username" :error-messages="form.errors.email"></v-text-field>
                </v-col>
                <!-- エラーメッセージ -->
                <div v-if="emailError" class="text-red" v-for="error in emailError">・{{ error }}</div>
            </v-row>

            <v-row class="flex items-center justify-end mt-4">
                <v-col cols="12" class="text-right">
                    <v-btn @click="submit" color="primary"> パスワードを再設定する </v-btn>
                </v-col>
            </v-row>
        </v-form>
    </GuestLayout>
</template>
