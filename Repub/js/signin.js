function login(usuario, senha) {

    document.cookie = "username=Henrique";

    httpGetAsync('signin.php', function (response) {
        if (JSON.parse(response) == true) {
           // Usuário Logado
        } else {
            // Falha ao logar
        }
    });

}

function verify() {
    var logado = Cookies.get('username') != null;

    if (!logado) {
        window.location.href = 'signin.html';
    }
}