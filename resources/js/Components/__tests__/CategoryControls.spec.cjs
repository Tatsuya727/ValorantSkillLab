import { describe, it, expect } from 'vitest';
import { mount } from '@vue/test-utils';
import CategoryControls from '../original/CategoryControls.vue';

describe('CategoryControls', () => {
    const categories = [
        { id: 1, name: 'Test Category' },
        { id: 2, name: 'Test Category 2' },
    ];
    const showCategory = { 1: false, 2: false };
    const wrapper = mount(CategoryControls, {
        props: { categories, showCategory },
    });
    it('すべて開くボタンが正しく動作する', async () => {
        const button = wrapper.find('.open-all');
        await button.trigger('click');
        expect(showCategory).toEqual({ 1: true, 2: true });
    });

    it('すべて閉じるボタンが正しく動作する', async () => {
        const button = wrapper.find('.close-all');
        await button.trigger('click');
        expect(showCategory).toEqual({ 1: false, 2: false });
    });
});
