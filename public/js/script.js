document.getElementById("message-panel").style.display = "none"

let usernameLoggedIn;

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
                usernameLoggedIn = data.Username;
                document.getElementById("registrationForm").reset();
                document.getElementById("account-panel").style.display = "none";
                getAllMessages();
            })
    }
}, false);
document.addEventListener('click', function (event) {
    event.preventDefault();
    if (event.target.matches('#login-btn')) {
        var UsernameInput = document.getElementById('loginUsername');
        var PasswordInput = document.getElementById('loginPassword');
        var data = {
            Username: UsernameInput.value,
            Password: PasswordInput.value
        };
        console.log(data,"data");
        Http.Get('/api/account?Username='+data.Username+'&Password='+data.Password)
            .then(() => {
                usernameLoggedIn = data.Username;
                document.getElementById("loginForm").reset();
                document.getElementById("account-panel").style.display = "none";
                getAllMessages();
            })
    }
}, false);
document.addEventListener('click', function (event) {
    event.preventDefault();
    if (event.target.matches('#message-btn')) {
        var commentInput = document.getElementById('commentMessage');
        const date = new Date();
        var data = {
            Username: usernameLoggedIn,
            Comment: commentInput.value,
            Created_at: date.getFullYear()+"-"+date.getUTCDay()+"-"+date.getUTCDate();
        };
        console.log(data,"data");
        Http.Post('/api/message', data)
            .then(() => {
                document.getElementById("messageForm").reset();
                document.getElementById("account-panel").style.display = "none";
                getAllMessages();
            })
    }
}, false);
document.addEventListener('click', function (event) {
    event.preventDefault();
    if (event.target.matches('#search-btn')) {
        var searchMessageInput = document.getElementById('searchMessage');
        var dateMessageInput = document.getElementById('dateMessage');
        const query = dateMessageInput.value!=="" ? "date="+dateMessageInput.value : "search="+searchMessageInput.value; 
        Http.Get('/api/message?'+query)
            .then(response=> {                
                listMessages(response);
                document.getElementById("searchForm").reset();
                document.getElementById("account-panel").style.display = "none";
                getAllMessages();
            })
    }
}, false);
function getAllMessages() {
    Http.Get('/api/message')
        .then(response => {
            listMessages(response);
            document.getElementById("message-panel").style.display = "block";
        })
}

function listMessages(response) {
    const element = document.getElementById("messages-list");
    const d_nested = document.getElementById("nested");
    if(d_nested && d_nested.parentNode){
        d_nested.parentNode.removeChild(d_nested);
    }
    response.json().then(data=>{
        data.forEach(m=>element.insertAdjacentHTML("afterend", 
            "<li id='nested'><h4>"+m.Created_at+"</h4><p>"+m.Comment+"</p><span>By: "+m.Username+"</span></li>"))    
    });
}