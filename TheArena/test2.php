<!-- TODO ajouter l'api fetch pour faie des reherches sur le site -->
<!-- TODO faire en sorte de finir les events en entier (crud sur shop, back + front avec tout ce qu'il faut) -->
<!doctype html>
<html lang=fr>

<head>
    <meta charset=utf-8>
    <title>Test addok + fetch</title>
    <link rel="icon" href="data:;base64,iVBORw0KGgo=">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
</head>

<body>
    <form action="" method="post">
        <input type="text" name="search" id="search" placeholder="Rechercher">
        <input type="submit" value="Rechercher">
    </form>
    <div id="results"></div>
    <script>
        const form = document.querySelector("form");
        const results = document.querySelector("#results");
        form.addEventListener("submit", (e) => {
            e.preventDefault();
            const search = document.querySelector("#search").value;
            fetch(`https://api-adresse.data.gouv.fr/search/?q=${search}`)
                .then((response) => response.json())
                .then((data) => {
                    console.log(data);
                    results.innerHTML = "";
                    data.features.forEach((feature) => {
                        const div = document.createElement("div");
                        div.innerHTML = `
                            <h2>${feature.properties.label}</h2>
                            <p>${feature.properties.context}</p>
                            <p>${feature.properties.city}</p>
                            <p>${feature.properties.postcode}</p>
                            <p>${feature.properties.type}</p>
                            <p>${feature.properties.score}</p>
                        `;
                        results.appendChild(div);
                    });
                });
        });
    </script>

</html>