    const filtersFranchise = document.querySelector("#filterFranchise");

    const searchFranchiseName = document.querySelector("#searchNameFranchise");
    const searchFranchiseCity = document.querySelector("#searchCityFranchise");
    const franchiseActiveNull = document.querySelector("#franchiseActiveNull");
    const franchiseActive = document.querySelector("#franchiseActive");
    const franchiseNoActive = document.querySelector("#franchiseNoActive");

    // Interception des appuis sur clavier
    searchFranchiseName.addEventListener("keydown", () => {
        // Récupération des données du formulaire
        const Form = new FormData(filtersFranchise);
        console.log(Form);
        // Fabrication "QueryString"
        const Params = new URLSearchParams();

        Form.forEach(   (value, key) => {
            Params.append(key, value);
        })

        // Récupération de l'url active
        const url = new URL(window.location.href);

        console.log(url.pathname);
        console.log(Params);
        // Lancement de la requête ajax
        fetch(url.pathname + "?" + Params.toString() + "&ajax=1", {
            // Rajoute la méthodologie du fetch
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            }
        }).then(response =>
            response.json()
        ).then(data => {
            const content = document.querySelector('#content')
            content.innerHTML = data.content
            console.log(content)
        }).catch(e => alert(e));
    });
        //
        // searchFranchiseCity.addEventListener("keydown", () => {
        //     console.log('ola2')
        // });
        //
        // franchiseActiveNull.addEventListener("click", () => {
        //     console.log('ola3')
        // });
        // franchiseActive.addEventListener("click", () => {
        //     console.log('ola4')
        // });
        // franchiseNoActive.addEventListener("click", () => {
        //     console.log('ola5')
        // });
