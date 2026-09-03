import { stripNonDigits } from './index';

describe('stripNonDigits', () => {
    it('removes letters', () => {
        expect(stripNonDigits('55abc51')).toBe('5551');
    });

    it('removes symbols and spaces', () => {
        expect(stripNonDigits('+55 (51) 99999-9999')).toBe('5551999999999');
    });

    it('keeps a string that is already digits-only unchanged', () => {
        expect(stripNonDigits('5551999999999')).toBe('5551999999999');
    });

    it('returns an empty string when there are no digits', () => {
        expect(stripNonDigits('abc')).toBe('');
    });
});
