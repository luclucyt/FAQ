let beantwoordButtons = document.querySelectorAll('.beantwoordVraag');
let antwoordWrapper = document.getElementsByClassName('beantwoord-wrapper')[0];

beantwoordButtons.forEach(function (button) {
    button.addEventListener('click', function () {
        let vraagId = button.getAttribute('data-vraagId');
        let vraag = button.getAttribute('data-vraag');
        let vraagOmschrijving = button.getAttribute('data-omschrijving');
        let edit = button.getAttribute('data-edit'); // 0 = false, 1 = true
        let vraagTags = button.getAttribute('data-tag');

        vraagTags = vraagTags.charAt(0).toUpperCase() + vraagTags.slice(1);

        document.getElementById('vraagID').value = vraagId;
        document.getElementById('vraagElement').innerHTML = 'Vraag: "'  + vraag + '"';
        document.getElementsByClassName('vraag-omschrijving')[0].innerHTML = 'Omschrijving: "' + vraagOmschrijving + '"';
        document.getElementById('categorie').value = vraagTags;

        let antwoordButton = document.getElementsByClassName('beantwoordButton')[0];
        
        antwoordButton.addEventListener('click', function () {
            antwoordWrapper.submit();
            location.reload();
        });
    })
});
