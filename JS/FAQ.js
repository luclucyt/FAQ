//filter FAQ (by name)
document.getElementById('searchInput').addEventListener('keyup', searchFAQ);

function searchFAQ(){
    let searchInput = document.getElementById('searchInput').value;
    searchInput = searchInput.toLowerCase();


    let FAQ = document.getElementsByClassName('FAQ-category-wrapper-BTN');
    for (let i = 0; i < FAQ.length; i++) {
        let vraag = document.getElementsByClassName('FAQ-vraag-vraag')[i].innerHTML.toLowerCase();
        if(FAQ[i].parentElement.classList.contains("active")) {
            if(searchInput !== "") {
                if(vraag.includes(searchInput)) {
                    FAQ[i].style.display = "-webkit-box";
                    FAQ[i].style.width = "100%";
                } else {
                    FAQ[i].style.display = "none";
                    FAQ[i].style.width = "0";
                }
            } else {
                FAQ[i].style.display = "-webkit-box";
                FAQ[i].style.width = "100%";
            }
        }
    }
}

document.getElementById('FAQ-filter-select').addEventListener('change', filterFAQ);

function filterFAQ(){
    let filterSelect = document.getElementById('FAQ-filter-select').value;
    let FAQ = document.getElementsByClassName('FAQ-category-wrapper-BTN');
    let FAQcategory = document.getElementsByClassName('FAQ-category-wrapper');
    filterSelect = filterSelect.toLowerCase();

    for (let i = 0; i < FAQcategory.length; i++) {
        if(FAQcategory[i].querySelector('.FAQ-category-title').innerHTML.toLowerCase() === filterSelect) {
            FAQcategory[i].classList.add("active");
        }else {
            FAQcategory[i].classList.remove("active");
        }
    }
    // for (let i = 0; i < FAQ.length; i++) {
    //     if(FAQ[i].parentElement.classList.contains("active")) {
    //         if (filterSelect !== "alles") {
    //             if (FAQ[i].classList.contains("FAQ-category-wrapper-" + filterSelect)) {
    //                 FAQ[i].style.display = "-webkit-box";
    //                 FAQ[i].style.width = "100%";
    //             } else {
    //                 FAQ[i].style.display = "none";
    //                 FAQ[i].style.width = "0";
    //             }
    //         } else {
    //             FAQ[i].style.display = "-webkit-box";
    //             FAQ[i].style.width = "100%";
    //         }
    //     }
    // }
}


let categorys =  document.getElementsByClassName('FAQ-category-wrapper')

for (let i = 0; i < categorys.length; i++) {
    categorys[i].addEventListener('click', function(){
        if (categorys[i].classList.contains("active")) {
            categorys[i].classList.remove("active")
        } else {
            categorys[i].classList.add("active")
        }
    });
}