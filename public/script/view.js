
function displayFiles(key) {
    // Hide all pop-ups

    // Show the selected pop-up
    var selectedPopup = document.getElementById('file' + key);
    selectedPopup.style.display = 'grid';

    // Add an event listener to close the pop-up when clicking outside
    document.addEventListener('click', closePopup);

    // Prevent the click event from propagating to the document
    event.stopPropagation();
}

function closePopup() {
    // Hide all pop-ups
    var popups = document.querySelectorAll('.loading');
    popups.forEach(function (popup) {
        popup.style.display = 'none';
    });

    // Remove the event listener
    document.removeEventListener('click', closePopup);
}

function displayEvidence(key) {
    // Hide all pop-ups

    // Show the selected pop-up
    var selectedPopup = document.getElementById('file' + key);
    selectedPopup.style.display = 'grid';

    // Add an event listener to close the pop-up when clicking outside
    document.addEventListener('click', closePopup);

    // Prevent the click event from propagating to the document
    event.stopPropagation();
}