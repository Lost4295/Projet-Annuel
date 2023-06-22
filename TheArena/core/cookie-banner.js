function showCookieBanner() {
    let cookieBanner = document.getElementById("cb-cookie-banner");
    cookieBanner.style.display = "block";
}

function hideCookieBanner() {
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

    if(isCookieAccepted === "no") {
        showCookieBanner();
    }

    if(isCookieAccepted === "yes") {
        hideCookieBanner();
    }
}

window.cb_hideCookieBanner = hideCookieBanner;
