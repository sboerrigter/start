const menu = document.querySelector('.menu');
const toggle = document.querySelector('.menu-toggle');
const items = document.querySelectorAll('.menu-item');

// Toggle menu
if (toggle) {
  toggle.addEventListener('click', () => {
    menu.classList.toggle('menu-open');
    toggle.classList.toggle('menu-toggle-open');
  });
}

// Toggle submenu items
items.forEach((item) => {
  const toggle = item.querySelector('.menu-item-toggle');

  if (toggle) {
    toggle.addEventListener('click', () => {
      item.classList.toggle('menu-item-open');
    });
  }
});
