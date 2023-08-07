import { describe, it, expect } from 'vitest';
import { mount } from '@vue/test-utils';
import CategoryHeader from '../original/CategoryHeader.vue';

describe('CategoryHeader', () => {
    const category = { id: 1, name: 'Test Category' };
    const showCategory = { [category.id]: false };
    const wrapper = mount(CategoryHeader, { props: { category, showCategory } });

    it('カテゴリー名が正しく表示される', () => {
        expect(wrapper.find('.categoryname').text()).toBe(category.name);
    });

    it('カテゴリーのトグルが正しく動作する', async () => {
        await wrapper.find('h4').trigger('click');
        expect(wrapper.vm.showCategory[category.id]).toBe(true);
    });

    it('名前を変更するダイアログが正しく開き、閉じる', async () => {
        const openbutton = wrapper.find('.open-update-dialog');
        const closebutton = wrapper.find('.close-update-dialog');

        // 名前を変更というボタンを押すと、updateDialogがtrueになる
        await openbutton.trigger('click');
        expect(wrapper.vm.updateDialog).toBe(true);

        // ダイアログの閉じるボタンを押すと、updateDialogがfalseになる
        await closebutton.trigger('click');
        expect(wrapper.vm.updateDialog).toBe(false);
    });

    it('削除の確認ダイアログが正しく開き、閉じる', async () => {
        const openbutton = wrapper.find('.open-delete-dialog');
        const closebutton = wrapper.find('.cancel-delete-dialog');

        // 削除というボタンを押すと、deleteCategoryDialogがtrueになる
        await openbutton.trigger('click');
        expect(wrapper.vm.deleteCategoryDialog).toBe(true);

        // ダイアログの閉じるボタンを押すと、deleteCategoryDialogがfalseになる
        await closebutton.trigger('click');
        expect(wrapper.vm.deleteCategoryDialog).toBe(false);
    });
});
