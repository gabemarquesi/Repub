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
    billValue.name ='quarto-valor['+count+']';
    billValue.id = 'quarto-valor[' + count + ']';

    var billValueLabel = document.createElement('label');
    billValueLabel.style = 'color:gray; font-family: "Segoe UI Light";';
    billValueLabel.innerHTML = 'Reais';

    var descriptionDiv = document.createElement('div');

    var descriptionTextarea = document.createElement('textarea');
    descriptionTextarea.className = 'announcement-input';
    descriptionTextarea.required = 'required';
    descriptionTextarea.placeholder = 'Descrição';
    descriptionTextarea.name = 'quarto-descricao[' + count + ']';
    descriptionTextarea.id = 'quarto-descricao[' + count + ']';

    var rentDiv = document.createElement('div');

    var rentLabel = document.createElement('label');
    rentLabel.className = 'garagem-input';
    rentLabel.innerHTML = 'Quarto está alugado?';

    var rentTrue = document.createElement('input');
    rentTrue.type = 'radio';
    rentTrue.name = 'quarto-alugado-true[' + count + ']';
    rentTrue.id = 'quarto-alugado-true[' + count + ']';
    rentTrue.value = 'true';

    var spanTrue = document.createElement('span');
    spanTrue.style.margin = '5px';
    spanTrue.innerHTML = 'Sim';

    var rentFalse = document.createElement('input');
    rentFalse.type = 'radio';
    rentFalse.name = 'quarto-alugado-false[' + count + ']';
    rentFalse.id = 'quarto-alugado-false[' + count + ']';
    rentFalse.value = 'false';
    rentFalse.checked = 'checked';

    var spanFalse = document.createElement('span');
    spanFalse.style.margin = '5px';
    spanFalse.innerHTML = 'Não';

    var imagesDiv = document.createElement('div');

    var imagesRoomDiv0 = document.createElement('div');
    imagesRoomDiv0.id = 'div-quarto-' + count + '-imagem[0]';

    var imageLabel0 = document.createElement('label');
    imageLabel0.className = 'images-input';
    imageLabel0.innerHTML = 'Imagem 1';

    var imageInput0 = document.createElement('input');
    imageInput0.className = 'images-input-field default-button';
    imageInput0.type = 'file';
    imageInput0.name = 'quarto-' + count + '-imagem[0]';
    imageInput0.id = 'quarto-' + count + '-imagem[0]';

    var imagesRoomDiv1 = document.createElement('div');
    imagesRoomDiv1.id = 'div-quarto-' + count + '-imagem[1]';

    var imageLabel1 = document.createElement('label');
    imageLabel1.className = 'images-input';
    imageLabel1.innerHTML = 'Imagem 2';

    var imageInput1 = document.createElement('input');
    imageInput1.className = 'images-input-field default-button';
    imageInput1.type = 'file';
    imageInput1.name = 'quarto-' + count + '-imagem[1]';
    imageInput1.id = 'quarto-' + count + '-imagem[1]';

    var imagesRoomDiv2 = document.createElement('div');
    imagesRoomDiv2.id = 'div-quarto-' + count + '-imagem[2]';
    
    var imageLabel2 = document.createElement('label');
    imageLabel2.className = 'images-input';
    imageLabel2.innerHTML = 'Imagem 3';

    var imageInput2 = document.createElement('input');
    imageInput2.className = 'images-input-field default-button';
    imageInput2.type = 'file';
    imageInput2.name = 'quarto-' + count + '-imagem[2]';
    imageInput2.id = 'quarto-' + count + '-imagem[2]';

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
    imagesRoomDiv0.appendChild(imageLabel0);
    imagesRoomDiv0.appendChild(imageInput0);
    imagesRoomDiv1.appendChild(imageLabel1);
    imagesRoomDiv1.appendChild(imageInput1);
    imagesRoomDiv2.appendChild(imageLabel2);
    imagesRoomDiv2.appendChild(imageInput2);
    imagesDiv.appendChild(imagesRoomDiv0);
    imagesDiv.appendChild(imagesRoomDiv1);
    imagesDiv.appendChild(imagesRoomDiv2);
    rentDiv.appendChild(borderDiv);
    rooms.appendChild(roomDiv);

}

function addPhone() {
    var count = document.getElementsByClassName('telefone-div').length;

    var phones = document.getElementById('telefone');

    var phoneDiv = document.createElement('div');
    phoneDiv.className = 'telefone-div';

    var phone = document.createElement('input');
    phone.dataToggle = 'tooltip';
    phone.title = 'Telefone para contato';
    phone.className = 'announcement-input';
    phone.type = 'tel';
    phone.name = 'telefone[' + count + ']';
    phone.id = 'telefone[' + count + ']';
    phone.placeholder = 'Tel/Cel';

    phoneDiv.appendChild(phone);
    phones.appendChild(phoneDiv);

}

