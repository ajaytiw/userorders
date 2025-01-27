function handleValidationErrors(errors) {
    const errorContainer = document.getElementById('error-messages');
    errorContainer.innerHTML = '';
    for (let field in errors) {
        if (errors.hasOwnProperty(field)) {
            errors[field].forEach(function (message) {
                const errorText = document.createElement('div');
                errorText.classList.add('alert', 'alert-danger');
                errorText.textContent = message;
                errorContainer.appendChild(errorText);
            });
        }
    }
}

function handleValidateUpdate(errors) {
    const errorContainer = document.getElementById('error-messagess');
    errorContainer.innerHTML = '';
    for (let field in errors) {
        if (errors.hasOwnProperty(field)) {
            errors[field].forEach(function (message) {
                const errorText = document.createElement('div');
                errorText.classList.add('alert', 'alert-danger'); 
                errorText.textContent = message;
                errorContainer.appendChild(errorText);
            });
        }
    }
}


function order_add_validation(errors) {
    const errorContainer = document.getElementById('error-messages');
    errorContainer.innerHTML = '';
    for (let field in errors) {
        if (errors.hasOwnProperty(field)) {
            errors[field].forEach(function (message) {
                const errorText = document.createElement('div');
                errorText.classList.add('alert', 'alert-danger');
                errorText.textContent = message;
                errorContainer.appendChild(errorText);
            });
        }
    }
}



function order_update_validation(errors) {
    const errorContainer = document.getElementById('error-messagess');
    errorContainer.innerHTML = '';
    for (let field in errors) {
        if (errors.hasOwnProperty(field)) {
            errors[field].forEach(function (message) {
                const errorText = document.createElement('div');
                errorText.classList.add('alert', 'alert-danger'); 
                errorText.textContent = message;
                errorContainer.appendChild(errorText);
            });
        }
    }
}