// === Fungsi Tools === //

function updateRemoveToolButtons() {
  const rows = document.querySelectorAll(".toolsRow");
  rows.forEach((row, index) => {
    const removeButton = row.querySelector(".removeTool");
    removeButton.style.display = rows.length > 1 && index > 0 ? "inline-block" : "none";
  });
}

document.getElementById("addTool").addEventListener("click", function () {
  const container = document.getElementById("toolsContainer");
  const newRow = document.createElement("div");
  newRow.classList.add("toolsRow");
  newRow.innerHTML = `
                    <div id="toolsContainer">
                        <div class="toolsRow input-group mb-1">
                            <span class="input-group-text" id="inputGroup-sizing-default">Tools</span>
                            <input type="text" placeholder="Tools atau Software yang sering Anda Gunakan" class="form-control" name="tools[]" aria-label="Sizing example input"
                            aria-describedby="inputGroup-sizing-default">
                            <button type="button" class="removeTool text-light bg-danger border-0 rounded-end">-</button>
                        </div>
                    </div>
            `;
  container.appendChild(newRow);

  newRow.querySelector(".removeTool").addEventListener("click", function () {
    newRow.remove();
    updateRemoveToolButtons();
  });

  updateRemoveToolButtons();
});

document.querySelectorAll(".removeTool").forEach((button) => {
  button.addEventListener("click", function () {
    button.parentElement.remove();
    updateRemoveToolButtons();
  });
});

updateRemoveToolButtons();
