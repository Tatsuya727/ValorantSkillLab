<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import NavBar from '@/Components/original/NavBar.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { ref } from 'vue';
import { useMobileDetection } from '@/Hooks/useMobileDetection';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const isMobile = useMobileDetection();

const nameError = ref(null);
const emailError = ref(null);
const passwordError = ref(null);
const passwordConfirmationError = ref(null);

const submit = () => {
    Inertia.post(route('register'), form, {
        onSuccess: () => {
            console.log('onSuccess');
            form.reset();
        },
        onError: (errors) => {
            nameError.value = errors.name;
            emailError.value = errors.email;
            passwordError.value = errors.password;
            passwordConfirmationError.value = errors.password_confirmation;
            console.log('onError');
        },
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

const pageTitle = '新規登録';
</script>

<template>
    <Head :title="pageTitle" />

    <v-app>
        <NavBar :pageTitle="pageTitle" />
        <GuestLayout :class="{ 'mt-15 ': isMobile }">
            <v-form>
                <v-text-field label="名前" v-model="form.name" required autofocus autocomplete="name" persistent-hint hint="名前は30文字以内"></v-text-field>
                <div v-if="nameError" class="text-red" v-for="error in nameError">・{{ error }}</div>
                <v-text-field label="メールアドレス" type="email" v-model="form.email" required autocomplete="username"></v-text-field>
                <div v-if="emailError" class="text-red" v-for="error in emailError">・{{ error }}</div>
                <v-text-field label="パスワード" type="password" v-model="form.password" required autocomplete="new-password" persistent-hint hint="パスワードは8文字以上"></v-text-field>
                <div v-if="passwordError" class="text-red" v-for="error in passwordError">・{{ error }}</div>
                <v-text-field label="パスワード再入力" type="password" v-model="form.password_confirmation" required autocomplete="new-password"></v-text-field>
                <div v-if="passwordConfirmationError" class="text-red" v-for="error in passwordConfirmationError">・{{ error }}</div>
                <div class="flex items-center justify-between mt-4">
                    <Link :href="route('login')" class="underline text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        登録済みですか？
                    </Link>
                    <v-btn @click="submit" class="ml-4" color="success"> 新規登録 </v-btn>
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
