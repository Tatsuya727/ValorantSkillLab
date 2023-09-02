import { describe, it, expect } from 'vitest';
import { mount } from '@vue/test-utils';
import NavBar from '../original/NavBar.vue';

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

    it('タイトルの文字とリンクが正しい', () => {
        const title = wrapper.find('v-toolbar-title');

        expect(title.text()).toBe('ValorantSkillLab');

        expect(title.find('a').attributes('href')).toBe('/');
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

describe('ログインしていない場合', () => {
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

    const wrapper = mount(NavBar, {
        global: {
            mocks: {
                $page: {
                    props: {
                        auth: {
                            user: null,
                        },
                        NavCategories: [],
                    },
                },
                route: global.route,
            },
        },
    });

    const isMobile = false;

    it('ログインボタンと新規登録ボタンが表示される', () => {
        const loginButton = wrapper.find('a[href="mocked-route-for-login');
        const registerButton = wrapper.find('a[href="mocked-route-for-register');

        expect(loginButton.exists()).toBeTruthy();
        expect(registerButton.exists()).toBeTruthy();

        expect(loginButton.text()).toBe('ログイン');
        expect(registerButton.text()).toBe('新規登録');
    });

    it('ログアウトボタンが表示されない', () => {
        expect(wrapper.find('a[href="mocked-route-for-logout').exists()).toBeFalsy();
    });
});

describe('ログインしている場合', () => {
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

    it('ログインボタンと新規登録ボタンが表示されない', () => {
        console.log(wrapper.html());
        expect(wrapper.find('a[href="mocked-route-for-login').exists()).toBeFalsy();
        expect(wrapper.find('a[href="mocked-route-for-register').exists()).toBeFalsy();
    });

    it('ログアウトボタンが表示される', () => {
        expect(wrapper.find('a[href="mocked-route-for-logout').exists()).toBeTruthy();
    });
});
