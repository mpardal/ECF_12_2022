// Récupération du formulaire franchise/structure
const filtersForm = document.querySelector("form");
// Récupération de l'élément HTML qui accueillera le nouveau contenu
const listSection = document.querySelector('#content')

// On ne fait rien si on n'a pas trouvé de formulaire
if (filtersForm) {
    let timeout = null;
    // Récupération de tous les inputs du formulaire
    const inputs = filtersForm.querySelectorAll('input');

    inputs.forEach(input => {
        // Si l'input est de type radio, alors on écoute sur le click sinon, le keyup
        handleInput(input, input.getAttribute('type') === 'radio' ? 'click' : 'keyup')
    });

    /**
     * Lance la recherche quand un événement de type $event est déclenché pour le $input
     *
     * @param {HTMLInputElement} input
     * @param {'keyup' | 'click'} event
     */
    function handleInput(input, event) {
        input.addEventListener(event, () => {
            clearTimeout(timeout)

            // Permet d'attendre un certain temps avant de lancer la requête fetch
            timeout = setTimeout(() => {
                // Récupération des données du formulaire
                const form = new FormData(filtersForm);
                // Fabrication "QueryString" (exemple: name=test&city=bordeaux)
                const params = new URLSearchParams({
                    'name': form.get('name') ?? '',
                    'city': form.get('city') ?? '',
                    'active': form.get('active') ?? '',
                    'ajax': 1
                });

                // Récupération de l'url actuelle
                const url = new URL(window.location.href);

                fetch(`${url.pathname}?${params.toString()}`)
                    .then(response => response.json())
                    .then(data => {
                        listSection.innerHTML = data.content
                    })
            }, 300)
        });
    }

}