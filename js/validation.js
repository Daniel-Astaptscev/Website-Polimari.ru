let form = document.querySelector('.js-form'),
    formInputs = document.querySelectorAll('.js-input');

form.onsubmit = function () {
    let emptyInputs = Array.from(formInputs).filter(input => input.value == '');

    formInputs.forEach(function (input) {
        if (input.value == '') {
            input.classList.add('error');
            $('#Order').modal('show');
        } else {
            input.classList.remove('error');
            }
        });
    
    if (emptyInputs.length !== 0) {
        console.log('inputs not filled');
        return false;
    }
}