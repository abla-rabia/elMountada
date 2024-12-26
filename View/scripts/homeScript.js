
document.addEventListener('DOMContentLoaded', function () {
    //changement du slider 
    let titlesTable = ["Title one", "Title two", "Title three"];
    let contentTable = ["Our Winter Getaway Package is here! Enjoy 20% off, free breakfast, and access to the rooftop pool. Book now for stays from Dec 15 to Feb 28!", "Our Winter Getaway Package is here! Enjoy 20% off, free breakfast, and access to the rooftop pool. Book now for stays from Dec 15 to Feb 28!", "Our Winter Getaway Package is here! Enjoy 20% off, free breakfast, and access to the rooftop pool. Book now for stays from Dec 15 to Feb 28!"];
    let bgSrcTable = ["View/assets/slider1.png", "View/assets/slider2.png", "View/assets/slider3.png"];
    let index = 0;
    
    
    setInterval(() => {
        let dotsDiv = document.getElementsByClassName("barres")[0]
        let dots = dotsDiv.getElementsByTagName("h3");
        let title = document.getElementById("title")
        let content = document.getElementById("content")
        let text = document.getElementById("textContainer")
        let imgDiv = document.getElementsByClassName("sliderImg")[0]
        setTimeout(() => {
            text.classList.add('dissolve');  
            setTimeout(() => {
                dots[index].style.opacity = "0.4";
                index++;
                index = index % 3;
                console.log(index)
                text.classList.remove('dissolve');  
                imgDiv.style.backgroundImage = `url(${bgSrcTable[index]})`;
                title.innerText = titlesTable[index];
                dots[index].style.opacity = "1";
                content.innerText = contentTable[index];

            }, 1000);
        }, 1000);
    }, 4000);

    //pour la sticky nav bar,ajouter la classe sticky au nav lorsque on atteint le top de la page 
    window.onscroll = function() {
        let nav = document.querySelector('nav');
        let imgDiv = document.getElementsByClassName("sliderImg")[0]
        let heroHeight = imgDiv.offsetHeight;
    
        if (window.scrollY >= heroHeight) {
            nav.classList.add('sticky');  // Ajoute la classe sticky quand on dépasse la hauteur de .hero
            nav.style.borderRadius = "0";
        } else {
            nav.classList.remove('sticky');  // Retire la classe sticky quand on est en haut
            nav.style.borderRadius = "16px 16px 0px 0px";
        }
    };
    
    

})