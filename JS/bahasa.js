function updateRemoveCommunicationLanguageButtons() {
    const rows = document.querySelectorAll(".languageRow");
    rows.forEach((row, index) => {
      const removeButton = row.querySelector(".removeLanguageCommunication");
      removeButton.style.display = rows.length > 1 && index > 0 ? "inline-block" : "none";
    });
  }
  
  document.getElementById("addComLanguage").addEventListener("click", function () {
    const container = document.getElementById("languageContainer");
    const newRow = document.createElement("div");
    newRow.classList.add("languageRow", "input-group", "mb-1");
    newRow.innerHTML = `
      <span class="input-group-text" id="inputGroup-sizing-default">Bahasa</span>
      <input type="text" placeholder="Keahlian Bahasa" class="form-control" name="communication_languages[]" aria-label="Sizing example input"
      aria-describedby="inputGroup-sizing-default">
      <select name="communication_levels[]" class="form-select">
          <option value="" disabled selected>Pilih Level</option>
          <option value="Beginner">Beginner</option>
          <option value="Intermediate">Intermediate</option>
          <option value="Advanced">Advanced</option>
      </select>
      <button type="button" class="removeLanguageCommunication text-light bg-danger border-0 rounded-end ms-2">-</button>
    `;
    container.appendChild(newRow);
  
    newRow.querySelector(".removeLanguageCommunication").addEventListener("click", function () {
      newRow.remove();
      updateRemoveCommunicationLanguageButtons();
    });
  
    updateRemoveCommunicationLanguageButtons();
  });
  
  document.querySelectorAll(".removeLanguageCommunication").forEach((button) => {
    button.addEventListener("click", function () {
      button.parentElement.remove();
      updateRemoveCommunicationLanguageButtons();
    });
  });
  
  updateRemoveCommunicationLanguageButtons();