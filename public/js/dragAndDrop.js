const draggables = document.querySelectorAll(".navbar-drag-item");
const dragContainer = document.querySelector(".drag-container");

draggables.forEach((draggable) => {
  draggable.addEventListener("dragstart", () => {
    draggable.classList.add("navbar-drag-item-dragging");
  });
});
draggables.forEach((draggable) => {
  draggable.addEventListener("dragend", () => {
    draggable.classList.remove("navbar-drag-item-dragging");
  });
});

dragContainer.addEventListener("dragover", (e) => {
  e.preventDefault();
  const afterElement = getDragAfterElement(e.clientY);
  const currentlyDraggedItem = document.querySelector(
    ".navbar-drag-item-dragging"
  );
  if (afterElement == null) {
    dragContainer.appendChild(currentlyDraggedItem);
  } else {
    dragContainer.insertBefore(currentlyDraggedItem, afterElement);
  }
});

const getDragAfterElement = (y) => {
  const draggableElements = [
    ...dragContainer.querySelectorAll(
      ".navbar-drag-item:not(.navbar-drag-item-dragging)"
    ),
  ];

  return draggableElements.reduce(
    (closest, child) => {
      const box = child.getBoundingClientRect();
      const offset = y - box.top - box.height / 2;
      if (offset < 0 && offset > closest.offset) {
        return { offset: offset, element: child };
      } else {
        return closest;
      }
    },
    { offset: Number.NEGATIVE_INFINITY }
  ).element;
};
