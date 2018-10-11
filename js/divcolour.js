function divColor(themebtn) {
    
    var property = document.getElementById(themebtn);
    
    var currentImage2 = document.getElementById('f4D1');
    var currentImage = document.getElementById('f4D2');

    if (property.className !== 'toggled') {
        property.className = 'toggled';
        currentImage.style.display ='none';
        currentImage2.style.display = 'block';
    }
    else {
        property.className = '';
        currentImage.style.display ='block';
        currentImage2.style.display = 'none';
    }
    
    
   

}