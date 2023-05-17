const popupAlerts = document.getElementsByClassName('popup-alert');
if(popupAlerts.length > 0) {
window.addEventListener('DOMContentLoaded', function() {
const popupContainer = document.getElementById('popup-container');
const popupAlerts = popupContainer.getElementsByClassName('popup-alert');

                    // Display the pop-up alerts after a short delay
        setTimeout(function() {
        for (let i = 0; i < popupAlerts.length; i++) {
            popupAlerts[i].style.display = 'block';
        }
        }, 500);
            setTimeout(function() {
                while (popupContainer.firstChild) {
                popupContainer.firstChild.remove();}}, 5000);
                    });}