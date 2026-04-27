const STORAGE_KEY = "playlist_storage_v1";

let svePjesme = [];
let playlist = JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
let odabrane = [];
let odabraneUPlaylisti = [];


// =====================
// FETCH PODATAKA
// =====================
fetch('glazba.json')
  .then(res => res.json())
  .then(data => {
    svePjesme = data;

    prikaziPjesme(data);
    popuniZanrove(data);
    popuniRaspolozenja(data);
    prikaziPlaylistu(); // load iz localStorage
  });


// =====================
// SPREMANJE PLAYLISTE
// =====================
function spremiPlaylistu() {
  localStorage.setItem(STORAGE_KEY, JSON.stringify(playlist));
}


// =====================
// TABLICA
// =====================
function prikaziPjesme(pjesme) {
  const tbody = document.getElementById('songs-table');
  tbody.innerHTML = '';

  pjesme.forEach(p => {
    const row = document.createElement('tr');

    if (odabrane.includes(p.id)) {
      row.classList.add('selected');
    }

    row.innerHTML = `
      <td>${p.id}</td>
      <td>${p.naslov}</td>
      <td>${p.izvodac}</td>
      <td>${p.zanr}</td>
      <td>${p.bpm}</td>
      <td>${p.godina}</td>
      <td>${p.popularnost}</td>
      <td>${p.raspolozenje}</td>
    `;

    row.onclick = () => toggleSelect(p.id, row);

    tbody.appendChild(row);
  });
}


// =====================
// SELEKCIJA TABLICE
// =====================
function toggleSelect(id, row) {
  if (odabrane.includes(id)) {
    odabrane = odabrane.filter(x => x !== id);
    row.classList.remove('selected');
  } else {
    odabrane.push(id);
    row.classList.add('selected');
  }
}


// =====================
// RESET SELEKCIJE TABLICE
// =====================
function ocistiSelektiraneUI() {
  document.querySelectorAll('#songs-table tr').forEach(tr => {
    tr.classList.remove('selected');
  });
  odabrane = [];
}


// =====================
// DODAJ U PLAYLISTU
// =====================
function dodajOdabrane() {
  odabrane.forEach(id => {
    const pjesma = svePjesme.find(p => p.id === id);
    if (!playlist.some(p => p.id === id)) {
      playlist.push(pjesma);
    }
  });

  ocistiSelektiraneUI();
  odabraneUPlaylisti = [];

  spremiPlaylistu();
  prikaziPlaylistu();
  prikaziObavijest("Dodano u playlistu!");
}


// =====================
// UKLONI ODABRANE IZ PLAYLISTE
// =====================
function ukloniOdabrane() {
  playlist = playlist.filter(p => !odabraneUPlaylisti.includes(p.id));

  odabraneUPlaylisti = [];

  spremiPlaylistu();
  prikaziPlaylistu();
  prikaziObavijest("Uklonjeno iz playliste!");
}


// =====================
// PRIKAZ PLAYLISTE
// =====================
function prikaziPlaylistu() {
  const lista = document.getElementById('playlist');
  lista.innerHTML = '';

  playlist.forEach(p => {
    const li = document.createElement('li');

    if (odabraneUPlaylisti.includes(p.id)) {
      li.classList.add('selected');
    }

    li.innerHTML = `
      <span>${p.naslov} - ${p.izvodac}</span>
    `;

    li.onclick = () => toggleSelectPlaylist(p.id, li);

    lista.appendChild(li);
  });
}


// =====================
// SELEKCIJA PLAYLISTE
// =====================
function toggleSelectPlaylist(id, el) {
  if (odabraneUPlaylisti.includes(id)) {
    odabraneUPlaylisti = odabraneUPlaylisti.filter(x => x !== id);
    el.classList.remove('selected');
  } else {
    odabraneUPlaylisti.push(id);
    el.classList.add('selected');
  }
}


// =====================
// FILTERI
// =====================
function filtriraj() {
  const tekst = document.getElementById('search').value.toLowerCase();
  const bpm = document.getElementById('filter-bpm').value;
  const yearFrom = document.getElementById('filter-year-from').value;
  const yearTo = document.getElementById('filter-year-to').value;

  const selectedGenres = Array.from(
    document.querySelectorAll('#genre-dropdown input:checked')
  ).map(cb => cb.value);

  const selectedMoods = Array.from(
    document.querySelectorAll('#mood-dropdown input:checked')
  ).map(cb => cb.value);

  const rezultat = svePjesme.filter(p => {
    return (
      (!tekst || p.naslov.toLowerCase().includes(tekst) || p.izvodac.toLowerCase().includes(tekst)) &&
      (p.bpm <= bpm) &&
      (!yearFrom || p.godina >= yearFrom) &&
      (!yearTo || p.godina <= yearTo) &&
      (selectedGenres.length === 0 || selectedGenres.includes(p.zanr)) &&
      (selectedMoods.length === 0 || selectedMoods.includes(p.raspolozenje))
    );
  });

  prikaziPjesme(rezultat);
}


// =====================
// EVENTI
// =====================
document.getElementById('search').addEventListener('input', filtriraj);
document.getElementById('filter-year-from').addEventListener('input', filtriraj);
document.getElementById('filter-year-to').addEventListener('input', filtriraj);

document.getElementById('filter-bpm').addEventListener('input', e => {
  document.getElementById('bpm-value').textContent = "0-" + e.target.value;
  filtriraj();
});


// =====================
// ŽANROVI
// =====================
function popuniZanrove(pjesme) {
  const container = document.getElementById('genre-dropdown');
  const zanrovi = [...new Set(pjesme.map(p => p.zanr))].sort();

  zanrovi.forEach(z => {
    const label = document.createElement('label');
    label.innerHTML = `
      <input type="checkbox" value="${z}" onchange="filtriraj()">
      ${z}
    `;
    container.appendChild(label);
  });
}


// =====================
// RASPOLOŽENJE
// =====================
function popuniRaspolozenja(pjesme) {
  const container = document.getElementById('mood-dropdown');
  const raspolozenja = [...new Set(pjesme.map(p => p.raspolozenje))].sort();

  raspolozenja.forEach(r => {
    const label = document.createElement('label');
    label.innerHTML = `
      <input type="checkbox" value="${r}" onchange="filtriraj()">
      ${r}
    `;
    container.appendChild(label);
  });
}


// =====================
// DROPDOWN TOGGLES
// =====================
function toggleGenreDropdown() {
  const el = document.getElementById('genre-dropdown');
  el.style.display = el.style.display === 'block' ? 'none' : 'block';
}

function toggleMoodDropdown() {
  const el = document.getElementById('mood-dropdown');
  el.style.display = el.style.display === 'block' ? 'none' : 'block';
}

function togglePlaylist() {
  const el = document.getElementById('playlist-container');
  el.style.display = el.style.display === 'none' ? 'block' : 'none';
}


// =====================
// TOAST OBAVIJEST
// =====================
function prikaziObavijest(poruka) {
  const toast = document.getElementById('toast');
  toast.textContent = poruka;
  toast.style.display = 'block';

  setTimeout(() => {
    toast.style.display = 'none';
  }, 2000);
}