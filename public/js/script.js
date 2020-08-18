document.addEventListener('click', function (event) {
    event.preventDefault();
    if (event.target.matches('#registration-btn')) {
        var UsernameInput = document.getElementById('registrationUsername');
        var EmailInput = document.getElementById('registrationEmail');
        var Phone_numberInput = document.getElementById('registrationPhone');
        var PasswordInput = document.getElementById('registrationPassword');
        var data = {
            Username: UsernameInput.value,
            Email: EmailInput.value,
            Phone_number: Phone_numberInput.value,
            Password: PasswordInput.value
        };
        console.log(data,"data");
        Http.Post('/api/account', data)
            .then(() => {
                console.log(data,"data");
            })
    }
}, false)