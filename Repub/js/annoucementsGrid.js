function switchTools(idAnuncio) {
    var editTool = document.getElementById(idAnuncio + '-edit-tool');
    var deleteTool = document.getElementById(idAnuncio + '-delete-tool');
    editTool.hidden = !editTool.hidden;
    deleteTool.hidden = !deleteTool.hidden;
}

function deleteConfirm(url) {
    return function () {

        if (confirm('Deseja mesmo excluir este anúncio?')) {
            alert(url);
            httpGet(url);
            window.location.reload();
        }
    };
}

function createGrids(anuncios) {

    var divContainer = document.getElementById("grid-container");
    var i = 0;

    while (i < anuncios.length) {
        var row = document.createElement('div');
        row.style.display = 'table-row';
        divContainer.appendChild(row);

        var j = 0;

        for (j = 0; j < 2 && i < anuncios.length; j++, i++) {
            var anuncioDiv = document.createElement('div');
            anuncioDiv.className = "col-md-6 col-lg-6 col-xs-6 col-sm-6 anuncio";
            anuncioDiv.id = 'anuncio-' + anuncios[i].id;

            var editLink = document.createElement('a');
            editLink.className = 'anuncio-edit';
            editLink.id = 'anuncio-' + anuncios[i].id + '-edit-tool';
            editLink.hidden = true;
            editLink.href = 'editannouncement.html?id=' + anuncios[i].id;

            var editImg = document.createElement('img');
            editImg.src = 'images/edit-white.png';
            editImg.style.height = '18px';
            editImg.style.width = '18px';

            var deleteLink = window.location.hostname + '/announcements.php?anuncio_id=' + anuncios[i].id + '&action=delete';
            //TODO: Verificar se o windows.location.hostname funciona em produção

            var canLink = document.createElement('span');
            canLink.className = 'anuncio-can';
            canLink.id = 'anuncio-' + anuncios[i].id + '-delete-tool';
            canLink.hidden = true;
            canLink.onclick = deleteConfirm(deleteLink);

            var canImg = document.createElement('img');
            canImg.src = 'images/recycle-bin-white.png';
            canImg.style.height = '20px';
            canImg.style.width = '20px';

            var link = document.createElement('a');
            link.href = 'announcement.html?id=' + anuncios[i].id;

            var img = document.createElement('div');
            img.className = 'anuncio-img';
            img.style.backgroundImage = 'url("' + anuncios[i].imagemCapa + '")';
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
            editLink.appendChild(editImg);
            canLink.appendChild(canImg);
            anuncioDiv.appendChild(canLink);
            anuncioDiv.appendChild(editLink);
            link.appendChild(titleDiv);
            link.appendChild(img);
            row.appendChild(anuncioDiv);
        }
    }

    $(".anuncio").hover(
function (event) {
    switchTools(this.id);
},
function (event) {
    switchTools(this.id);
}

);
}

