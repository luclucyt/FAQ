//filter FAQ (by name)
document.getElementById('searchInput').addEventListener('keyup', searchFAQ);

function searchFAQ(){
    let searchInput = document.getElementById('searchInput').value;
    searchInput = searchInput.toLowerCase();

    console.log(searchInput);

    let FAQ = document.getElementsByClassName('FAQ-category-wrapper-BTN');
    for (let i = 0; i < FAQ.length; i++) {
        let vraag = document.getElementsByClassName('FAQ-vraag-vraag')[i].innerHTML.toLowerCase();

        if(searchInput !== "") {
            if(vraag.includes(searchInput)) {
                FAQ[i].style.display = "block";
                FAQ[i].style.width = "15vw";
            } else {
                FAQ[i].style.display = "none";
                FAQ[i].style.width = "0";
            }
        } else {
            FAQ[i].style.display = "block";
            FAQ[i].style.width = "15vw";
        }
    }
}

document.getElementById('FAQ-filter-select').addEventListener('change', filterFAQ);

function filterFAQ(){
    let filterSelect = document.getElementById('FAQ-filter-select').value;
    let FAQ = document.getElementsByClassName('FAQ-category-wrapper-BTN');

    filterSelect = filterSelect.toLowerCase();

    for (let i = 0; i < FAQ.length; i++) {

        if(filterSelect !== "alles") {
            if(FAQ[i].classList.contains("FAQ-category-wrapper-" + filterSelect)){
                FAQ[i].style.display = "block";
                FAQ[i].style.width = "15vw";
            } else {
                FAQ[i].style.display = "none";
                FAQ[i].style.width = "0";
            }
        } else {
            FAQ[i].style.display = "block";
            FAQ[i].style.width = "15vw";
        }
    }
}