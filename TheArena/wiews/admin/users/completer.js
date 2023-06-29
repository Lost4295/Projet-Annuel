let requestURL = 'https://api-adresse.data.gouv.fr/search/?q=';
let select = document.getElementById("selection");

function displaySelection(response) {
    if (Object.keys(response.features).length > 0) {
        select.style.display = "block";
        select.removeChild(select.firstChild);
        let ul = document.createElement('ul');
        select.appendChild(ul);
        response.features.forEach(function (element) {
            let li = document.createElement('li');
            li.classList.add('dropdown-item');
            let infosAdresse = document.createTextNode(element.properties.name + ", " + element.properties.postcode + ' ' + element.properties.city);
            li.onclick = function () { selectAdresse(element); };
            li.appendChild(infosAdresse);
            ul.appendChild(li);
        });
    } else {
        select.style.display = "none";
    }
}
function autocompleteAdresse() {
    let inputValue = document.getElementById("adresse").value;
    if (inputValue) {
        fetch(setQuery(inputValue))
            .then(function (response) {
                response.json().then(function (data) {
                    displaySelection(data);
                });
            });
    } else {
        select.style.display = "none";
    }
};
function selectAdresse(element) {
    document.getElementById("adresse").value = element.properties.name + ", " + element.properties.postcode + ", " + element.properties.city;
    select.style.display = "none";
    document.getElementById("resAdresse").value = " " + element.properties.name;
    document.getElementById("CP").value = " " + element.properties.postcode;
    document.getElementById("Ville").value = " " + element.properties.city;
}


function setQuery(value) {
    return requestURL + value + "?type=housenumber&autocomplete=1";
}