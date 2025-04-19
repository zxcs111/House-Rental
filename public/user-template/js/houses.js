$(document).ready(function() {
    // Search functionality
    $('#searchInput').on('input', function() {
      const searchTerm = $(this).val().toLowerCase();

      $('.property-card').each(function() {
        const title = $(this).data('title');
        const type = $(this).data('type');
        const city = $(this).data('city');

        if (title.includes(searchTerm) || type.includes(searchTerm) || city.includes(searchTerm)) {
          $(this).show();
        } else {
          $(this).hide();
        }
      });

      // Show/hide empty state
      const visibleProperties = $('.property-card:visible').length;
      if (visibleProperties === 0) {
        $('.empty-state').show();
      } else {
        $('.empty-state').hide();
      }
    });

    // Clear search when reset button is clicked
    $('.reset').on('click', function() {
      $('#searchInput').val('').trigger('input');
    });
  });

  document.addEventListener('DOMContentLoaded', function () {
  const propertyTypeDropdown = document.getElementById('propertyTypeDropdown');
  const propertyCards = document.querySelectorAll('.property-card');

  // Function to filter properties
  function filterProperties() {
    const searchTerm = searchInput.value.toLowerCase();
    const selectedPropertyType = propertyTypeDropdown.value.toLowerCase();

    propertyCards.forEach(card => {
      const title = card.dataset.title.toLowerCase();
      const type = card.dataset.type.toLowerCase();
      const city = card.dataset.city.toLowerCase();

      const matchesSearch = title.includes(searchTerm) || type.includes(searchTerm) || city.includes(searchTerm);
      const matchesPropertyType = selectedPropertyType === '' || type === selectedPropertyType;

      if (matchesSearch && matchesPropertyType) {
        card.style.display = 'block';
      } else {
        card.style.display = 'none';
      }
    });

    // Show/hide empty state
    const visibleProperties = Array.from(propertyCards).filter(card => card.style.display !== 'none').length;
    const emptyState = document.querySelector('.empty-state');
    if (visibleProperties === 0 && emptyState) {
      emptyState.style.display = 'block';
    } else if (emptyState) {
      emptyState.style.display = 'none';
    }
  }

  // Event listeners for live filtering
  searchInput.addEventListener('input', filterProperties);
  propertyTypeDropdown.addEventListener('change', filterProperties);

  // Clear search when reset button is clicked
  document.querySelector('.reset').addEventListener('click', function () {
    searchInput.value = '';
    filterProperties();
  });
});