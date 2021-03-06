'use strict'

let menu = document.getElementById('aside-menu');
let btnOpen = document.querySelectorAll('.open-button');
let isOpen = false;
let header = document.getElementsByTagName('header');
let main = document.getElementsByTagName('main');
let footer = document.getElementsByTagName('footer');
let body = document.getElementsByTagName('body');
let btnClose = document.getElementById('closeForm');


/*let preventDefault = (e) => {
    e = e || body[0].event;
    if (e.preventDefault) e.preventDefault();
    e.returnValue = false;
};


let disableScroll = () => {
    if (body.addEventListener) // older FF
        body.addEventListener('DOMMouseScroll', preventDefault(), false);
    body.onwheel = preventDefault; // modern standard
    body.onmousewheel = document.onmousewheel = preventDefault; // older browsers, IE
    body.ontouchmove = preventDefault; // mobile

    if (menu.removeEventListener) menu.removeEventListener('DOMMouseScroll', event.preventDefault(), false);
    menu.onmousewheel = menu.onmousewheel = null;
    menu.onwheel = null;
    menu.ontouchmove = null;
};

let enableScroll = () => {
    if (body.removeEventListener) body.removeEventListener('DOMMouseScroll', preventDefault, false);
    body.onmousewheel = document.onmousewheel = null;
    body.onwheel = null;
    body.ontouchmove = null;
    document.onkeydown = null;
};*/


let changeColors = () => {
    let windowHeight = window.innerHeight;
    windowHeight =windowHeight/4;

    let section = document.getElementsByClassName("fullSection");

    for( let i = 0 ; i<section.length ; i++ ) {
        let coords = section[i].getBoundingClientRect();
        let scrollPos = window.scrollY || window.scollTop || document.getElementsByTagName("html")[0].scrollTop;
        let clas = section[i].className;
        clas = clas.split(" ");
        clas = clas[1];
        let newClas = "white";

        switch(clas) {
            case "one":
                newClas = "white";
                break;
            case "two":
                newClas = "black";
                break;
            case "three":
                newClas = "blue";
                break;
            case "four":
                newClas = "black";
                break;
            case "five":
                newClas = "white2";
                break;
            default:
                newClas = "white";
        }

        if(coords.top < windowHeight && coords.top > 0 )
            document.querySelector("body").className = newClas;
        
        if( scrollPos < 600 )
            document.querySelector("body").className = "white";

    }  
}


let showVideo = (url) => {
    let video = document.createElement('iframe');
    video.className = "iframeVideo";
    video.setAttribute("src", "https://www.youtube.com/embed/"+url+"?rel=0&amp;controls=0&amp;showinfo=0&amp;autoplay=1");
    return video;
}

let validate = 0; 


(() => {
    let initEvents = () =>  {

        let mediaquery = window.matchMedia("(min-width: 1024px)");

        let pictures = document.querySelectorAll('.video img');
         Array.from(pictures).forEach(picture => { 
             picture.addEventListener('click', () => {
                if (!mediaquery.matches) {
                    document.getElementById(picture.getAttribute("data-video")).play();
                    document.getElementById(picture.getAttribute("data-video")).webkitEnterFullScreen();
                }
            });
             
         });


        let videos = document.querySelectorAll('video');
        Array.from(videos).forEach(video => {
            video.addEventListener('mouseover', () => {
                if (mediaquery.matches) {
                    video.play();
                }
            });

            video.addEventListener('mouseout', () => {
                video.pause();
            });

        });


        let inputs = document.querySelectorAll('input[type="text"], input[type="email"]');
        Array.from(inputs).forEach(field => {
            field.addEventListener('focus', () => {
                document.querySelector("label[for='"+field.getAttribute('id')+"']").style.color = "#FF1DBA";
            });

            field.addEventListener('blur', () => {
                document.querySelector("label[for='"+field.getAttribute('id')+"']").style.color = "#FFFFFF";
            });
        });

        Array.from(btnOpen).forEach(button => {
        button.addEventListener('click', toggleMenu);
        });

        btnClose.addEventListener('click', toggleMenu);

        main[0].addEventListener('click', () => {
            if (isOpen) {
                toggleMenu();
            }
        });

        footer[0].addEventListener('click', () =>  {
            if (isOpen) {
                toggleMenu();
            }
        });

        window.addEventListener('scroll', () =>  {
           changeColors();
        });
        

        
    };

    let hideMenu = () => {
        menu.className = 'aside-menu';
        isOpen = false;
        header[0].style.opacity=1;
        main[0].style.opacity=1;
        footer[0].style.opacity=1;
       /* enableScroll();*/
    };

    let showMenu = () => {
        menu.className = 'aside-menu open';
        setTimeout(function(){ isOpen = true; }, 300);
        header[0].style.opacity=0.5;
        main[0].style.opacity=0.5;
        footer[0].style.opacity=0.5;
        /*disableScroll();*/
    };

    let toggleMenu = () => {
        event.preventDefault();
        if (isOpen) hideMenu();else showMenu();
    };

    initEvents();
})();


$(document).ready(()=>{

    $(window).paroller();

    $("#form").submit(function(e) {
        
        
        $.ajax({
            type: "POST",
            url: "http://dccolorweb.com/nuu/sendmail.php",
            data: $("#form").serialize(),
            success: function(data)
            {
                if(data.success) {
                    $(".form-fields form").empty().append("<h2>Thanks, we’ll be in touch soon.</h2>")
                } else {
                    $(".form-fields form").empty().append("<h2>Error.</h2>")
                }
            }
            });
        e.preventDefault(); 
    });
});
