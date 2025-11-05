/**
 * Admin JavaScript for WP Component Viewer
 */

document.addEventListener('DOMContentLoaded', function() {
  console.log('WP Component Viewer admin JS loaded');

  // Example: Add click handler for refresh components button
  const refreshButton = document.querySelector('.wp-component-viewer-refresh');
  if (refreshButton) {
    refreshButton.addEventListener('click', function(e) {
      e.preventDefault();
      console.log('Refreshing components...');
      // AJAX call would go here
    });
  }
});