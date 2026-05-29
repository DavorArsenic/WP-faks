const STORAGE_KEY = "playlist_storage_v1";

let playlist = [];
let odabrane = [];
let odabraneUPlaylisti = [];

// =====================
// INIT (IZ PHP-a)
// =====================
prikaziPjesme(svePjesme);
popuniZanrove(svePjesme);
popuniRaspolozenja(svePjesme);

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
// SELEKCIJA
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
// DODAJ U PLAYLISTU
// =====================
function dodajOdabrane() {

  let duplicateFound = false;
  let successFound = false;

  odabrane.forEach(id => {

    fetch('playlist.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: `song_id=${id}`
    })

    .then(res => res.text())

    .then(data => {

      if (data === "duplicate") {
        duplicateFound = true;
      }

      if (data === "success") {
        successFound = true;
      }

      // kratko čekanje da svi fetch pozivi završe
      setTimeout(() => {

        if (duplicateFound) {

          prikaziObavijest(
            "Neke pjesme već postoje u playlisti!"
          );

        } else if (successFound) {

          prikaziObavijest(
            "Dodano u playlistu!"
          );

        }

      }, 200);

    });

  });

  odabrane = [];
}

// =====================
// PLAYLIST UI
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
// UKLONI IZ PLAYLISTE
// =====================
function ukloniOdabrane() {
  odabraneUPlaylisti.forEach(id => {
    fetch('remove_from_playlist.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `song_id=${id}`
    });
  });

  odabraneUPlaylisti = [];
  prikaziObavijest("Uklonjeno iz playliste!");
  setTimeout(() => location.reload(), 500);
}

// =====================
// PLAYLIST PRIKAZ
// =====================
function prikaziPlaylistu() {
  const lista = document.getElementById('playlist');
  if (!lista) return;

  lista.innerHTML = '';
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
// DROPDOWNS
// =====================
function popuniZanrove(pjesme) {
  const container = document.getElementById('genre-dropdown');
  const zanrovi = [...new Set(pjesme.map(p => p.zanr))];

  zanrovi.forEach(z => {
    const label = document.createElement('label');
    label.innerHTML = `
      <input type="checkbox" value="${z}" onchange="filtriraj()">
      ${z}
    `;
    container.appendChild(label);
  });
}

function popuniRaspolozenja(pjesme) {
  const container = document.getElementById('mood-dropdown');
  const moods = [...new Set(pjesme.map(p => p.raspolozenje))];

  moods.forEach(m => {
    const label = document.createElement('label');
    label.innerHTML = `
      <input type="checkbox" value="${m}" onchange="filtriraj()">
      ${m}
    `;
    container.appendChild(label);
  });
}

// =====================
// TOGGLE UI
// =====================
function toggleGenreDropdown() {
  document.getElementById('genre-dropdown').classList.toggle('show');
}

function toggleMoodDropdown() {
  document.getElementById('mood-dropdown').classList.toggle('show');
}

function togglePlaylist() {
  const el = document.getElementById('playlist-container');
  el.style.display = el.style.display === 'none' ? 'block' : 'none';
}

// =====================
// TOAST
// =====================
function prikaziObavijest(msg) {
  const toast = document.getElementById('toast');
  toast.textContent = msg;
  toast.style.display = 'block';

  setTimeout(() => {
    toast.style.display = 'none';
  }, 2000);
}