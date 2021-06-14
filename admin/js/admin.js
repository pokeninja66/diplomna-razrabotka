function deleteUser(user_id) {

    if (user_id === "b520040e-c6f7-11eb-aca6-0800274911c6") {
        alert("You can't delete this user!");
        return false;
    }

    if (confirm("Are you sure you want to delete this user?")) {
        //
        document.getElementById("action").value = "delete-user";
        document.getElementById("value").value = user_id;
        document.getElementById("action-form").submit();
    }
}

function editPost(post_id) {
    window.open(window.location.origin + "/posts?post=" + post_id);
}

function deletePost(post_id) {

    if (confirm("Are you sure you want to delete this post?")) {
        //
        document.getElementById("action").value = "delete-post";
        document.getElementById("value").value = post_id;
        document.getElementById("action-form").submit();
    }
}