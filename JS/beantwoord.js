let beantwoordButtons = document.querySelectorAll('.beantwoordVraag');

beantwoordButtons.forEach(function (button) {
    button.addEventListener('click', function () {
        let vraagId = button.getAttribute('data-vraagId');

        let antwoordWrapper = document.getElementsByClassName('beantwoord-wrapper')[0];

        antwoordWrapper.innerHTML = '';

        let antwoordIdInput = document.createElement('input');
        antwoordIdInput.setAttribute('type', 'hidden');
        antwoordIdInput.setAttribute('name', 'vraagID');
        antwoordIdInput.setAttribute('value', vraagId);

        let antwoordIsPublicLabel = document.createElement('label');
        antwoordIsPublicLabel.setAttribute('for', 'isPublic');
        antwoordIsPublicLabel.innerHTML = 'Publiek?';

        let antwoordIsPublic = document.createElement('input');
        antwoordIsPublic.setAttribute('type', 'checkbox');
        antwoordIsPublic.setAttribute('name', 'isPublic');
        antwoordIsPublic.setAttribute('value', '0');
        antwoordIsPublic.setAttribute('id', 'isPublic');

        let veranderVraag = document.createElement('input');
        veranderVraag.setAttribute('type', 'text');
        veranderVraag.setAttribute('name', 'veranderVraag');
        veranderVraag.setAttribute('placeholder', 'Verander vraag...');
        veranderVraag.setAttribute('required', 'required');


        let antwoordTextArea = document.createElement('textarea');
        antwoordTextArea.setAttribute('type', 'textarea');
        antwoordTextArea.setAttribute('name', 'antwoord');
        antwoordTextArea.setAttribute('placeholder', 'Antwoord...');
        antwoordTextArea.setAttribute('required', 'required');
        antwoordTextArea.setAttribute('id', 'editor');

        let antwoordButton = document.createElement('input');
        antwoordButton.setAttribute('type', 'submit');
        antwoordButton.setAttribute('name', 'beantwoordButton');
        antwoordButton.setAttribute('value', 'Beantwoord');

        antwoordButton.addEventListener('click', function () {
            alert('Vraag beantwoord!');
            antwoordWrapper.submit();
            location.reload();
        });

        antwoordWrapper.appendChild(antwoordIdInput);
        antwoordWrapper.appendChild(antwoordIsPublicLabel);
        antwoordWrapper.appendChild(antwoordIsPublic);
        antwoordWrapper.appendChild(veranderVraag);
        antwoordWrapper.appendChild(antwoordTextArea);
        antwoordWrapper.appendChild(antwoordButton);

        
        ClassicEditor.create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
    })
});
