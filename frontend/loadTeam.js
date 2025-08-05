
// Function to load team.html content
function loadTeamContent() {
    fetch('team.html') // Path to team.html
        .then(response => response.text()) // Get the HTML content as text
        .then(data => {
            // Insert the content into the placeholder
            document.getElementById('team-content').innerHTML = data;
        })
        .catch(error => {
            console.error('Error loading team.html:', error);
            document.getElementById('team-content').innerHTML = '<p class="text-center text-danger">Failed to load team information. Please try again later.</p>';
        });
}

