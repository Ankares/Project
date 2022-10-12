/* jshint esversion:7 */ 

// drop-down for users list
const menu = (buttonSelector) => {
    const trigger = document.querySelectorAll(buttonSelector);
    
    trigger.forEach(btn => {
        btn.nextElementSibling.style.display = "none";
        btn.addEventListener('click', function () {
            if (this.nextElementSibling.style.display == "block") {
                this.nextElementSibling.style.display = "none";
                this.classList.remove('active');
            } else {
                this.nextElementSibling.style.display = "block";
                this.classList.add('active');
            }
        });
    });
};

// removing success message from the pages
const successMessage = (messageSelector) => {
    const div = document.querySelector(messageSelector);
          
    if (div.classList.contains('success')) {
        setTimeout(() => {
            div.textContent = '';
        }, 3000);
    };
};

// displaying button only when all inputs are filled
const checkLoginForm = (inputs=[], button) => {
    var btn = document.querySelector(button);
    var valid = true;
    inputs.forEach(element => {
        var field = document.querySelector(element);
        field.value == '' ? valid = false : '';  
    });
    valid == true ? btn.classList.remove('d-none') : btn.classList.add('d-none'); 
}

menu('.trigger-menu');
successMessage('.success');



