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

        let antwoordTextArea = document.createElement('textarea');
        antwoordTextArea.setAttribute('type', 'textarea');
        antwoordTextArea.setAttribute('name', 'antwoord');
        antwoordTextArea.setAttribute('placeholder', 'Antwoord...');
        antwoordTextArea.setAttribute('required', 'required');

        let antwoordButton = document.createElement('input');
        antwoordButton.setAttribute('type', 'submit');
        antwoordButton.setAttribute('name', 'beantwoordButton');
        antwoordButton.setAttribute('value', 'Beantwoord');

        antwoordWrapper.appendChild(antwoordIdInput);
        antwoordWrapper.appendChild(antwoordTextArea);
        antwoordWrapper.appendChild(antwoordButton);
    })
});
