document.addEventListener('DOMContentLoaded', (): void => {
    const field = document.getElementById(
        'pv_swb_phone_number',
    ) as HTMLInputElement | null;

    if (!field) {
        return;
    }

    field.addEventListener('input', (): void => {
        field.value = field.value.replace(/[^0-9]/g, '');
    });
});
