﻿function fillForm(anuncio) {
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
    valorContas.value = anuncio.valorMedioContas;

    var internet = document.getElementById('internet');
    internet.value = anuncio.internet;

    for (i = 0; i < anuncio.imagens.length; i++) {
        var img = document.createElement('img');
        img.src = anuncio.imagens[i];
        img.style.width = 48;
        img.style.height = 48;

        var anuncioImagem = document.getElementById('anuncio-imagem[' + i + ']');
        anuncioImagem.hidden = true;
        var anuncioImagemDiv = document.getElementById('div-anuncio-imagem[' + i + ']');
        anuncioImagemDiv.appendChild(img);
    }

    for (i = 0; i < anuncio.quartos.length; i++) {
        addRoom();

        var valorQuarto = document.getElementById('quarto-valor[' + i + ']');
        valorQuarto.value = anuncio.quartos[i].valor;

        var descricaoQuarto = document.getElementById('quarto-descricao[' + i + ']');
        descricaoQuarto.innerHTML = anuncio.quartos[i].descricao;

        var quartoAlugadoTrue = document.getElementById('quarto-alugado-true[' + i + ']');
        var quartoAlugadoFalse = document.getElementById('quarto-alugado-false[' + i + ']');
        quartoAlugadoTrue.checked = anuncio.quartos[i].alugado;
        quartoAlugadoTrue.value = anuncio.quartos[i].alugado;
        quartoAlugadoFalse.checked = !anuncio.quartos[i].alugado;
        quartoAlugadoFalse.value = !anuncio.quartos[i].alugado;

        for (j = 0; j < anuncio.quartos[i].imagens.length; j++) {
            var quartoImagem = document.getElementById('quarto-' + i + '-imagem[' + j + ']');
            quartoImagem.value = anuncio.quartos[i].imagens[j];
        }
    }
}
