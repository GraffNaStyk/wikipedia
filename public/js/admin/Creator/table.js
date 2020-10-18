import * as App from '../../app.js';

const HeaderContainer = document.querySelector('.for__headers');
const BodyContainer = document.querySelector('.for__body');
let headerCount = 0;
let rowCount = 0;
App.on('click', '.add__header', () => {
  headerCount++
  HeaderContainer.insertAdjacentHTML(`beforeend`, `<label>
   <input style="width: 150px;" class="form-control" type="text" name="header[${headerCount}]">
   </label>
`);
});

App.on('click', '.add__record', () => {
  let html = '';
  for (let i = 0; i < headerCount; i++) {
    html += `<label>
   <input style="width: 150px;" class="form-control" type="text" name="body[${rowCount}][${i}]">
   </label>`
  }
  BodyContainer.insertAdjacentHTML(`afterbegin`, html+'<br>');
  rowCount++;
})
