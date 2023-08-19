<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import NavBar from '@/Components/original/NavBar.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onError: (errors) => {
            console.log(errors);
            console.log(errors.email);
            console.log(errors.password);
        },
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <v-app>
        <NavBar />
        <GuestLayout>
            <Head title="ログイン" />
            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>
            <v-form @submit.prevent="submit">
                <v-text-field label="メールアドレス" v-model="form.email" required autofocus autocomplete="username" :error-messages="form.errors.email"></v-text-field>
                <v-text-field label="パスワード" type="password" v-model="form.password" required autocomplete="current-password" :error-messages="form.errors.password"></v-text-field>
                <v-checkbox v-model="form.remember" label="ログインしたままにする"></v-checkbox>
                <div class="flex items-center justify-end mt-4">
                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        パスワードをお忘れの場合
                    </Link>
                    <v-btn :disabled="form.processing" class="ml-4" @click="submit"> ログイン </v-btn>
                </div>
            </v-form>
            <!-- google login -->
            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login.google')" class="ml-4">
                    <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png" style="margin-left: 3em" />
                </Link>
            </div>
        </GuestLayout>
    </v-app>
</template>
