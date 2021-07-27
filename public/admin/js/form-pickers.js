$(document ).ready(function(){    
    //custome flatpickr
    flatpickr(".date-picker input", {
        altInput: true,     
        dateFormat: "d-m-Y",
        altFormat: "d-m-Y",  
    });
});