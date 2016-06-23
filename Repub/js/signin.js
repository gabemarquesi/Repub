function login(usuario, senha) {

    httpGetAsync('repub.paginas/sign_in.php?action=login&email=' + usuario + '&senha=' + senha, function (response) {
        window.location.reload();
    });

}

function verify() {
    var logado = Cookies.get('PHPSESSID') != null;

    if (!logado) {
        window.location.href = 'signin.html';
    }
}