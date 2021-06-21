<?php
$RequestInfo = json_decode(file_get_contents('php://input'));
//print_r($RequestInfo);

if ($RequestInfo) {
    header('Content-Type: application/json');

    if ($RequestInfo->action == "hash") {
        echo json_encode(password_hash($RequestInfo->value, PASSWORD_DEFAULT));
        exit();
    }

    require "../vendor/autoload.php";
    require "../inc/controllers/CustomCrypt.php";
    CustomCrypt::$key_path = "../CustomKey.txt";

    if ($RequestInfo->action == "encrypt") {
        echo json_encode(CustomCrypt::encrypt($RequestInfo->value));
        exit();
    }
    if ($RequestInfo->action == "decrypt") {
        echo json_encode(CustomCrypt::decrypt($RequestInfo->value));
        exit();
    }

    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testing</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/skeleton/2.0.4/skeleton.min.css" integrity="sha512-EZLkOqwILORob+p0BXZc+Vm3RgJBOe1Iq/0fiI7r/wJgzOFZMlsqTa29UEl6v6U6gsV4uIpsNZoV32YZqrCRCQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="row" style="margin: 2rem auto;">
        <!-- The above form looks like this -->
        <div class="two columns"></div>
        <div class="row eight columns">
            <div class="twelve columns">
                <label for="hash_test">Test password hash</label>
                <input class="u-full-width" type="text" placeholder="" id="hash_test">
                <label for="hash_result">Test result</label>
                <textarea class="u-full-width" id="hash_result"></textarea>
                <a class="button button-primary" id="hash">Test hash</a>
            </div>
            <div class="twelve columns">
                <label for="encryption_test">Test encryption</label>
                <input class="u-full-width" type="text" placeholder="" id="encryption_test">
                <label for="encryption_result">Encryption result</label>
                <textarea class="u-full-width" id="encryption_result"></textarea>
                <a class="button button-primary" id="encryption">Test encryption</a>
            </div>
            <div class="twelve columns">
                <label for="decryptiontest">Test decryption</label>
                <input class="u-full-width" type="text" placeholder="" id="decryption_test">
                <label for="decryption_result">Decryption result</label>
                <textarea class="u-full-width" id="decryption_result"></textarea>
                <a class="button button-primary" id="decryption">Test decryption</a>
            </div>
        </div>
    </div>
</body>
<script>
    document.getElementById('hash').onclick = function changeContent() {
        post("hash", "hash_test", "hash_result");
    }
    document.getElementById('encryption').onclick = function changeContent() {
        post("encrypt", "encryption_test", "encryption_result");
    }
    document.getElementById('decryption').onclick = function changeContent() {
        post("decrypt", "decryption_test", "decryption_result");
    }


    function post(action, value_id, result_id) {

        const data = {
            action: action,
            value: document.getElementById(value_id).value
        }

        fetch("/tests/", {
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
                return [];
            })
            .then(data => {
                //console.log(data);
                document.getElementById(result_id).value = data;
            }).catch(err => {
                console.log(err);
            });
    }
</script>

</html>