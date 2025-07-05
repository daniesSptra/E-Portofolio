// === Fungsi Sertifikat === //

function updateRemoveCertificateButtons() {
  const rows = document.querySelectorAll(".certificateRow");
  rows.forEach((row, index) => {
    const removeButton = row.querySelector(".removeCertificate");
    removeButton.style.display =
      rows.length > 1 && index > 0 ? "inline-block" : "none";
  });
}

document
  .getElementById("addCertificate")
  .addEventListener("click", function () {
    const container = document.getElementById("certificateContainer");
    const newRow = document.createElement("div");
    newRow.classList.add("certificateRow", "input-group", "mb-1");
    newRow.innerHTML = `
      <input type="file" class="form-control" name="certificate_thumbnail[]" accept="image/*" aria-label="Thumbnail">
      <input type="url" class="form-control" name="certificate_link[]" placeholder="Tautan" aria-label="Tautan">
      <input type="text" class="form-control" name="certificate_description[]" placeholder="Judul atau Keterangan" aria-label="Keterangan">
      <button type="button" class="removeCertificate bg-danger text-light ms-1 border-0 rounded-end">-</button>
    `;
    container.appendChild(newRow);

    newRow
      .querySelector(".removeCertificate")
      .addEventListener("click", function () {
        newRow.remove();
        updateRemoveCertificateButtons();
      });

    updateRemoveCertificateButtons();
  });

document.querySelectorAll(".removeCertificate").forEach((button) => {
  button.addEventListener("click", function () {
    button.parentElement.remove();
    updateRemoveCertificateButtons();
  });
});

updateRemoveCertificateButtons();
