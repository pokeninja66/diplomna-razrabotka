const app = new Vue({
    el: '#app',
    data: {
        csrf_token: csrf,
        posts: []
    },
    created: function() {
        this.fetchPosts();

    },
    // watch: {
    //     posts: function(newVal, oldVal) {
    //         console.log(newVal);
    //         console.log(oldVal);
    //         this.fetch_complete = newVal.length > 0;
    //     }
    // },
    methods: {
        fetchPosts: async function() {

            const data = {
                action: "fetchPosts",
            }
            const _self = this;

            await fetch("/requests.php", {
                    method: 'POST',
                    mode: 'same-origin', // no-cors, *cors, same-origin
                    //cache: 'no-cache',
                    credentials: 'include', // include, *same-origin, omit
                    headers: {
                        'Content-Type': 'application/json'
                            //'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    //referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
                    body: JSON.stringify(data)
                })
                .then(response => {
                    if (response.status == 200) {
                        return response.json();
                    }
                    return [];
                })
                .then(data => {
                    //console.log(data);
                    //_self.fetch_complete = true;
                    _self.posts = data.posts;
                    //console.log(_self.posts);
                }).catch(err => {
                    console.log(err);
                });

            // $.post("./requests.php", {
            //     csrf_token: csrf,
            //     action: "fetchPosts"
            // }, function(data) {
            //     this.posts = data.posts;
            // });
        },
        editPost(post_id) {
            //alert(post_id);
            if (confirm("Are you sure you want to edit?")) {
                const url = window.location.origin + "/posts?post=" + post_id;
                console.log(url);
                window.location = url;
            }
        },

        deletePost(post_id) {
            //alert(post_id);
            if (confirm("Are you sure you want to delete this post?")) {

                const data = {
                    action: "delete-post",
                    csrf_token: this.csrf_token,
                    post_id: post_id
                }
                const _self = this;

                fetch("/requests.php", {
                    method: 'POST',
                    mode: 'same-origin',
                    credentials: 'include',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                }).then(response => {
                    if (response.status == 200) {
                        return response.json();
                    }
                    return [];
                }).then(data => {
                    //console.log(data);
                    if (data.status) {
                        window.location = window.origin;
                    } else {
                        alert(data.msg);
                    }

                }).catch(err => {
                    console.log(err);
                });
            }
        }

    }
})