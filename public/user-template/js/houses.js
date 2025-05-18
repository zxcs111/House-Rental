$(document).ready(function() {
    const propertyTypeDropdown = $('#propertyTypeDropdown');
    const propertyCards = $('.property-card');

    function filterProperties() {
        const selectedPropertyType = propertyTypeDropdown.val().toLowerCase();

        propertyCards.each(function() {
            const type = $(this).data('type').toLowerCase();
            const matchesPropertyType = selectedPropertyType === '' || type === selectedPropertyType;

            if (matchesPropertyType) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        const visibleProperties = propertyCards.filter(':visible').length;
        if (visibleProperties === 0) {
            $('.empty-state').show();
        } else {
            $('.empty-state').hide();
        }
    }

    propertyTypeDropdown.on('change', filterProperties);

    $('.reset').on('click', function() {
        $('#searchInput').val('');
        propertyTypeDropdown.val('').trigger('change');
    });
});