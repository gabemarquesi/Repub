function trocaImagemCapa(endereço){
    var imgCapaSpan = document.getElementById('imagem-capa');
    imgCapaSpan.style.backgroundImage = endereço;
}

function showAnnouncement(anuncio) {
    document.title = 'Repub - ' + anuncio.titulo;

    var imgCapaSpan = document.getElementById('imagem-capa');
    imgCapaSpan.style.backgroundImage = 'url(' + anuncio.imagemCapa + ')';

    var titulo = document.getElementById('titulo-anuncio');
    titulo.innerHTML = anuncio.titulo;

    var descricao = document.getElementById('desctricao-anuncio');
    descricao.innerHTML = anuncio.descricao;

    //TODO: javascript para as pequenas imagens

    for (i = 0; i < anuncio.imagens.length; i++) {
        var imgDiv = document.createElement('div');
        imgDiv.id = 'anuncio-imagem-thumbnail-div[' + i + ']';
        imgDiv.name = 'anuncio-imagem-thumbnail-div[' + i + ']';
        imgDiv.style.backgroundImage = 'url(' + anuncio.imagens[i] + ')';
        imgDiv.className = 'imagens-quarto';
        imgDiv.style.marginLeft = '6.25%';
        imgDiv.onclick= function(){
            trocaImagemCapa(this.style.backgroundImage);
        };

        var imgPequenas = document.getElementById('anuncio-thumbnails-div');

        imgPequenas.appendChild(imgDiv);

    };

    var nomeP = document.getElementById('nome-anuncio');
    nomeP.innerHTML = anuncio.nome;

    var enderecoDiv = document.getElementById('endereco-anuncio');
    enderecoDiv.innerHTML = anuncio.endereco + ' - ' + anuncio.bairro + ' ' + anuncio.cidade + ' - ' + anuncio.estado;

    var telefoneP = document.getElementById('telefone-anuncio');
    if (anuncio.telefone.length == 0) {
        telefoneP.remove();
    } else {
        var telefone = anuncio.telefone[0];
        for (i = 1; i < anuncio.telefone.length; i++) {
            telefone = telefone + '  /  ' + anuncio.telefone[i];
        }
        telefoneP.innerHTML = 'Telefone de contato: ' + telefone;
    }

    var valorMedioContasDiv = document.getElementById('valormediocontas-anuncio');
    valorMedioContasDiv.innerHTML = 'Valor Médio das Contas: R$ ' + anuncio.valorMedioContas;

    var internetDiv = document.getElementById('internet-anuncio');
    if (anuncio.internet == null) {
        internetDiv.remove();
    } else {
        internetDiv.innerHTML = 'Velocidade da Internet: ' + anuncio.internet + 'Mbps';
    }

    var garagemDiv = document.getElementById('garagem-anuncio');
    garagemDiv.innerHTML = (anuncio.garagem) ? 'Possui Garagem' : 'Não possui garagem';

    var quartosDiv = document.getElementById('quartos');

    for (i = 0; i < anuncio.quartos.length; i++) {
        if (anuncio.quartos[i].alugado == true) {
            continue
        }

        var quartoDiv = document.createElement('div');

        var valorQuartoP = document.createElement('p');
        valorQuartoP.className = 'descricao-anuncio';
        valorQuartoP.id = 'quarto[' + i + ']-valor';
        valorQuartoP.innerHTML = 'Aluguel: R$' + anuncio.quartos[i].valor;

        var descricaoQuartoP = document.createElement('p');
        descricaoQuartoP.className = 'descricao-anuncio';
        descricaoQuartoP.id = 'quarto[' + i + ']-descricao';
        descricaoQuartoP.innerHTML = anuncio.quartos[i].descricao;

        quartoDiv.appendChild(valorQuartoP);
        quartoDiv.appendChild(descricaoQuartoP);

        var imagemDiv = document.createElement('div');
        imagemDiv.style.marginLeft = '100px';
        imagemDiv.id = 'div-imagem';

        for (j = 0; j < anuncio.quartos[i].imagens.length; j++) {
            var img = document.createElement('div');
            img.id = 'quarto-' + i + '-imagem[' + j + ']-thumbnail';
            img.style.backgroundImage = 'url(' + anuncio.quartos[i].imagens[j] + ')';
            img.className = 'imagens-quarto';

            imagemDiv.appendChild(img);
        }

        quartoDiv.appendChild(imagemDiv);
        quartosDiv.appendChild(quartoDiv);

        if (anuncio.quartos[i + 1] != null) {
            var borderDiv = document.createElement('div');
            borderDiv.className = 'room-border';
            quartoDiv.appendChild(borderDiv);
        }


    }
    var logado = true; // Teste para ver se esta logado ou não

    var enviarPerguntaDiv = document.getElementById('fazer-pergunta');

    var responderPerguntaDiv = document.getElementById('perguntas-para-responder');

    if (logado) {
        enviarPerguntaDiv.remove();
    
        for (i = 0;i<anuncio.perguntas.length;i++){
            if (anuncio.perguntas[i].resposta != null) {
                continue;
            }
            var formResposta = document.createElement('form');

            var questionP = document.createElement('p');
            questionP.className = 'perguntas-anuncio';
            questionP.id = 'pergunta[' + anuncio.perguntas[i].id+ ']';
            questionP.innerHTML = anuncio.perguntas[i].pergunta;

            var respostaInput = document.createElement('textarea');
            respostaInput.dataToggle = 'tooltip';
            respostaInput.title='resposta';
            respostaInput.className='announcement-input';
            respostaInput.id = 'resposta[' + anuncio.perguntas[i].id+ ']';
            respostaInput.name = 'resposta[' + anuncio.perguntas[i].id+ ']';
            respostaInput.placeholder='Responda aqui...';

            var buttonResposta = document.createElement('button');
            buttonResposta.style.marginLeft='100px';
            buttonResposta.style.marginBottom='50px';
            buttonResposta.className='default-button';
            buttonResposta.type='submit';
            buttonResposta.innerHTML = 'Enviar Resposta';

            var borderDiv = document.createElement('div');
            borderDiv.className = 'room-border';

            formResposta.appendChild(questionP);
            formResposta.appendChild(respostaInput);
            formResposta.appendChild(buttonResposta);
            responderPerguntaDiv.appendChild(formResposta);
            responderPerguntaDiv.appendChild(borderDiv);

        }

    } else {
        responderPerguntaDiv.remove();

    }

    var perguntasRespondidasDiv = document.getElementById('perguntas-respondidas');
    perguntasRespondidasDiv.style.display = 'inline';

    for (i = 0; i < anuncio.perguntas.length; i++) {
        if (anuncio.perguntas[i].resposta == null) {
            continue;
        }
        var perguntaDiv = document.createElement('div');

        var perguntaP = document.createElement('p');
        perguntaP.className = 'perguntas-anuncio';
        perguntaP.id = 'pergunta[' + i + ']';
        perguntaP.innerHTML = '<img src="images/social.png">  ' + anuncio.perguntas[i].pergunta;

        var imgResposta = document.createElement('img');
        imgResposta.src = 'images/social-1.png';

        var respostaP = document.createElement('p');
        respostaP.className = 'perguntas-anuncio';
        respostaP.style.marginLeft = '50px';
        respostaP.id = 'resposta[' + i + ']';
        respostaP.innerHTML = '<img src="images/social-1.png">  ' + anuncio.perguntas[i].resposta;

        var borderDiv = document.createElement('div');
        borderDiv.className = 'room-border';

        perguntaDiv.appendChild(perguntaP);
        perguntaDiv.appendChild(respostaP);
        perguntaDiv.appendChild(borderDiv);
        perguntasRespondidasDiv.appendChild(perguntaDiv);


    }
}

