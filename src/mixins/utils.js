export function calculateAge(birthDateString) {
  const today = new Date();
  const birthDate = new Date(birthDateString);
  let age = today.getFullYear() - birthDate.getFullYear();
  const m = today.getMonth() - birthDate.getMonth();

  // Check if today is the anniversary
  if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
    age--;
  }

  // Return age if today is the anniversary, otherwise return null
  return (m === 0 && today.getDate() === birthDate.getDate()) ? age : null;
}

export function array_shuffle(originalArray) {
  // Create a copy of the original array
  let array = [...originalArray];

  // Shuffle the copied array
  for (let i = array.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [array[i], array[j]] = [array[j], array[i]];
  }

  return array;
}



export function isCurrentTimeAfter(heure) {
  const now = new Date();
  const [hours, minutes] = heure.split(':').map(Number);
  const tirageDate = new Date(now.getFullYear(), now.getMonth(), now.getDate(), hours, minutes);

  return now > tirageDate;
}
export function dateDuJour(date = null) {

  date = date || new Date();
  let jour = date.getDate().toString().padStart(2, '0');
  let mois = (date.getMonth() + 1).toString().padStart(2, '0');
  let annee = date.getFullYear();
  return `${jour}/${mois}/${annee}`;
}

export function estDansPlageDeDates(debut, fin, date = null) {
  date = date || dateDuJour();
  const [jour, mois, annee] = date.split('/');
  const [jourDebut, moisDebut, anneeDebut] = debut.split('/');
  const [jourFin, moisFin, anneeFin] = fin.split('/');

  const dateCible = new Date(annee, mois - 1, jour);
  const dateDebut = new Date(anneeDebut, moisDebut - 1, jourDebut);
  const dateFin = new Date(anneeFin, moisFin - 1, jourFin);

  return dateCible >= dateDebut && dateCible <= dateFin;
};


export function afterOneHour(codeToExecute) {
  return setTimeout(codeToExecute, 3600000); // 1 hour in milliseconds
}
export async function sha1(input) {
  const msgBuffer = new TextEncoder().encode(input);
  const hashBuffer = await crypto.subtle.digest("SHA-1", msgBuffer);
  const hashArray = Array.from(new Uint8Array(hashBuffer));
  const hashHex = hashArray
    .map((b) => b.toString(16).padStart(2, "0"))
    .join("");
  return hashHex;
}

// Fonction pour gérer la soumission du formulaire de connexion
export function connexion(response) {
  if (response.user) {
    // Authentification réussie
    auth.identifiant = response.user.login;
    auth.id = response.user.id;
    auth.name = response.user.name;
    auth.session = response.user.session_id;
    auth.fresh = true;

    reglages.reset();
    reglages.droits = response.reglages.droits;
    reglages.settings = response.reglages.settings;
    reglages.admin = response.reglages.admin;
    router.push("/"); // Redirection vers la page d'accueil
  } else if (response?.code) {
    // Gestion des erreurs d'authentification
    return alert(response.message);
  }
}
