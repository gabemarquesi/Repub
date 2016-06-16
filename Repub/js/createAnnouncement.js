function addRoom() {
    var count = document.getElementsByClassName('quarto-div').length;

    var rooms = document.getElementById('quartos');

    var roomDiv = document.createElement('div');
    roomDiv.className = 'quarto-div';

    var billValue = document.createElement('input');
    billValue.className = 'announcement-input-details';
    billValue.type = 'number';
    billValue.min = '0';
    billValue.required = 'required';
    billValue.placeholder = 'Valor';
    billValue.name ='quarto-' + count + '-valor';
    billValue.id = 'quarto-' + count + '-valor';

    var billValueLabel = document.createElement('label');
    billValueLabel.style = 'color:gray; font-family: "Segoe UI Light";';
    billValueLabel.innerHTML = 'Reais';

    var descriptionDiv = document.createElement('div');

    var descriptionTextarea = document.createElement('textarea');
    descriptionTextarea.className = 'announcement-input';
    descriptionTextarea.required = 'required';
    descriptionTextarea.placeholder = 'Descrição';
    descriptionTextarea.name = 'quarto-' + count+'-descricao';
    descriptionTextarea.id = 'quarto-' + count + '-descricao';

    var rentDiv = document.createElement('div');

    var rentLabel = document.createElement('label');
    rentLabel.className = 'garagem-input';
    rentLabel.innerHTML = 'Quarto está alugado?';

    var rentTrue = document.createElement('input');
    rentTrue.type = 'radio';
    rentTrue.name = 'quarto-' + count + '-alugado';
    rentTrue.id = 'quarto-' + count + '-alugado';
    rentTrue.value = 'true';

    var spanTrue = document.createElement('span');
    spanTrue.style.margin = '5px';
    spanTrue.innerHTML = 'Sim';

    var rentFalse = document.createElement('input');
    rentFalse.type = 'radio';
    rentFalse.name = 'quarto-' + count + '-alugado';
    rentFalse.id = 'quarto-' + count + '-alugado';
    rentFalse.value = 'false';
    rentFalse.checked = 'checked';

    var spanFalse = document.createElement('span');
    spanFalse.style.margin = '5px';
    spanFalse.innerHTML = 'Não';

    var imagesDiv = document.createElement('div');

    var imageLabel1 = document.createElement('label');
    imageLabel1.className = 'images-input';
    imageLabel1.innerHTML = 'Imagem 1';

    var imageInput1 = document.createElement('input');
    imageInput1.className = 'images-input-field default-button';
    imageInput1.type = 'file';
    imageInput1.name = 'quarto-' + count + '-imagem0';
    imageInput1.id = 'quarto-' + count + '-imagem0';

    var imageLabel2 = document.createElement('label');
    imageLabel2.className = 'images-input';
    imageLabel2.innerHTML = 'Imagem 2';

    var imageInput2 = document.createElement('input');
    imageInput2.className = 'images-input-field default-button';
    imageInput2.type = 'file';
    imageInput2.name = 'quarto-' + count + '-imagem1';
    imageInput2.id = 'quarto-' + count + '-imagem1';

    var imageLabel3 = document.createElement('label');
    imageLabel3.className = 'images-input';
    imageLabel3.innerHTML = 'Imagem 3';

    var imageInput3 = document.createElement('input');
    imageInput3.className = 'images-input-field default-button';
    imageInput3.type = 'file';
    imageInput3.name = 'quarto-' + count + '-imagem2';
    imageInput3.id = 'quarto-' + count + '-imagem2';

    var borderDiv = document.createElement('div');
    borderDiv.className = 'room-border';

    roomDiv.appendChild(billValue);
    roomDiv.appendChild(billValueLabel);
    roomDiv.appendChild(descriptionDiv);
    descriptionDiv.appendChild(descriptionTextarea);
    roomDiv.appendChild(rentDiv);
    rentDiv.appendChild(rentLabel);
    rentDiv.appendChild(rentTrue);
    rentDiv.appendChild(spanTrue);
    rentDiv.appendChild(rentFalse);
    rentDiv.appendChild(spanFalse);
    rentDiv.appendChild(imagesDiv);
    imagesDiv.appendChild(imageLabel1);
    imagesDiv.appendChild(imageInput1);
    imagesDiv.appendChild(imageLabel2);
    imagesDiv.appendChild(imageInput2);
    imagesDiv.appendChild(imageLabel3);
    imagesDiv.appendChild(imageInput3);
    rentDiv.appendChild(borderDiv);
    rooms.appendChild(roomDiv);

}