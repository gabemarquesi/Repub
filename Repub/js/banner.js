function setLink(url) {
    return function () {
        window.location.href = url;
    };
}

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

function addBanner() {
    var body = document.getElementsByTagName('body')[0];
    var banner = document.createElement('div');
    banner.className = 'banner';

    var logoSpan = document.createElement('span');
    logoSpan.className = 'banner-logo-icon';

    var logo = document.createElement('img');
    logo.src = "images/logo-icon.png";
    logo.style.width = '80px';
    logo.style.height = '80px';

    var title = document.createElement('h1');
    title.className = 'banner-title-big';
    title.innerHTML = 'Repub';

    var slogan = document.createElement('h2');
    slogan.className = 'banner-title-small';
    slogan.innerHTML = 'Encontre sua republica de qualquer lugar';

    var menu = document.createElement('div');
    menu.className = 'menu';

    var menuLinks = [['home', 'home.html'],
                    ['pesquisar', 'search.html'],
                    ['anunciar', 'createannouncement.html'],
                    ['meus anúncios', 'announcements.html']];

    var signInButton = document.createElement('button');
    signInButton.className = 'signin-button';
    signInButton.innerHTML = 'Entrar';
    signInButton.onclick = setLink('signin.html');


    for (i = 0; i < menuLinks.length; i++) {
        var menuButton = document.createElement('p');
        menuButton.className = 'menu-title-text';
        var url = menuLinks[i][1];
        menuButton.onclick = setLink(url);
        menuButton.innerHTML = menuLinks[i][0];
        menu.appendChild(menuButton);
    }

    banner.appendChild(signInButton);
    logoSpan.appendChild(logo);
    banner.appendChild(logoSpan);
    banner.appendChild(title);
    banner.appendChild(slogan);
    banner.appendChild(menu);
    body.insertBefore(banner, body.firstChild);    
}