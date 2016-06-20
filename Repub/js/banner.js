function setLink(url) {
    return function () {
        window.location.href = url;
    };
}

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

$(window).scroll(function () {
    var sticky = $('.banner'),
        scroll = $(window).scrollTop();
    var body = document.getElementsByTagName('body')[0];

    if (scroll >= 30) {
        if ($('.banner-fixo').length)
            return;

        var body = document.getElementsByTagName('body')[0];
        var banner = document.createElement('div');
        banner.className = 'banner banner-fixo';

        var logoSpan = document.createElement('span');
        logoSpan.className = 'banner-logo-icon banner-logo-icon-small';

        var logo = document.createElement('img');
        logo.src = "images/logo-icon.png";
        logo.className = 'banner-logo-icon-normal banner-icon-small';

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
        signInButton.className = 'signin-button signin-button-fixo';
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

        sticky.css({'visibility': 'hidden', 'max-height':'170px', 'min-height':'170px'});   
        $('.search-filter').css('top', '150px');
    }
    else {
        sticky.css({ 'visibility': 'visible', 'max-height': '530px', 'min-height': '230px' });
        $('.banner-fixo').remove();
        $('.search-filter').css('top', '230px');
        $('.sigin-button').removeClass('signin-button-fixo');
    }
});

function addBanner() {
    var body = document.getElementsByTagName('body')[0];
    var banner = document.createElement('div');
    banner.className = 'banner';
    
    var logoSpan = document.createElement('span');
    logoSpan.className = 'banner-logo-icon';

    var logo = document.createElement('img');
    logo.src = "images/logo-icon.png";
    logo.className = 'banner-logo-icon-normal';
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