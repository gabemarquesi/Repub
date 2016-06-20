function showAnuncios(anuncios) {
    anuncios = [{ 'id': '1', 'imagemCapa': { 'endereco': 'images/indice0.jpg' }, 'titulo': 'Alugo republica com garagem.' },
            { 'id': '2', 'imagemCapa': { 'endereco': 'images/indice1.jpg' }, 'titulo': 'Alugo republica com cachorro.' },
            { 'id': '3', 'imagemCapa': { 'endereco': 'images/indice2.jpg' }, 'titulo': 'Alugo republica comunista.' }
    ];

    var divContainer = document.getElementById("grid-container");
    var i = 0;

    while (i < anuncios.length) {
        var row = document.createElement('div');
        row.className = "row";
        divContainer.appendChild(row);

        var j = 0;

        for (j = 0; j < 2 && i < anuncios.length; j++, i++) {
            var anuncioDiv = document.createElement('div');
            anuncioDiv.className = "col-md-6 col-lg-6 col-xs-6 col-sm-6 anuncio";
            anuncioDiv.id = 'anuncio-' + anuncios[i].id;

            var link = document.createElement('a');
            link.href = 'announcement.html?id=' + anuncios[i].id;

            var img = document.createElement('div');
            img.className = 'anuncio-img';
            img.style.backgroundImage = 'url("' + anuncios[i].imagemCapa.endereco + '")';
            img.style.backgroundPosition = 'center';
            img.style.backgroundRepeat = 'no-repeat';

            var titleDiv = document.createElement('div');
            titleDiv.className = 'anuncio-title';
            titleDiv.style.textAlign = "center";

            var text = document.createElement('p');
            text.className = 'anuncio-title-text';
            text.innerHTML = anuncios[i].titulo;

            titleDiv.appendChild(text);
            anuncioDiv.appendChild(link);
            link.appendChild(titleDiv);
            link.appendChild(img);
            row.appendChild(anuncioDiv);
        }
    }

}