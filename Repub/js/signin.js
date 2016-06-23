function login(usuario, senha) {

    $(document).ready(function () {
        document.getElementById('loginSenha').onblur = function () {
            $('#loginSenha').removeClass('credenciais-erradas');
        };

        document.getElementById('loginEmail').onblur = function () {
            $('#loginEmail').removeClass('credenciais-erradas');
        };
    });

    httpGetAsync('repub.paginas/sign_in.php?action=login&email=' + usuario + '&senha=' + senha, function (response) {
        var logado = JSON.parse(response);
        if (logado) {
            window.location.href = 'search.html';
        } else {
            $('#loginSenha').addClass('credenciais-erradas');
            $('#loginEmail').addClass('credenciais-erradas');
        }
    });

}

function verify() {
    var logado = Cookies.get('PHPSESSID') != null;

    if (!logado) {
        window.location.href = 'signin.html';
    }
}