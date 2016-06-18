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
    valorContas.value = anuncio.valorMedioContas;

    var internet = document.getElementById('internet');
    internet.value = anuncio.internet;

    for (i = 0; i < anuncio.imagens.length; i++) {
        var imgDiv = document.createElement('div');
        imgDiv.id = 'anuncio-imagem-thumbnail-div[' + i + ']';
        imgDiv.name = 'anuncio-imagem-thumbnail-div[' + i + ']';
        imgDiv.className = 'images-input-field';

        var removeImg = document.createElement('div');
        removeImg.id = 'anuncio-imagem-thumbnail-delete[' + i + ']';
        removeImg.name = 'anuncio-imagem-thumbnail-delete[' + i + ']';
        removeImg.className = 'editar-anuncio-imagem-thumbnail-removeicon';
        removeImg.onclick = function () {
            var id = this.id.replace('-thumbnail-delete', '');
            var unhide = document.getElementById(id);
            unhide.hidden = false;
            unhide.style.display = '';
            var container = this.parentElement.parentElement;
            container.remove();
        };

        var img = document.createElement('div');
        img.className = "image-preview";
        img.id = 'anuncio-imagem-preview[' + i + ']';
        img.name = 'anuncio-imagem-preview[' + i + ']';
        img.className = 'editar-anuncio-imagem-thumbnail';
        img.style.backgroundImage = 'url(' + anuncio.imagens[i] + ')';

        var anuncioImagem = document.getElementById('anuncio-imagem[' + i + ']');
        anuncioImagem.hidden = true;
        anuncioImagem.style.display = 'none';

        var anuncioImagemDiv = document.getElementById('div-anuncio-imagem[' + i + ']');
        imgDiv.appendChild(img);
        img.appendChild(removeImg);
        anuncioImagemDiv.appendChild(imgDiv);
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
            var imgDiv = document.createElement('div');
            imgDiv.id = 'quarto-' + i + '-imagem-thumbnail-div[' + j + ']';
            imgDiv.name = 'quarto-' + i + '-imagem-thumbnail-div[' + j + ']';
            imgDiv.className = 'images-input-field';

            var removeImg = document.createElement('div');
            removeImg.id = 'quarto-' + i + '-imagem-thumbnail-delete[' + j + ']';
            removeImg.name = 'quarto-' + i + '-imagem-thumbnail-delete[' + j + ']';
            removeImg.className = 'editar-anuncio-imagem-thumbnail-removeicon';
            removeImg.onclick = function () {
                var id = this.id.replace('-thumbnail-delete', '');
                var unhide = document.getElementById(id);
                unhide.hidden = false;
                unhide.style.display = '';
                var container = this.parentElement.parentElement;
                container.remove();
            };

            var img = document.createElement('div');
            img.className = "image-preview";
            img.id = 'quarto' + i + '-imagem-preview[' + j + ']';
            img.name = 'quarto-' + i + '-imagem-preview[' + j + ']';
            img.className = 'editar-anuncio-imagem-thumbnail';            
            img.style.backgroundImage = 'url(' + anuncio.quartos[i].imagens[j] + ')';

            var quartoImagem = document.getElementById('quarto-' + i + '-imagem[' + j + ']');
            quartoImagem.hidden = true;
            quartoImagem.style.display = 'none';

            var quartoImagemDiv = document.getElementById('div-quarto-' + i + '-imagem[' + j + ']');
            imgDiv.appendChild(img);
            img.appendChild(removeImg);
            quartoImagemDiv.appendChild(imgDiv);
        }
    }
}
