function showAnnouncement(anuncio) {
    var imgCapaSpan = document.getElementById('imagem-capa');

    var imgCapa = document.createElement('img');
    imgCapa.src = anuncio.imagemCapa;

    var titulo = document.getElementById('titulo-anuncio');
    titulo.innerHTML = anuncio.titulo;

    var descricao = document.getElementById(descricao - anuncio);
    descricao.innerHTML = anuncio.descricao;

    var imgPequenas = document.getElementById('imagens-pequenas');
    // for para as imagens pequenas

    var nomeDiv = document.getElementById('nome-anuncio');
    nomeDiv.innerHTML = anuncio.nome;

    var enderecoDiv = document.getElementById('endereço-anuncio');
    enderecoDiv.innerHTML = anuncio.endereco; // acertar de acordo com a beleza

    var telefoneDiv = document.getElementById('telefone-anuncio');
    telefoneDiv.innerHTML = anuncio.nome;

    var telefoneDiv = document.getElementById('telefone-anuncio');
    telefoneDiv.innerHTML = 'Telefone de contato: ' + anuncio.telefone;

    var valorMedioContasDiv = document.getElementById('valormediocontas-anuncio');
    valorMedioContasDiv.innerHTML = 'Valor Médio das Contas: ' + anuncio.valormediocontas;

    var internetDiv = document.getElementById('internet-anuncio');
    internetDiv.innerHTML = 'Velocidade da Internet: ' + anuncio.internet;

    var garagemDiv = document.getElementById('garagem-anuncio');
    garagemDiv.innerHTML = (anuncio.garagem) ? 'Possui Garagem' : 'Não possui garagem';

}