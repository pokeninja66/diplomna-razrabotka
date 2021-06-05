const app = new Vue({
    el: '#app-signup',
    data: {
        csrf_token: csrf,
        user: {
            username: "",
            email: "",
            password1: "",
            password2: ""
        },
        valid_username: true,
        //email check
        valid_email: true,
        // password check
        password_length: 0,
        contains_eight_characters: false,
        contains_number: false,
        contains_uppercase: false,
        contains_special_character: false,
        valid_password: false,
        valid_password2: true,

    },
    methods: {
        validateEmail() {
            this.valid_email = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.user.email);
        },
        validateUsername() {
            this.valid_username = this.user.username.length >= 3;
        },
        validateSecondPassword() {
            this.valid_password2 = this.user.password1 === this.user.password2;
        },
        validatePassword() {
            this.password_length = this.user.password1.length;
            const format = /[ !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;

            if (this.password_length >= 6) {
                this.contains_eight_characters = true;
            } else {
                this.contains_eight_characters = false;
            }

            this.contains_number = /\d/.test(this.user.password1);
            this.contains_uppercase = /[A-Z]/.test(this.user.password1);
            this.contains_special_character = format.test(this.user.password1);

            if (this.contains_eight_characters === true &&
                this.contains_special_character === true &&
                this.contains_uppercase === true &&
                this.contains_number === true) {
                this.valid_password = true;
            } else {
                this.valid_password = false;
            }
        },
        validateInput() {
            let flag = 0;

            if (!this.csrf_token) {
                return false;
            }

            this.validateUsername();
            if (!this.valid_username) {
                flag += 1;
            }

            this.validateEmail();
            if (!this.valid_email) {
                flag += 1;
            }
            this.validatePassword();
            if (!this.valid_password) {
                flag += 1;
            }

            this.validateSecondPassword();
            if (!this.valid_password2) {
                flag += 1;
            }
            console.log(flag);
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
                action: 'signup',
                data: {
                    csrf_token: this.csrf_token,
                    user: this.user
                }
            }, function(data) {
                console.log("jquery:", data);
            });

        },

    }
})