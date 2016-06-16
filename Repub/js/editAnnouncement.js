function fillForm(anuncio) {
    var titulo = document.getElementById('titulo');
    titulo.value = anuncio.titulo;

    var nome = document.getElementById('nome');
    nome.value = anuncio.nome;

    var telefone = document.getElementById('telefone');
    telefone.value = anuncio.telefone;

    var descricao = document.getElementById('descricao');
    descricao.innerHTML = anuncio.descricao;

    var endereco = document.getElementById('endereco');
    endereco.value = anuncio.endereco;

    var bairro = document.getElementById('bairro');
    bairro.value = anuncio.bairro;

    var cidade = document.getElementById('cidade');
    cidade.value = anuncio.cidade;

    var estado = document.getElementById('estado');
    estado.value = anuncio.estado;

    var garagemTrue = document.getElementById('garagem-true');
    var garagemFalse = document.getElementById('garagem-false');
    garagemTrue.checked = anuncio.garagem;
    garagemTrue.value = anuncio.garagem;
    garagemFalse.checked = !anuncio.garagem;
    garagemFalse.value = !anuncio.garagem;

    var valorContas = document.getElementById('valorContas');
    valorContas.value = anuncio.valorContas;

    var internet = document.getElementById('internet');
    internet.value = anuncio.internet;

    for (i = 0; i < anuncio.imagens.length; i++) {
        var anuncioImagem = document.getElementById('anuncio-imagem'+i);
        anuncioImagem.value = anuncio.imagens[i];
    }

    for (i = 0; i < anuncio.quartos.length; i++) {
        addRoom();

        var valorQuarto = document.getElementById('quarto-' + i + '-valor');
        valorQuarto.value = anuncio.quartos[i].valor;

        var descricaoQuarto = document.getElementById('quarto-' + i + '-descricao');
        descricaoQuarto.innerHTML = anuncio.quartos[i].descricao;

        var quartoAlugadoTrue = document.getElementById('quarto-' + i + '-alugado-true');
        var quartoAlugadoFalse = document.getElementById('quarto-' + i + '-alugado-false');
        quartoAlugadoTrue.checked = anuncio.quartos[i].alugado;
        quartoAlugadoTrue.value = anuncio.quartos[i].alugado;
        quartoAlugadoFalse.checked = !anuncio.quartos[i].alugado;
        quartoAlugadoFalse.value = !anuncio.quartos[i].alugado;

        for (j = 0; j < anuncio.quartos[i].imagens.length; j++) {
            var quartoImagem = document.getElementById('quarto-'+i+'-imagem'+j);
            quartoImagem.value =anuncio.quartos[i].imagens[j];
        }
    }
}
