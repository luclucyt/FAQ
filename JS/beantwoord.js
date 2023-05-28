let beantwoordButtons = document.querySelectorAll('.beantwoordVraag');

beantwoordButtons.forEach(function (button) {
    button.addEventListener('click', function () {
        let vraagId = button.getAttribute('data-vraagId');
        let vraag = button.getAttribute('data-vraag');

        let antwoordWrapper = document.getElementsByClassName('beantwoord-wrapper')[0];

        antwoordWrapper.innerHTML = '';

        antwoordWrapper.innerHTML = `
            <input type="hidden" name="vraagID" value="` + vraagId + `">
            
            <h2>Beantwoord vraag: "` + vraag + `"</h2>

            <input type="text" name="veranderVraag" placeholder="Verander vraag..." class="veranderVraag"><br>
            
            <label for="isPublic">Publiek?</label>
            <input type="checkbox" name="isPublic" value="0" id="isPublic">

            <textarea type="textarea" name="antwoord" placeholder="Antwoord..." required="required" id="editor"></textarea>
            
            <input type="submit" name="beantwoordButton" value="Beantwoord" class="beantwoordButton">
        `;

        let antwoordButton = document.getElementsByClassName('beantwoordButton')[0];
        
        antwoordButton.addEventListener('click', function () {
            alert('Vraag beantwoord!');
            antwoordWrapper.submit();
            location.reload();
        });

        ClassicEditor.create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
    })
});
