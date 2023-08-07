import { describe, it, expect } from 'vitest';
import { mount } from '@vue/test-utils';
import NavBar from '../NavBar.vue';

function setup(user = null) {
    const route = (name) => `route('${name}')`;
    const $page = {
        props: {
            auth: {
                user: user,
            },
        },
    };

    const wrapper = mount(NavBar, {
        global: {
            provide: {
                route,
            },
            mocks: {
                $page,
            },
        },
    });

    return wrapper;
}

describe('NavBar.vue', () => {
    it('正しいタイトル', () => {
        // ダミーのroute関数を作成
        const wrapper = setup();

        // app barのタイトルを検証
        const title = wrapper.find('v-toolbar-title');

        expect(title.text()).toBe('ValorantSkillLab');
    });

    it('正しいリンク', () => {
        // コンポーネントをマウント
        const wrapper = setup();

        // 各リンクが正しいhrefを持っているか検証
        expect(wrapper.find('a[href="route(\'maps.index\')"]').exists()).toBeTruthy();
        expect(wrapper.find('a[href="route(\'characters.index\')"]').exists()).toBeTruthy();
        expect(wrapper.find('a[href="route(\'spots.index\')"]').exists()).toBeTruthy();
        expect(wrapper.find('a[href="route(\'spots.create\')"]').exists()).toBeTruthy();
    });
});

describe('ログインしていない場合', () => {
    it('ログインボタンと新規登録ボタンが表示される', () => {
        const wrapper = setup();

        expect(wrapper.find('a[href="route(\'login\')"]').exists()).toBeTruthy();
        expect(wrapper.find('a[href="route(\'register\')"]').exists()).toBeTruthy();
    });

    it('ログアウトボタンが表示されない', () => {
        const wrapper = setup();

        expect(wrapper.find('a[href="route(\'logout\')"]').exists()).toBeFalsy();
    });
});

describe('ログインしている場合', () => {
    it('ログアウトボタンが表示される', () => {
        const loggedInUser = {
            name: 'test',
        };

        const wrapper = setup({
            user: loggedInUser,
        });

        expect(wrapper.find('a[href="route(\'logout\')"]').exists()).toBeTruthy();
    });

    it('ログインボタンと新規登録ボタンが表示されない', () => {
        const loggedInUser = {
            name: 'test',
        };

        const wrapper = setup({
            user: loggedInUser,
        });

        expect(wrapper.find('a[href="route(\'login\')"]').exists()).toBeFalsy();
        expect(wrapper.find('a[href="route(\'register\')"]').exists()).toBeFalsy();
    });
});
