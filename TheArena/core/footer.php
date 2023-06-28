</div>
</div>
</div>
</div>
<div id="cb-cookie-banner" class="alert alert-dark text-center mb-0 position-absolute w-100"  style="bottom:15px" role="alert">
  &#x1F36A; Notre site utilise des cookies pour vous assurer la meilleure expérience possible.
  <a href="https://www.cookiesandyou.com/" title="Plus d'informations" target="blank">Plus d'informations</a>
  <button type="button" class="btn btn-primary btn-sm ms-3" onclick="window.cb_hideCookieBanner()">
    Accepter
  </button>
</div>
<div class="row footer">
    <div class="col px-0">
        <footer class="footer pt-4 pb-2">
            <div class="d-flex justify-content-around align-items-center">
                <img src="/img/logothearena-removebg.png" alt="Logo" class="d-inline-block logo">
                <a href="/cgu" title="Conditions générales d'utilisation" class="m-4 p-3">Conditions générales d'utilisation</a>
                <a href="/cgv" title="Conditions générales de vente" class="m-4 p-3">Conditions générales de vente</a>
                <a href="/legal" class="m-4 p-3">Mentions légales</a>
                <a href="/contact" class="m-4 p-3">Nous contacter</a>
                <?php if (isConnected()) { ?>
                    <div>
                        <a class="btn btn-warning messages" href="/chat" id="messages">
                            Messagerie
                            <?php
                            $db = connectToDB();
                            $sql = $db->prepare("SELECT * FROM " . PREFIX . "messages WHERE reciever_id = :id AND isread = 0");
                            $sql->execute([
                                "id" => $_SESSION['id']
                            ]);
                            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
                            if (count($result) > 0) {
                                echo '<span class=" top-0 start-100 p-2 bg-danger border border-light rounded-circle">' . count($result) . '<span class="visually-hidden">New alerts</span></span>';
                            }
                            ?>
                        </a>
                    </div>
                <?php  } ?>
            </div>
            <p class="text-center text-muted">
                &copy; <?php echo date("Y"); ?> - Ylan Turin--Kondi, Esteban Bonnard, Zacharie Roger
            </p>
        </footer>
    </div>
</div>
</body>

<script>
    window.onload = (event) => {
        setTimeout(function() {
            document.getElementById("loading").classList.add('hideev');
            setTimeout(function() {
                document.getElementById("loading").classList.add('d-none');
            }, 600)
        }, 900);
        initializeCookieBanner();
    }

    var theme = window.localStorage.getItem('data-theme');
    const switchBox = document.querySelector(".sun-moon");
    if (theme) document.documentElement.setAttribute('data-theme', theme);
    if (theme == 'dark') {
        switchBox.classList.remove("move");
    } else {
        switchBox.classList.add("move");
    }

    document.getElementById('changeToDarkMode').onclick = function() {
        if (window.localStorage.getItem('data-theme') == 'dark') {
            document.documentElement.setAttribute('data-theme', 'light');
            window.localStorage.setItem('data-theme', 'light');
            switchBox.classList.add("move");
        } else {
            document.documentElement.setAttribute('data-theme', 'dark');
            window.localStorage.setItem('data-theme', 'dark');
            switchBox.classList.remove("move");
        }
    };

    function myFunction() {
        var dropdown = document.getElementById("thedropdown");
        dropdown.classList.toggle("show");

        window.onclick = function(event) {
            if (!event.target.matches('.dropper') && !event.target.matches('#avatar') && !event.target.matches('#triangle')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    }


    var as = document.getElementsByTagName('a');
    let link1 = document.getElementById('link1');
    let link2 = document.getElementById('link2');
    let link3 = document.getElementById('link3');
    for (var i = 0; i < as.length; i++) {
        as[i].addEventListener('click', function(e) {
            e.preventDefault();
            let tableau = {};
            var url = this.getAttribute('href');
            var title = this.innerHTML;
            console.log(title);
            
            console.log(link2);
            console.log(link3);
            if (link2.innerHTML != ''){link3.innerHTML = link2.innerHTML}
            if (link2.href != ''){link3.href = link2.href;}
            if (link1.innerHTML != ''){link2.innerHTML = title}
            
            
            if (link1.href != ''){link2.href = link1.href;}
            link1.innerHTML = title;
            link1.href = url;console.log(link1);
            let forms = new FormData();
            tableau.link3 = {title: link3.title, url: link3.href};
            tableau.link2 = {title: link2.title, url: link2.href};
            tableau.link1 = {title: title, url: url};
            
            
            forms.append("data", JSON.stringify(tableau));
            fetch('/core/savevalue.php',{
                method: 'POST',
                body: forms
                })
                .then(response => response.json())
                .then(data => {
                })

            // window.location.href = url;
        });
    }

    function disappear() {
        var x = document.getElementById("alert");
        x.style.opacity = "0";
        setTimeout(function() {
            x.style.display = "none";
        }, 600);
    }

    function timeoutmod() {
        var modal = document.getElementById("alert");
        setTimeout(function() {
            modal.style.display = "none";
        }, 10000);
    }

</script>
<script src="/core/cookie-banner.js"></script>

</html>