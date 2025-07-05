// === Fungsi Soft Skill === //

function updateRemoveSoftSkillButtons() {
  const rows = document.querySelectorAll(".softSkillRow");
  rows.forEach((row, index) => {
    const removeButton = row.querySelector(".removeSoftSkill");
    removeButton.style.display =
      rows.length > 1 && index > 0 ? "inline-block" : "none";
  });
}

document.getElementById("addSoftSkill").addEventListener("click", function () {
  const container = document.getElementById("softSkillContainer");
  const newRow = document.createElement("div");
  newRow.classList.add("softSkillRow");
  newRow.innerHTML = `
                    <div id="softSkillContainer">
                        <div class="softSkillRow input-group mb-1">
                            <span class="input-group-text" id="inputGroup-sizing-default">Soft Skill</span>
                            <input type="text" placeholder="Masukkan Kemampuan Anda" class="form-control" name="softskills[]" aria-label="Sizing example input"
                            aria-describedby="inputGroup-sizing-default">
                            <button type="button" class="removeSoftSkill text-light bg-danger border-0 rounded-end" id="button-addon2">-</button>
                        </div>
                    </div>
            `;
  container.appendChild(newRow);

  newRow
    .querySelector(".removeSoftSkill")
    .addEventListener("click", function () {
      newRow.remove();
      updateRemoveSoftSkillButtons();
    });

  updateRemoveSoftSkillButtons();
});

document.querySelectorAll(".removeSoftSkill").forEach((button) => {
  button.addEventListener("click", function () {
    button.parentElement.remove();
    updateRemoveSoftSkillButtons();
  });
});

updateRemoveSoftSkillButtons();
