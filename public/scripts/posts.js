const app = new Vue({
    el: '#app-login',
    data: {
        csrf_token: csrf,
        title: "",
        description: "",
        image_src: ""
    },
    methods: {
        validateInput() {
            let flag = 0;

            if (!this.csrf_token) {
                return false;
            }

            if (this.title.length < 3) {
                flag += 1;
            }

            if (this.image_src === "") {
                flag += 1;
            }

            return flag === 0;
        },
        checkFileType(e) {
            let file = e.target.files[0];
            let reader = new FileReader();

            if (!file) {
                this.image_src = "";
                return false;
            }
            const allowedFiles = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];

            if (allowedFiles.includes(file.type) && file.size > 100) {
                reader.onloadend = (file) => {
                    this.image_src = reader.result;
                }
                reader.readAsDataURL(file);
            } else {
                this.image_src = "";
            }

        },
        sendRequest() {
            console.log(this.validateInput());

            if (!this.validateInput()) {
                alert("Please enter a valid at least a title and image!");
                return false;
            }
            const _self = this;

            const data = {
                action: "create-post",
                csrf_token: this.csrf_token,
                post: {
                    title: this.title,
                    description: this.description,
                    image: this.image_src
                }
            }

            fetch("/requests.php", {
                    method: 'POST',
                    mode: 'same-origin',
                    credentials: 'include',
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