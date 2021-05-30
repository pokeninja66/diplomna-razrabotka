const app = new Vue({
    el: '#app-login',
    data: {
        username: "",
        password: ""
    },
    methods: {
        validateInput() {
            let flag = 0;

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
            const _self = this;

            $.post("./requests.php", {
                action: 'login',
                data: {
                    username: this.username,
                    password: this.password
                }
            }, function(data) {
                console.log("jquery:", data);
            });

        }
    }
})