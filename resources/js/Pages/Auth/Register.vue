<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import NavBar from '@/Components/original/NavBar.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    Inertia.post(route('register'), form, {
        onSuccess: () => {
            console.log('onSuccess');
            form.reset();
        },
        onError: (errors) => {
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
        <GuestLayout>
            <v-form>
                <v-text-field label="名前" v-model="form.name" required autofocus autocomplete="name" :error-messages="form.errors.name"></v-text-field>
                <v-text-field label="メールアドレス" type="email" v-model="form.email" required autocomplete="username" :error-messages="form.errors.email"></v-text-field>
                <v-text-field label="パスワード" type="password" v-model="form.password" required autocomplete="new-password" :error-messages="form.errors.password"></v-text-field>
                <v-text-field
                    label="パスワード再入力"
                    type="password"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                    :error-messages="form.errors.password_confirmation"
                ></v-text-field>
                <div class="flex items-center justify-end mt-4">
                    <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
