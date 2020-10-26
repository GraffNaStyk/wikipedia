import * as App from '../../app.js';

let callback = () => {
  let headerCount = 0;
  let rowCount = 0;
  const HeaderContainer = document.querySelector(`.table-item-${document.currentCounter} .for__headers`);
  const BodyContainer = document.querySelector(`.table-item-${document.currentCounter} .for__body`);

  App.on('click', `.table-item-${document.currentCounter} .add__record`, () => {
    let html = `<div data-item="${rowCount}">`;
    for (let i = 0; i < headerCount; i++) {
      html += `<label>
               <input style="width: 150px;" class="form-control" type="text" data-headercount="${i}" name="body[${rowCount}][${i}]">
               </label>`
    }
    html += `</div>`;
    BodyContainer.insertAdjacentHTML(`afterbegin`, html + '<br>');
    rowCount++;
  })

  App.on('click', `.table-item-${document.currentCounter} .add__header`, () => {
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

  App.on('click', `.table-item-${document.currentCounter--} button[data-remove="${headerCount}"]`, (e) => {
    if (confirm(`Czy na pewno chcesz usunąć rekord?`)) {
      if (e.target.dataset.remove !== null) {
        Array.from(document.querySelectorAll(`.table-item-${document.currentCounter} [data-headercount="${e.target.dataset.remove}"]`)).forEach((e) => {
          e.remove();
        })
      }
      document.querySelector(`.table-item-${document.currentCounter} label[data-remove="${e.target.dataset.remove}"]`).remove();
      headerCount--;
      rowCount--;
    }
  });
  headerCount++;
});
  document.currentCounter = document.querySelector('.table__renderer').dataset.counter;
}

App.afterRender(callback);

App.beforeRender(() => {
  let button = document.querySelector('.table__renderer');
  let tmp = button.dataset.url.split('/');
  button.dataset.url = '';
  button.dataset.counter = parseInt(button.dataset.counter)+1;
  button.dataset.url = tmp[0]+'/'+tmp[1]+'/'+button.dataset.counter;
  if (document.currentCounter === undefined) {
    document.currentCounter = 1;
  }
});
