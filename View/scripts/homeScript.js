  
  //changement du slider
  document.addEventListener("DOMContentLoaded", function () {
    $.ajax({
        url: 'index.php?router=getEventsActivities',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            let mergedData = [...data.events, ...data.activities];
            let titlesTable = mergedData.map(event => event.nom);
            let contentTable = mergedData.map(event => event.description);
            let bgSrcTable = mergedData.map(event => event.photo);
            let index = 0;

            // Afficher immédiatement la première slide
            let imgDiv = document.querySelector(".sliderImg");
            let title = document.getElementById("title");
            let content = document.getElementById("content");
            let dotsDiv = document.querySelector(".barres");
            let dots = dotsDiv.getElementsByTagName("h3");

            // Initialiser le premier contenu sans animation
            imgDiv.style.backgroundImage = `url(${bgSrcTable[0]})`;
            title.innerText = titlesTable[0];
            content.innerText = contentTable[0];
            dots[0].style.opacity = "1";

            function updateSlide(newIndex) {
                // Reset current dot
                dots[index].style.opacity = "0.4";
                
                // Update index
                index = newIndex % mergedData.length;
                
                // Start transition
                let text = document.getElementById("textContainer");
                text.classList.add("dissolve");
                
                // Update content after fade out
                setTimeout(() => {
                    imgDiv.style.backgroundImage = `url(${bgSrcTable[index]})`;
                    title.innerText = titlesTable[index];
                    content.innerText = contentTable[index];
                    dots[index].style.opacity = "1";
                    text.classList.remove("dissolve");
                }, 1000);
            }

            // Start the interval after displaying first slide
            setInterval(() => {
                updateSlide(index + 1);
            }, 4000);
            updateNewsCards(data);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching events:', error);
        }
    });
});

  //pour la sticky nav bar,ajouter la classe sticky au nav lorsque on atteint le top de la page
  window.onscroll = function () {
    let nav = document.querySelector("nav");
    let imgDiv = document.getElementsByClassName("sliderImg")[0];
    let heroHeight = imgDiv.offsetHeight;

    if (window.scrollY >= heroHeight) {
      nav.classList.add("sticky"); // Ajoute la classe sticky quand on dépasse la hauteur de .hero
      nav.style.borderRadius = "0";
    } else {
      nav.classList.remove("sticky"); // Retire la classe sticky quand on est en haut
      nav.style.borderRadius = "16px 16px 0px 0px";
    }
  };
  const popup = document.getElementsByClassName("popup")[0];
  const popContainer = document.getElementsByClassName("popContainer")[0];
  //script pour la gestion de la popup des avis
 
  window.addEventListener("click", (event) => {
    if (event.target === popContainer) {
      popContainer.style.display = "none";
      popup.style.display = "none";
    }
  });

  
  function updateNewsCards(data) {
    const newsContainer = document.getElementById('newsCards');
    newsContainer.innerHTML = '';     
    let mergedData = [...data.events, ...data.activities];
    mergedData.slice(0, 3).forEach(item => {
        const newsCard = document.createElement('div');
        newsCard.className = 'newsCard';
        newsCard.innerHTML = `
            <h4>${item.nom}</h4>
            <p>${item.description}</p>
        `;
        newsContainer.appendChild(newsCard);
    });
}


//le fetch du tableau d'offres 
$(document).ready(function() {
  fetchOffres();
  fetchPartenaireLogos();
  
});

function fetchOffres() {

  $.ajax({
      url: 'index.php?router=getRandom10Offres',
      type: 'GET',
      dataType: 'json',
      success: function(data) {
          updateOffresTable(data);
      },
      error: function(xhr, status, error) {
          console.error('Error fetching offers:', error);
      }
  });
}

// Nouvelle fonction pour mettre à jour la table
function updateOffresTable(data) {
  const offresTable = $('#offersTable');
  offresTable.find('tr:not(.head)').remove();
  
  data.forEach(function(offre) {
      offresTable.append(`<tr>
          <td>${offre.partenaireVille}</td>
          <td>${offre.partenaireCategorie}</td>
          <td>${offre.partenaireNom}</td>
          <td>${offre.offreContenu}</td>
      </tr>`);
  });
}

//le tri :
function sortTable(column) {
  const table = $('#offersTable');
  const rows = table.find('tr:not(.head)').get();
  const currentOrder = table.data('order') || 'asc';
  const newOrder = currentOrder === 'asc' ? 'desc' : 'asc';
  
  rows.sort(function(a, b) {
      const A = $(a).children('td').eq(getColumnIndex(column)).text().toLowerCase();
      const B = $(b).children('td').eq(getColumnIndex(column)).text().toLowerCase();
      
      return currentOrder === 'asc' 
          ? A.localeCompare(B) 
          : B.localeCompare(A);
  });
  
  rows.forEach(function(row) {
      table.append(row);
  });
  
  table.data('order', newOrder);
}

function getColumnIndex(column) {
  const columns = {
      'partenaireVille': 0,
      'partenaireCategorie': 1,
      'partenaireNom': 2,
      'offreContenu': 3
  };
  return columns[column] || 0;
}


function fetchPartenaireLogos() {
  $.ajax({
    url: 'index.php?router=getPartenaireLogos',
    type: 'GET',
    dataType: 'json',
    success: function(data) {
      updateLogosSlider(data);
    },
    error: function ( xhr, status, error) {
      console.log(xhr);
      console.log(status);
      console.error('Error fetching partenaire logos:', error);
    }
  });
}

function updateLogosSlider(data) {
  const logosSliders = document.querySelectorAll('.logos-slider');
  logosSliders.forEach(slider => {
    slider.innerHTML = ''; // Clear existing logos

    data.forEach(function(partenaire) {
      const img = document.createElement('img');
      img.src = `${partenaire.logo}`;
      img.alt = `${partenaire.id} logo`;
      img.width = 100;
      slider.appendChild(img);
    });
  });
}

$(document).ready(function() {
  fetchPartenaireLogos();
});