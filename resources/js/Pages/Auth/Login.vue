<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import NavBar from '@/Components/original/NavBar.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { ref } from 'vue';
import { useMobileDetection } from '@/Hooks/useMobileDetection';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const { isMobile } = useMobileDetection();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const emailError = ref(null);
const passwordError = ref(null);

const submit = () => {
    Inertia.post(route('login'), form, {
        onError: (errors) => {
            emailError.value = errors.email;
            passwordError.value = errors.password;
        },
        onFinish: () => form.reset('password'),
    });
};

const pageTitle = 'ログイン';
</script>

<template>
    <Head :title="pageTitle" />

    <v-app>
        <NavBar :pageTitle="pageTitle" />
        <GuestLayout :class="{ 'mt-15 ': isMobile }">
            <!-- <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div> -->
            <v-form @submit.prevent="submit" class="mt-5">
                <v-text-field label="メールアドレス" v-model="form.email" required autofocus autocomplete="username" :error-messages="form.errors.email" @keyup.enter="submit"></v-text-field>
                <div v-if="emailError" class="text-red" v-for="error in emailError">・{{ error }}</div>
                <v-text-field
                    label="パスワード"
                    type="password"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    :error-messages="form.errors.password"
                    @keyup.enter="submit"
                ></v-text-field>
                <div v-if="passwordError" class="text-red" v-for="error in passwordError">・{{ error }}</div>
                <v-checkbox v-model="form.remember" label="ログインしたままにする"></v-checkbox>
                <div class="flex items-center justify-between mt-4">
                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        パスワードをお忘れの場合
                    </Link>
                    <v-btn :disabled="form.processing" color="success" class="ml-4" @click="submit"> ログイン </v-btn>
                </div>
            </v-form>

            <div class="flex items-center mt-4">
                <Link :href="route('register')">
                    <v-btn color="blue">アカウントを作成する</v-btn>
                </Link>
                <!-- google login -->
                <Link :href="route('login.google')">
                    <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png" style="margin-left: 3em" />
                </Link>
            </div>
        </GuestLayout>
    </v-app>
</template>
