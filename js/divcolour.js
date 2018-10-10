function divColor(themebtn) {
var property = document.getElementById(themebtn);
    if (property.className !== 'toggled') {
        property.className = 'toggled'
    }
    else {
        property.className = '';
    }
}