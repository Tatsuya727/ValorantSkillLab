import { describe, it, expect } from 'vitest';

import { mount } from '@vue/test-utils';

import NavBar from '../NavBar.vue';

function setup() {
    const route = (name) => `route('${name}')`;
    const $page = {
        props: {
            auth: {
                user: null,
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

// テストを実行
describe('NavBar.vue', () => {
    it('renders the app bar correctly', () => {
        // ダミーのroute関数を作成
        const wrapper = setup();

        // app barのタイトルを検証
        const title = wrapper.find('v-toolbar-title');
        console.log('---');
        console.log(title.text());
        console.log('---');
        expect(title.text()).toBe('ValorantSkillLab');
    });

    it('renders links correctly', () => {
        // コンポーネントをマウント
        const wrapper = setup();

        // 各リンクが正しいhrefを持っているか検証
        expect(wrapper.find('a[href="route(\'maps.index\')"]').exists()).toBeTruthy();
        expect(wrapper.find('a[href="route(\'characters.index\')"]').exists()).toBeTruthy();
        expect(wrapper.find('a[href="route(\'spots.index\')"]').exists()).toBeTruthy();
        expect(wrapper.find('a[href="route(\'spots.create\')"]').exists()).toBeTruthy();
    });

    // 他のテストケースを追加
});
