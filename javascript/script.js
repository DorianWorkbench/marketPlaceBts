function erreur() {
    var erreur = document.getElementById("erreur");
    setTimeout(function () {
        erreur.style.display = "flex";
        setTimeout(function () {
            erreur.style.display = "none";
        },1500)
    });
}
