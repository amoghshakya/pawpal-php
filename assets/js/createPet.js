const vaccinatedRadios = document.querySelectorAll('input[name="vaccinated"]');
const container = document.getElementById("vaccination-details-container");
const detailsInput = document.getElementById("vaccination_details");

if (document.getElementById("vaccinated_yes").checked) {
  container.classList.remove("hidden");
  detailsInput.required = true;
} else {
  container.classList.add("hidden");
  detailsInput.required = false;
}

vaccinatedRadios.forEach((radio) => {
  radio.addEventListener("change", () => {
    if (document.getElementById("vaccinated_yes").checked) {
      container.classList.remove("hidden");
      detailsInput.required = true;
    } else {
      container.classList.add("hidden");
      detailsInput.required = false;
    }
  });
});

const form = document.getElementById("create-pet-form");
form.addEventListener("submit", (e) => {
  // Serialize captions map to object
  const captionsObj = {};
  for (const [key, value] of Object.entries(captions)) {
    captionsObj[key] = value;
  }

  // Update hidden input value
  document.getElementById("captions_json").value = JSON.stringify(captionsObj);
});

const files = []; // We store the uploaded files here temporarily
// const captions = []; // and captions here
const captions = new Map(); // we map file => caption for easier access

const fileInput = document.getElementById("image");
const dropZone = document.getElementById("drop-zone");
const previewZone = document.getElementById("preview-container");

// Modal
let currentEditingIndex = null;
const modal = document.getElementById("caption-modal");
const modalInput = document.getElementById("caption-modal-input");
const saveBtn = document.getElementById("caption-save-btn");
const cancelBtn = document.getElementById("caption-cancel-btn");

const removeStyles = () => {
  dropZone.style.backgroundColor = "";
  dropZone.style.borderColor = "rgba(17, 24, 39, 0.25)";
};

const addStyles = () => {
  dropZone.style.backgroundColor = "#e5e7eb";
  dropZone.style.borderColor = "#111827";
};

const showPreview = (file, index) => {
  const reader = new FileReader();

  reader.onload = (event) => {
    // container
    const wrapper = document.createElement("div");
    wrapper.classList.add("thumbnail-wrapper");

    // image
    const img = document.createElement("img");
    img.src = event.target.result;
    img.draggable = false;
    img.classList.add("thumbnail");
    img.alt = file.name;

    // buttons
    const removeButton = document.createElement("button");
    removeButton.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"> <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" /></svg>`;
    removeButton.type = "button";
    removeButton.classList.add("remove-btn");
    removeButton.addEventListener("click", () => {
      files.splice(index, 1); // remove from array
      const key = `${file.name}-${file.size}`;
      delete captions[key];
      syncInputFiles();
      updatePreviews();
    });
    const editButton = document.createElement("button");
    editButton.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>`;
    editButton.type = "button";
    editButton.classList.add("edit-btn");
    editButton.addEventListener("click", () => {
      currentEditingIndex = index;
      const key = `${file.name}-${file.size}`;
      modalInput.value = captions[key] || "";

      const reader = new FileReader();
      reader.onload = (e) => {
        document.getElementById("caption-modal-image").src = e.target.result;
        modal.classList.add("flex");
        modal.classList.remove("hidden");
      };
      reader.readAsDataURL(file);
    });

    wrapper.appendChild(img);
    wrapper.appendChild(removeButton);
    wrapper.appendChild(editButton);
    previewZone.appendChild(wrapper);
  };

  if (file.type.startsWith("image/")) {
    reader.readAsDataURL(file);
  }
};

// helper to regenerate all previews
const updatePreviews = () => {
  previewZone.innerHTML = ""; // Clear all previews
  files.forEach((file, i) => showPreview(file, i));
};

// helper to sync input element
const syncInputFiles = () => {
  const dataTransfer = new DataTransfer();
  files.forEach((file) => dataTransfer.items.add(file));
  fileInput.files = dataTransfer.files;
};

dropZone.addEventListener("dragover", (event) => {
  const items = event.dataTransfer.items;
  const isOnlyImages = [...items].every(
    (item) => item.kind === "file" && item.type.startsWith("image/"),
  );

  if (isOnlyImages) {
    event.preventDefault(); // Allow drop
    addStyles();
  } else {
    removeStyles(); // reset styling if invalid drag
  }
});

dropZone.addEventListener("dragleave", removeStyles);

dropZone.addEventListener("drop", (event) => {
  event.preventDefault(); // same thing, prevent from being opened
  const items = event.dataTransfer.items;

  if (items) {
    [...items].forEach((item) => {
      if (item.kind === "file" && item.type.startsWith("image/")) {
        const file = item.getAsFile();

        // avoid duplicates
        const exists = files.some(
          (f) => f.name === file.name && f.size === file.size,
        );
        if (!exists) {
          files.push(file);
        }
      }
    });
  }

  syncInputFiles();
  updatePreviews();
  removeStyles();
});

// another thing to worry about is to also listen to the input
// so we update the previews when the user just uses the input
fileInput.addEventListener("change", (event) => {
  const selected = [...event.target.files];

  selected.forEach((file) => {
    if (file.type.startsWith("image/")) {
      const exists = files.some(
        (f) => f.name === file.name && f.size === file.size,
      );
      if (!exists) {
        files.push(file);
      }
    }
  });

  syncInputFiles();
  updatePreviews();
});

// Modal button logic
saveBtn.addEventListener("click", () => {
  if (currentEditingIndex !== null) {
    const file = files[currentEditingIndex];
    const key = `${file.name}-${file.size}`;
    captions[key] = modalInput.value;

    modal.classList.remove("flex");
    modal.classList.add("hidden");
    updatePreviews();
    currentEditingIndex = null;
  }
});

cancelBtn.addEventListener("click", () => {
  modal.classList.remove("flex");
  modal.classList.add("hidden");
  currentEditingIndex = null;
});
