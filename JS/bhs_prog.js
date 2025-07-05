// === Fungsi Bahasa Pemrograman === //

function updateRemoveLanguageButtons() {
  const rows = document.querySelectorAll(".languagesRow");
  rows.forEach((row, index) => {
    const removeButton = row.querySelector(".removeLanguage");
    removeButton.style.display =
      rows.length > 1 && index > 0 ? "inline-block" : "none";
  });
}

document.getElementById("addLanguage").addEventListener("click", function () {
  const container = document.getElementById("languagesContainer");
  const newRow = document.createElement("div");
  newRow.classList.add("languagesRow", "input-group", "mb-1");
  newRow.innerHTML = `

                    <div id="languagesContainer"> 
                        <div class="languagesRow input-group mb-1">
                            <span class="input-group-text" id="inputGroup-sizing-default">Bahasa Pemrograman</span>
                            <input type="text" placeholder="Masukkan Bahasa Pemrograman" class="form-control" name="languages[]" aria-label="Sizing example input"
                            aria-describedby="inputGroup-sizing-default">
                            <button type="button" class="removeLanguage text-light bg-danger border-0 rounded-end" id="button-addon2">-</button>
                        </div>
                    </div>
      `;
  container.appendChild(newRow);

  // Tambahkan event listener untuk tombol "remove"
  newRow
    .querySelector(".removeLanguage")
    .addEventListener("click", function () {
      newRow.remove();
      updateRemoveLanguageButtons();
    });

  updateRemoveLanguageButtons();
});

// Tambahkan event listener ke tombol "remove" yang ada di baris awal
document.querySelectorAll(".removeLanguage").forEach((button) => {
  button.addEventListener("click", function () {
    button.parentElement.remove();
    updateRemoveLanguageButtons();
  });
});

// Inisialisasi untuk menyembunyikan tombol "remove" pada baris pertama
updateRemoveLanguageButtons();
