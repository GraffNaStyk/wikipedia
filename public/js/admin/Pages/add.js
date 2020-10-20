import * as App from '../../app.js';

const HeaderContainer = document.querySelector('.for__headers');
const BodyContainer = document.querySelector('.for__body');
let headerCount = 0;
let rowCount = 0;

App.on('click', '.add__header', () => {
  HeaderContainer.insertAdjacentHTML(`beforeend`, `<label data-remove="${headerCount}" style="position: relative;">
   <input style="width: 150px;" class="form-control" type="text" name="header[${headerCount}]">
   <button data-remove="${headerCount}"
    class="remove__header" 
    type="button"
    style="position: absolute; background: red; color: white; width: 20px; right:0; top: 10px; padding: 0;"> 
     -
    </button>
   </label>
`);

  App.on('click', `button[data-remove="${headerCount}"]`, (e) => {
    if (confirm(`Czy na pewno chcesz usunąć rekord?`)) {
      if (e.target.dataset.remove !== null) {
        Array.from(document.querySelectorAll(`[data-headercount="${e.target.dataset.remove}"]`)).forEach((e) => {
          e.remove();
        })
      }
      document.querySelector(`label[data-remove="${e.target.dataset.remove}"]`).remove();
      headerCount--;
      rowCount--;
    }
  });
  Array.from(document.querySelectorAll(`div[data-item]`)).forEach((item) => {
    Array.from(item.childNodes).forEach((node) => {
      console.log(node);
    })
  });
  headerCount++;
});

App.on('click', '.add__record', () => {
  let html = `<div data-item="${rowCount}">`;
  for (let i = 0; i < headerCount; i++) {
    html += `<label>
   <input style="width: 150px;" class="form-control" type="text" data-headercount="${i}" name="body[${rowCount}][${i}]">
   </label>`
  }
  html += `<div>`;
  BodyContainer.insertAdjacentHTML(`afterbegin`, html+'<br>');
  rowCount++;
})
