// script.js

// Function to toggle dark mode
function toggleDarkMode() {
    // Toggle dark mode class on the body
    document.body.classList.toggle('dark-mode');

    // Store the dark mode state in localStorage
    const isDarkMode = document.body.classList.contains('dark-mode');
    localStorage.setItem('darkMode', isDarkMode);
}

// Get the dark mode toggle button
const darkModeToggle = document.getElementById('dark-mode-toggle');

// Event listener for the dark mode toggle button
darkModeToggle.addEventListener('click', toggleDarkMode);

// Check if dark mode was enabled before
window.addEventListener('DOMContentLoaded', () => {
    const isDarkMode = localStorage.getItem('darkMode') === 'true';
    if (isDarkMode) {
        document.body.classList.add('dark-mode');
    }
});
