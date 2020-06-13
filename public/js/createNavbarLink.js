const btnInternal = document.querySelector("#btn-internal");
const btnExternal = document.querySelector("#btn-external");

const internalInputField = document.querySelector(
  ".add-internal-link-form-link"
);
const internalInput = document.querySelector(
  ".add-internal-link-form-link input"
);

const externalInputField = document.querySelector(
  ".add-external-link-form-link"
);
const externalInput = document.querySelector(
  ".add-external-link-form-link input"
);

let internalLink = true;

const activeClassName = "btn btn-dark";
const inActiveClassName = "btn btn-light";

/*====================
EVENT LISTENERS
====================*/
btnInternal.addEventListener("click", () => {
  if (!internalLink) {
    changeLinkDestination();
    changeVisibleInputFields();
  }
});

btnExternal.addEventListener("click", () => {
  if (internalLink) {
    changeLinkDestination();
    changeVisibleInputFields();
  }
});

/*======================
CHANGE CLASSES ON CLICK
======================*/
const changeLinkDestination = () => {
  internalLink = !internalLink;
  if (internalLink) {
    btnInternal.classList.value = "btn btn-dark";
    btnExternal.classList.value = "btn btn-light";
  } else if (!internalLink) {
    btnInternal.classList.value = "btn btn-light";
    btnExternal.classList.value = "btn btn-dark";
  }
};

/*=========================
CHANGE VISIBLE INPUT FIELDS
=========================*/
const changeVisibleInputFields = () => {
  if (internalLink) {
    internalInputField.classList.remove("hidden");
    externalInputField.classList.add("hidden");
    externalInput.value = "";
  } else if (!internalLink) {
    internalInputField.classList.add("hidden");
    externalInputField.classList.remove("hidden");
    internalInput.value = "";
  }
};
