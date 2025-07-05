// === Fungsi Pengalaman === //

function updateRemoveExperienceButtons() {
  const rows = document.querySelectorAll(".experienceRow");
  rows.forEach((row, index) => {
    const removeButton = row.querySelector(".removeExperience");
    // Hanya tampilkan tombol hapus jika ada lebih dari satu baris
    removeButton.style.display = rows.length > 1 ? "inline-block" : "none";
  });
}

// Fungsi untuk menambahkan pengalaman baru
document.getElementById("addExperience").addEventListener("click", function () {
  const container = document.getElementById("experienceContainer");
  const newRow = document.createElement("div");
  newRow.classList.add("experienceRow", "input-group", "mb-1");
  newRow.innerHTML = `
    <span class="input-group-text">Pengalaman</span>
    <input type="text" class="form-control" name="title-experience[]" placeholder="Tempat/Lokasi - Status(Waktu)">
    <input type="text" class="form-control" name="experience[]" placeholder="Deskripsikan Pekerjaan">
    <button type="button" class="removeExperience bg-danger text-light ms-1 border-0 rounded-end">-</button>
  `;
  container.appendChild(newRow);

  // Tambahkan event listener untuk tombol hapus di baris baru
  newRow
    .querySelector(".removeExperience")
    .addEventListener("click", function () {
      newRow.remove();
      updateRemoveExperienceButtons();
    });

  updateRemoveExperienceButtons();
});

// Tambahkan event listener untuk semua tombol hapus yang sudah ada
document.querySelectorAll(".removeExperience").forEach((button) => {
  button.addEventListener("click", function () {
    button.parentElement.remove();
    updateRemoveExperienceButtons();
  });
});

// Perbarui tombol hapus saat halaman pertama kali dimuat
updateRemoveExperienceButtons();
