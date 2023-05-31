let beantwoordButtons = document.querySelectorAll('.beantwoordVraag');

beantwoordButtons.forEach(function (button) {
    button.addEventListener('click', function () {
        let vraagId = button.getAttribute('data-vraagId');
        let vraag = button.getAttribute('data-vraag');
        let vraagOmschrijving = button.getAttribute('data-omschrijving');
        let edit = button.getAttribute('data-edit'); // 0 = false, 1 = true

        document.getElementById('vraagID').value = vraagId;
        document.getElementById('vraagElement').innerHTML = 'Vraag: "'  + vraag + '"';
        document.getElementsByClassName('vraag-omschrijving')[0].innerHTML = 'Omschrijving: "' + vraagOmschrijving + '"';
        
        let antwoordButton = document.getElementsByClassName('beantwoordButton')[0];
        
        antwoordButton.addEventListener('click', function () {
            antwoordWrapper.submit();
            location.reload();
        });
    })
});