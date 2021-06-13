const app = new Vue({
    el: '#app-login',
    data: {
        csrf_token: csrf,
        username: "",
        password: ""
    },
    methods: {
        validateInput() {
            let flag = 0;

            if (!this.csrf_token) {
                return false;
            }

            if (this.username.length < 3) {
                flag += 1;
            }

            if (this.password.length < 3) {
                flag += 1;
            }

            return flag === 0;
        },
        sendRequest() {
            console.log(this.validateInput());

            if (!this.validateInput()) {
                alert("Please enter a valid user credentials");
                return false;
            }

            const data = {
                action: "login",
                csrf_token: this.csrf_token,
                username: this.username,
                password: this.password
            }

            fetch("/requests.php", {
                    method: 'POST',
                    mode: 'same-origin',
                    credentials: 'include', // include, *same-origin, omit
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    if (response.status == 200) {
                        return response.json();
                    }
                    return false;
                })
                .then(data => {
                    console.log(data);
                    //_self.fetch_complete = true;
                    if (data.status) {
                        window.location = "./";
                    } else {
                        alert(data.msg);
                    }
                }).catch(err => {
                    console.log(err);
                });


        }
    }
})