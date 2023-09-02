import { describe, it, expect } from 'vitest';
import { mount } from '@vue/test-utils';
import NavBar from '../original/NavBar.vue';
import { Inertia } from '@inertiajs/inertia';

describe('NavBar.vue', () => {
    global.route = (name, params = {}) => {
        // パラメータが存在する場合、それをURLに追加します。
        let paramString = Object.entries(params)
            .map(([key, val]) => `${key}=${val}`)
            .join('&');
        if (paramString) {
            paramString = `?${paramString}`;
        }
        return `mocked-route-for-${name}${paramString}`;
    };

    const testUser = {
        id: 1,
        name: 'test',
    };

    const wrapper = mount(NavBar, {
        global: {
            mocks: {
                $page: {
                    props: {
                        auth: {
                            user: testUser,
                        },
                        NavCategories: [],
                    },
                },
                route: global.route,
            },
        },
    });

    it('does something with NavBar', () => {
        const title = wrapper.find('v-toolbar-title');

        expect(title.text()).toBe('ValorantSkillLab');
    });
});

// // app barのタイトルを検証

// it('正しいリンク', () => {
//     // コンポーネントをマウント
//     const wrapper = setup();

//     // 各リンクが正しいhrefを持っているか検証
//     // expect(wrapper.find('a[href="route(\'maps.index\')"]').exists()).toBeTruthy();
//     // expect(wrapper.find('a[href="route(\'characters.index\')"]').exists()).toBeTruthy();
//     expect(wrapper.find('a[href="route(\'categories.index\')"]').exists()).toBeTruthy();
//     expect(wrapper.find('a[href="route(\'spots.create\')"]').exists()).toBeTruthy();
// });

// describe('ログインしていない場合', () => {
//     it('ログインボタンと新規登録ボタンが表示される', () => {
//         const wrapper = setup();

//         expect(wrapper.find('a[href="route(\'login\')"]').exists()).toBeTruthy();
//         expect(wrapper.find('a[href="route(\'register\')"]').exists()).toBeTruthy();
//     });

//     it('ログアウトボタンが表示されない', () => {
//         const wrapper = setup();

//         expect(wrapper.find('a[href="route(\'logout\')"]').exists()).toBeFalsy();
//     });
// });

// describe('ログインしている場合', () => {
//     it('ログアウトボタンが表示される', () => {
//         const loggedInUser = {
//             name: 'test',
//         };

//         const wrapper = setup({
//             user: loggedInUser,
//         });

//         expect(wrapper.find('a[href="route(\'logout\')"]').exists()).toBeTruthy();
//     });

//     it('ログインボタンと新規登録ボタンが表示されない', () => {
//         const loggedInUser = {
//             name: 'test',
//         };

//         const wrapper = setup({
//             user: loggedInUser,
//         });

//         expect(wrapper.find('a[href="route(\'login\')"]').exists()).toBeFalsy();
//         expect(wrapper.find('a[href="route(\'register\')"]').exists()).toBeFalsy();
//     });
// });
