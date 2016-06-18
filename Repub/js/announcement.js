function showAnnouncement(anuncio) {
    
    var imgCapaSpan = document.getElementById('imagem-capa');

    var imgCapa = document.createElement('img');
    imgCapa.src = anuncio.imagemCapa;

    var titulo = document.getElementById('titulo-anuncio');
    titulo.innerHTML = anuncio.titulo;
    
    var descricao = document.getElementById('desctricao-anuncio');
    descricao.innerHTML = anuncio.descricao;

    //var imgPequenas = document.getElementById('anuncio-thumbnails-div');
    //imgPequenas.style.display = 'flex';

    for (i = 0; i < anuncio.imagens.length; i++) {
        alert(anuncio.imagens[i]);
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