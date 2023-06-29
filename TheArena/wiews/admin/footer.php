                </div>
                </div>
                </div>
                </div>
                
                <script>
                    let toto = new URL(window.location.href);
                    console.log(toto);
                    if (toto.pathname == "/admin") {
                        document.getElementById("dashboard").classList.remove('link-dark');
                    } else {
                        document.getElementById("dashboard").classList.add('link-dark');
                    }
                    if (toto.pathname.includes("/admin/signalements")) {
                        document.getElementById("reports").classList.remove('link-dark');
                    } else {
                        document.getElementById("reports").classList.add('link-dark');
                    }
                    if (toto.pathname.includes("/admin/events")) {
                        document.getElementById("events").classList.remove('link-dark');
                    } else {
                        document.getElementById("events").classList.add('link-dark');
                    }
                    if (toto.pathname.includes("/admin/users")) {
                        document.getElementById("users").classList.remove('link-dark');
                    } else {
                        document.getElementById("users").classList.add('link-dark');
                    }
                    if (toto.pathname.includes("/admin/forums")) {
                        document.getElementById("forums").classList.remove('link-dark');
                    } else {
                        document.getElementById("forums").classList.add('link-dark');
                    }
                    if (toto.pathname.includes("/admin/tournaments") || toto.pathname.includes("/admin/tournament")) {
                        document.getElementById("tournaments").classList.remove('link-dark');
                    } else {
                        document.getElementById("tournaments").classList.add('link-dark');
                    }
                    if (toto.pathname.includes("/admin/shops") || toto.pathname.includes("/admin/shop") || toto.pathname.includes("admin/item")) {
                        document.getElementById("shops").classList.remove('link-dark');
                    } else {
                        document.getElementById("shops").classList.add('link-dark');
                    }
                    if (toto.pathname.includes("/admin/settings")) {
                        document.getElementById("settings").classList.remove('link-dark');
                    } else {
                        document.getElementById("settings").classList.add('link-dark');
                    }


                    window.onload = (event) => {
                        setTimeout(function() {
                            document.getElementById("loading").classList.add('hideev');
                            setTimeout(function() {
                                document.getElementById("loading").classList.add('d-none');
                            }, 600)
                        }, 1000);
                        let url = new URL(window.location.href);
                        if (url.pathname.includes("/admin/users/create")|| url.pathname.includes("/admin/users/update")) 
                        {
                            document.getElementById("adresse").addEventListener("input", autocompleteAdresse, false);
                        }
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
                        }, 5000);
                    }
                </script>
                </body>

                </html>