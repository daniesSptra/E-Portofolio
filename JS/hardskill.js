// === Fungsi Hard Skill === //

function updateRemoveHardSkillButtons() {
  const rows = document.querySelectorAll(".hardSkillRow");
  rows.forEach((row, index) => {
    const removeButton = row.querySelector(".removeHardSkill");
    removeButton.style.display =
      rows.length > 1 && index > 0 ? "inline-block" : "none";
  });
}

document.getElementById("addHardSkill").addEventListener("click", function () {
  const container = document.getElementById("hardSkillContainer");
  const newRow = document.createElement("div");
  newRow.classList.add("hardSkillRow");
  newRow.innerHTML = `
                    <div id="hardSkillContainer">
                        <div class="hardSkillRow input-group mb-1">
                            <span class="input-group-text" id="inputGroup-sizing-default">Hard Skill</span>
                            <input type="text" placeholder="Masukkan Kemampuan Anda" class="form-control" name="hardskills[]" aria-label="Sizing example input"
                            aria-describedby="inputGroup-sizing-default">
                            <button type="button" class="removeHardSkill text-light bg-danger border-0 rounded-end" id="button-addon2">-</button>
                        </div>
                    </div>
              `;
  container.appendChild(newRow);

  newRow
    .querySelector(".removeHardSkill")
    .addEventListener("click", function () {
      newRow.remove();
      updateRemoveHardSkillButtons();
    });

  updateRemoveHardSkillButtons();
});

document.querySelectorAll(".removeHardSkill").forEach((button) => {
  button.addEventListener("click", function () {
    button.parentElement.remove();
    updateRemoveHardSkillButtons();
  });
});

updateRemoveHardSkillButtons();
