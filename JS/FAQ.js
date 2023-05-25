function searchQuestions() {
    // Get the search input value
    var searchQuery = document.getElementById('searchInput').value.toLowerCase();

    // Get all the question elements
    var questions = document.querySelectorAll('#questionContainer .vraag-wrapper');

    // Loop through the questions and hide/show them based on the search query
    questions.forEach(function(question) {
        var questionHeader = question.querySelector('h2').textContent.toLowerCase();
        if (questionHeader.includes(searchQuery)) {
            question.style.display = 'block';  // Show the question
        } else {
            question.style.display = 'none';   // Hide the question
        }
    });
}

// Attach an event listener to the search input
document.getElementById('searchInput').addEventListener('input', searchQuestions);