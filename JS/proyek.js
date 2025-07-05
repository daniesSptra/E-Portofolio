// === Fungsi Proyek === //

function updateRemoveProjectButtons() {
  const rows = document.querySelectorAll(".projectRow");
  rows.forEach((row, index) => {
    const removeButton = row.querySelector(".removeProject");
    removeButton.style.display =
      rows.length > 1 && index > 0 ? "inline-block" : "none";
  });
}

document.getElementById("addProject").addEventListener("click", function () {
  const container = document.getElementById("projectContainer");
  const newRow = document.createElement("div");
  newRow.classList.add("projectRow", "input-group", "mb-1");
  newRow.innerHTML = `
    <input type="file" class="form-control" name="project_thumbnail[]" accept="image/*" aria-label="Thumbnail">
    <input type="url" class="form-control" name="project_link[]" placeholder="Tautan" aria-label="Tautan">
    <input type="text" class="form-control" name="project_title[]" placeholder="Judul" aria-label="Judul">
    <textarea class="form-control" name="project_description[]" placeholder="Deskripsi" aria-label="Deskripsi"></textarea>
    <button type="button" class="removeProject bg-danger text-light ms-1 border-0 rounded-end">-</button>
  `;
  container.appendChild(newRow);

  newRow.querySelector(".removeProject").addEventListener("click", function () {
    newRow.remove();
    updateRemoveProjectButtons();
  });

  updateRemoveProjectButtons();
});

document.querySelectorAll(".removeProject").forEach((button) => {
  button.addEventListener("click", function () {
    button.parentElement.remove();
    updateRemoveProjectButtons();
  });
});

updateRemoveProjectButtons();
