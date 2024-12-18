document.addEventListener('DOMContentLoaded', async () => {
    if (!avent) return;

    const data = {
        tirages: await getTirages(),
        tirage: await getTirageJour()
    };
    console.log({ data })

    const date = getCurrentDate();

    if (!estDansPlageDeDates(avent.debut_avent, avent.fin_avent, date))
        return console.log(`Calendrier de l'avant inactif à cette date`);

    console.log('Calendrier de l\'avent !')

    const heure = getCurrentTime();



    console.log('Tirage du jour ' + date)


    if (data.tirage) {
        const gagnant = document.querySelector('.user[data-id="' + data.tirage + '"]')
        gagnant.dataset.gagnant = true;
        bravo(gagnant)
        return console.log(`Tirage déjà fait pour le ${date}`);
    }
	if (!master) {
		console.log('Le tirage doit etre fait sur le trombi ?master=true');
		return;
	}

    console.log(`Le tirage est à faire !`);
    if (heure < avent.heure_tirage)
        return console.log(`Ce n'est pas encore l'heure du tirage`);

    console.log('C\'est l\'heure du tirage ! ' + date)


    faireTirage();

    function bravo(user) {
        const cloneUser = cloneElement(user);
        console.log(cloneUser)
        cloneUser.classList.add('bravo')
        document.querySelector('.users').append(cloneUser)
        setTimeout(() => {
            cloneUser.classList.add('display')
            setTimeout(() => {
                cloneUser.classList.add('end')
                setTimeout(() => {
                    cloneUser.remove()
                }, 1000)
            }, 5000)
        })

    }
    async function faireTirage() {
        const gagnant = pickRandomUser();
        const user_id = Number(gagnant.dataset.id);
        if (ilResteDesPersonneNonLaureatesAjourdHui()) {
            if (Object.values(data.tirages).includes(user_id)) {
                console.log('Deja lauréat et il y a d\'autres personnes au cowo qui n\'ont pas encore gagné ! On recommence');
				setTimeout(faireTirage,500);
                return 
            }
        }
		console.log('Gagnant : ',gagnant)

        const url = WP_API_URL + '/trombi/avent/tirage';
        const body = {
            date_tirage: getCurrentDate(),
            user_id
        };

        return fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        })
            .then(response => response.json())
            .then(async response => {
                console.log(response)
            })

    }
    function ilResteDesPersonneNonLaureatesAjourdHui() {
        const users = getUsers()
        for (const user of users) {
            if (!Object.values(data.tirages).includes(user.dataset.id)) {
                return true;
            }
        }
    }
    async function getTirages() {
        return await fetch(WP_API_URL + '/trombi/avent/tirages').then(response => {
            return response.json()
        })
    }

    async function getTirageJour() {
        return await fetch(WP_API_URL + '/trombi/avent/tirage?date_tirage=' + getCurrentDate()).then(response => {
            return response.json()
        })
    }
    function estDansPlageDeDates(debut, fin, date = null) {
        const [annee, mois, jour] = date.split('-');
        const [anneeDebut, moisDebut, jourDebut] = debut.split('-');
        const [anneeFin, moisFin, jourFin] = fin.split('-');

        const dateCible = new Date(annee, mois - 1, jour);
        const dateDebut = new Date(anneeDebut, moisDebut - 1, jourDebut);
        const dateFin = new Date(anneeFin, moisFin - 1, jourFin);

        return dateCible >= dateDebut && dateCible <= dateFin;
    };

    async function tirageDejaFait(date) {


        if (data.tirage) return true;

    }

    function getUsers() {
        return document.querySelectorAll('.user[data-visiteur="false"]');
    }
    function pickRandomUser() {
        // Select all elements matching the criteria
        const elements = getUsers();

        // Check if there are any elements
        if (elements.length === 0) {
            console.log('No elements found.');
            return null; // Or handle this case as needed
        }

        // Pick a random element from the NodeList
        const randomIndex = Math.floor(Math.random() * elements.length);
        const randomElement = elements[randomIndex];

        return randomElement;
    }

    // Function to clone an element and append it to a specified parent
    function cloneElement(elementToClone) {
        // Select the element to be cloned

        if (!elementToClone) {
            return;
        }

        // Clone the element. Use cloneNode(true) to clone with child elements (deep clone)
        const clonedElement = elementToClone.cloneNode(true);

        return clonedElement
    }


})