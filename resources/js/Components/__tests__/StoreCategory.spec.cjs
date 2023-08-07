import { describe, it, expect } from 'vitest';

import { mount } from '@vue/test-utils';

import StoreCategory from '../StoreCategory.vue';

function setup() {
    const wrapper = mount(StoreCategory);

    return wrapper;
}

describe('StoreCategory.vue', () => {
    it('カテゴリー追加ボタンが表示される', () => {
        const wrapper = setup();

        const button = wrapper.find('v-btn');

        expect(button.text()).toBe('カテゴリーを追加する');
    });

    it('カテゴリー追加ボタンを押すとカテゴリー追加フォームが表示される', async () => {
        const wrapper = setup();

        const button = wrapper.find('v-btn.addCategory');
        await button.trigger('click');

        const form = wrapper.find('input[name="name"]');
        const label = wrapper.find('label[for="name"]');
        expect(form.exists()).toBeTruthy();
        expect(label.text()).toBe('カテゴリー名');
    });
});
