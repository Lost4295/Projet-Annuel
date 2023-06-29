function showCookieBanner() {
    let cookieBanner = document.getElementById("cb-cookie-banner");
    cookieBanner.style.display = "block";
}

function hideCookieBanner() {
    localStorage.setItem("cb_isCookieAccepted", "yes");
    let cookieBanner = document.getElementById("cb-cookie-banner");
    disappear(cookieBanner);
}

function noCookie() {
    localStorage.setItem("cb_isCookieAccepted", "yes");
    let cookieBanner = document.getElementById("cb-cookie-banner");
    cookieBanner.style.display = "none";
}
function initializeCookieBanner() {

    let isCookieAccepted = localStorage.getItem("cb_isCookieAccepted");

    if (isCookieAccepted === null) {
        localStorage.setItem("cb_isCookieAccepted", "no");
        showCookieBanner();
    }

    if (isCookieAccepted === "no") {
        if(!document.__defineGetter__) {
            Object.defineProperty(document, 'cookie', {
                get: function(){return ''},
                set: function(){return true},
            });
        } else {
            document.__defineGetter__("cookie", function() { return '';} );
            document.__defineSetter__("cookie", function() {} );
        }
        showCookieBanner();
    }

    if (isCookieAccepted === "yes") {
        noCookie();
    }
}

window.cb_hideCookieBanner = hideCookieBanner;
