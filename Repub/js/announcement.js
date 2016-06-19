function showAnnouncement(anuncio) {

    var imgCapaSpan = document.getElementById('imagem-capa');

    var imgCapa = document.createElement('img');
    imgCapa.src = anuncio.imagemCapa;

    var titulo = document.getElementById('titulo-anuncio');
    titulo.innerHTML = anuncio.titulo;

    var descricao = document.getElementById('desctricao-anuncio');
    descricao.innerHTML = anuncio.descricao;

    //TODO: javascript para as pequenas imagens

    for (i = 0; i < anuncio.imagens.length; i++) {
        var imgDiv = document.createElement('div');
        imgDiv.id = 'anuncio-imagem-thumbnail-div[' + i + ']';
        imgDiv.name = 'anuncio-imagem-thumbnail-div[' + i + ']';
        imgDiv.className = 'images-input-field';

        var img = document.createElement('div');
        img.className = "image-preview";
        img.id = 'anuncio-imagem-preview[' + i + ']';
        img.name = 'anuncio-imagem-preview[' + i + ']';
        img.className = 'editar-anuncio-imagem-thumbnail';
        img.style.backgroundImage = 'url(' + anuncio.imagens[i] + ')';

        var imgPequenas = document.getElementById('anuncio-thumbnails-div');
        imgPequenas.style.display = 'flex';

        imgDiv.appendChild(img);
        imgPequenas.appendChild(imgDiv);

    };

    var nomeP = document.getElementById('nome-anuncio');
    nomeP.innerHTML = anuncio.nome;

    var enderecoDiv = document.getElementById('endereco-anuncio');
    enderecoDiv.innerHTML = anuncio.endereco + ' - ' + anuncio.bairro + ' ' + anuncio.cidade + '-' + anuncio.estado;

    var telefoneP = document.getElementById('telefone-anuncio');
    if (anuncio.telefone.length == 0) {
        telefoneP.remove();
    } else {
        var telefone = anuncio.telefone[0];
        for (i = 1; i < anuncio.telefone.length; i++) {
            telefone = telefone + ' / ' + anuncio.telefone[i];
        }
        telefoneP.innerHTML = 'Telefone de contato: ' + anuncio.telefone;
    }

    var valorMedioContasDiv = document.getElementById('valormediocontas-anuncio');
    valorMedioContasDiv.innerHTML = 'Valor Médio das Contas: ' + anuncio.valorMedioContas;

    var internetDiv = document.getElementById('internet-anuncio');
    internetDiv.innerHTML = 'Velocidade da Internet: ' + anuncio.internet + 'Mbps';

    var garagemDiv = document.getElementById('garagem-anuncio');
    garagemDiv.innerHTML = (anuncio.garagem) ? 'Possui Garagem' : 'Não possui garagem';

}