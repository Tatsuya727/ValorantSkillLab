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

    const isMobile = false;

    it('正しいタイトル', () => {
        console.log(wrapper.html());
        const title = wrapper.find('v-toolbar-title');

        expect(title.text()).toBe('ValorantSkillLab');
    });

    it('サイドメニューのリンクが正しい', () => {
        const sideMenu = wrapper.find('v-list.side-menu');
        const sideMenuLinks = sideMenu.findAll('a');

        expect(sideMenuLinks[0].attributes('href')).toBe('mocked-route-for-about');
        expect(sideMenuLinks[1].attributes('href')).toBe('mocked-route-for-spots.create');
        expect(sideMenuLinks[2].attributes('href')).toBe('mocked-route-for-sharespots.index');
        expect(sideMenuLinks[3].attributes('href')).toBe('mocked-route-for-categories.index');
        expect(sideMenuLinks[4].attributes('href')).toBe('mocked-route-for-spots.index');

        expect(sideMenuLinks[0].text()).toBe('このアプリについて');
        expect(sideMenuLinks[1].text()).toBe('作成する');
        expect(sideMenuLinks[2].text()).toBe('すべての投稿');
        expect(sideMenuLinks[3].text()).toBe('カテゴリー');
        expect(sideMenuLinks[4].text()).toBe('全て');
    });
});

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
