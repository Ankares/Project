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

const checkLoginForm = (inputs=[], buttonDiv) => {
    var btnDiv = document.querySelector(buttonDiv);
    inputs.forEach(element => {
        var field = document.querySelector(element);
        if(field.value == '') {
            btnDiv.innerHTML = '';
        } else {
            btnDiv.innerHTML = '<button type="submit" class="displayButton btn btn-primary mt-3 mb-3 p-2 col-md-3 col-8">Login</button>';
        }    
    });
}

menu('.trigger-menu');
successMessage('.success');



