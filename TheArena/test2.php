<?php
// //Le message
// $message = "Line 1\r\nLine 2\r\nLine 3";
// 
// //Dans le cas où nos lignes comportent plus de 70 caractères, nous les coupons en utilisant wordwrap()
// $message = wordwrap($message, 70, "\r\n");
// 
// //Envoi du mail
// 
// if (mail('turin-ylan@outlook.fr', 'Mon Sujet', $message)) {
// echo "Message envoyé !";
// } else {
// echo "Erreur";
// }
?>

<!doctype html>
<meta charset=utf-8>
<title>Test addok + fetch</title>
<link rel="icon" href="data:;base64,iVBORw0KGgo=">
<script>
    /* Use http://localhost:7878 if you run a local instance. */
    const url = new URL('http://api-adresse.data.gouv.fr/search')
    const params = {
        q: 'lil'
    }
    Object.keys(params).forEach(
        key => url.searchParams.append(key, params[key])
    )
    fetch(url)
        .then(response => {
            if (response.status >= 200 && response.status < 300) {
                return response
            } else {
                const error = new Error(response.statusText)
                error.response = response
                throw error
            }
        })
        .then(response => response.json())
        .then(data => console.log('request succeeded with JSON response', data))
        .catch(error => console.log('request failed', error))
</script>

<body>
    <form id="1">
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <form id="2">
        <div class="form-group">
            <label for="exampleInputEmail2">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail2" aria-describedby="emailHelp" placeholder="Enter email">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword2">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password">
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck2">
            <label class="form-check-label" for="exampleCheck2">Check me out</label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</body>
<script>

    document.getElementById("1").addEventListener("submit", function(evt) {
        evt.preventDefault();
        console.log("form 1");
    });
    document.getElementById("2").addEventListener("submit", function(evt) {
        evt.preventDefault();
        console.log("form 2");
    });
    
</script>